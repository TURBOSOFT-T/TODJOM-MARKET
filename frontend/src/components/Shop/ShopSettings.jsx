import React, { useState, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import axios from "axios";
import { AiOutlineCamera } from "react-icons/ai";
import { toast } from "react-toastify";

import { server } from "../../server";
import styles from "../../styles/styles";
import { loadSeller } from "../../redux/actions/seller";

const ShopSettings = () => {
  const { seller } = useSelector((state) => state.seller);
  const dispatch = useDispatch();

  // =========================
  // STATE
  // =========================
  const [avatar, setAvatar] = useState(null);
  const [name, setName] = useState("");
  const [description, setDescription] = useState("");
  const [adresse, setAdresse] = useState("");
  const [phone, setPhone] = useState("");

  // =========================
  // SYNC REDUX → STATE
  // =========================
  useEffect(() => {
    if (seller) {
      setName(seller.name || "");
      setDescription(seller.description || "");
      setAdresse(seller.adresse || "");
      setPhone(seller.phone || "");
    }
  }, [seller]);

  const SHOP_TOKEN = localStorage.getItem("shop_token");

  // =========================
  // AVATAR URL
  // =========================
  const shopAvatar = seller?.avatar
    ? `http://localhost:8000/Image/Shops/${seller.avatar}`
    : "https://shopo.quomodothemes.website/assets/images/user-1.jpg";

  // =========================
  // UPDATE AVATAR
  // =========================
  const handleImage = (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();

    reader.onload = async () => {
      if (reader.readyState === 2) {
        setAvatar(reader.result);

        try {
          await axios.put(
            `${server}/update-shop-avatar`,
            { avatar: reader.result },
            {
              headers: {
                Authorization: `Bearer ${SHOP_TOKEN}`,
                Accept: "application/json",
              },
            }
          );

          toast.success("Avatar updated successfully");
          dispatch(loadSeller());
        } catch (error) {
          console.log(error);
          toast.error(error.response?.data?.message || "Upload failed");

          if (error.response?.status === 401) {
            localStorage.removeItem("shop_token");
          }
        }
      }
    };

    reader.readAsDataURL(file);
  };

  // =========================
  // UPDATE SHOP INFO
  // =========================
  const updateHandler = async (e) => {
    e.preventDefault();

    try {
      await axios.put(
        `${server}/update-seller-info`,
        {
          name,
          description,
          adresse,
          phone,
        },
        {
          headers: {
            Authorization: `Bearer ${SHOP_TOKEN}`,
            Accept: "application/json",
          },
        }
      );

      toast.success("Shop updated successfully");
      dispatch(loadSeller());
    } catch (error) {
      console.log(error);
      toast.error(error.response?.data?.message || "Update failed");

      if (error.response?.status === 401) {
        localStorage.removeItem("shop_token");
      }
    }
  };

  // =========================
  // UI
  // =========================
  return (
    <div className="w-full min-h-screen flex flex-col items-center">
      <div className="w-full 800px:w-[80%] flex flex-col my-5">

        {/* AVATAR */}
        <div className="flex justify-center relative">
          <img
            src={avatar ? avatar : shopAvatar}
            alt="shop avatar"
            className="w-[200px] h-[200px] rounded-full object-cover"
          />

          <div className="absolute bottom-3 right-[40%] bg-gray-200 p-2 rounded-full cursor-pointer">
            <input
              type="file"
              id="avatar"
              className="hidden"
              accept="image/*"
              onChange={handleImage}
            />
            <label htmlFor="avatar">
              <AiOutlineCamera />
            </label>
          </div>
        </div>

        {/* FORM */}
        <form
          onSubmit={updateHandler}
          className="flex flex-col items-center mt-6"
        >

          <div className="w-full 800px:w-[50%] mt-4">
            <label>Shop Name</label>
            <input
              className={styles.input}
              value={name}
              onChange={(e) => setName(e.target.value)}
            />
          </div>

          <div className="w-full 800px:w-[50%] mt-4">
            <label>Description</label>
            <input
              className={styles.input}
              value={description}
              onChange={(e) => setDescription(e.target.value)}
            />
          </div>

          <div className="w-full 800px:w-[50%] mt-4">
            <label>Adresse</label>
            <input
              className={styles.input}
              value={adresse}
              onChange={(e) => setAdresse(e.target.value)}
            />
          </div>

          <div className="w-full 800px:w-[50%] mt-4">
            <label>Phone</label>
            <input
              type="number"
              className={styles.input}
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
            />
          </div>

          <button
            type="submit"
            className="w-[250px] h-[45px] bg-[#3321c8] text-white rounded-md mt-6"
          >
            Update Shop
          </button>

        </form>
      </div>
    </div>
  );
};

export default ShopSettings;
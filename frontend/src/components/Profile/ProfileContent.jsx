import React, { useState, useEffect } from "react";
import { AiOutlineCamera } from "react-icons/ai";
import { useSelector } from "react-redux";
import axios from "axios";
import toast, { Toaster } from "react-hot-toast";
import styles from "../../styles/styles";

const ProfileContent = ({ active }) => {
  const { user } = useSelector((state) => state.user);

  const [nom, setNom] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [adresse, setAdresse] = useState("");

  const [avatar, setAvatar] = useState(null);
  const [preview, setPreview] = useState(null);

  const [loading, setLoading] = useState(false);

  // Load user data
  useEffect(() => {
    if (user) {
      setNom(user.nom || "");
      setEmail(user.email || "");
      setPhone(user.phone || "");
      setAdresse(user.adresse || "");
    }
  }, [user]);

  // Image change
  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setAvatar(file);
      setPreview(URL.createObjectURL(file));
    }
  };

  // Submit update
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      setLoading(true);

      const token = localStorage.getItem("token");

      const formData = new FormData();
      formData.append("nom", nom);
      formData.append("email", email);
      formData.append("phone", phone);
      formData.append("adresse", adresse);

      if (avatar) {
        formData.append("avatar", avatar);
      }

      const res = await axios.post(
        "http://localhost:8000/api/update-profile",
        formData,
        {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "multipart/form-data",
          },
        }
      );

      toast.success(res.data.message);
    } catch (error) {
      console.log(error);
      toast.error(error.response?.data?.message || "Erreur serveur");
    } finally {
      setLoading(false);
    }
  };

 /*  if (!user) {
    return (
      <h2 className="text-center mt-10">Chargement du profil...</h2>
    );
  } */

  const avatarUrl = user?.avatar
    ? `http://localhost:8000/Image/Users/${user.avatar}`
    : "https://shopo.quomodothemes.website/assets/images/user-1.jpg";

  return (
    <>
      <Toaster position="top-right" />

      <div className="w-full">
        {active === 1 && (
          <>
            {/* AVATAR */}
            <div className="flex justify-center w-full">
              <div className="relative">
                <img
                  src={preview || avatarUrl}
                  className="w-[150px] h-[150px] rounded-full object-cover border-[3px] border-[#3ad132]"
                  alt="profile"
                />

                <div className="w-[35px] h-[35px] bg-[#E3E9EE] rounded-full flex items-center justify-center cursor-pointer absolute bottom-[5px] right-[5px] shadow-md">
                  <label htmlFor="avatarUpload" className="cursor-pointer">
                    <AiOutlineCamera />
                  </label>

                  <input
                    id="avatarUpload"
                    type="file"
                    accept="image/*"
                    className="hidden"
                    onChange={handleImageChange}
                  />
                </div>
              </div>
            </div>

            <br />
            <br />

            {/* FORM */}
            <div className="w-full px-5">
              <form onSubmit={handleSubmit}>
                <div className="w-full 800px:flex block pb-3">
                  <div className="w-full 800px:w-[50%]">
                    <label className="block pb-2">Full Name</label>
                    <input
                      type="text"
                      className={`${styles.input} !w-[95%]`}
                      value={nom}
                      onChange={(e) => setNom(e.target.value)}
                    />
                  </div>

                  <div className="w-full 800px:w-[50%]">
                    <label className="block pb-2">Email</label>
                    <input
                      type="email"
                      className={`${styles.input} !w-[95%]`}
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                    />
                  </div>
                </div>

                <div className="w-full 800px:flex block pb-3">
                  <div className="w-full 800px:w-[50%]">
                    <label className="block pb-2">Phone</label>
                    <input
                      type="text"
                      className={`${styles.input} !w-[95%]`}
                      value={phone}
                      onChange={(e) => setPhone(e.target.value)}
                    />
                  </div>

                  <div className="w-full 800px:w-[50%]">
                    <label className="block pb-2">Address</label>
                    <input
                      type="text"
                      className={`${styles.input} !w-[95%]`}
                      value={adresse}
                      onChange={(e) => setAdresse(e.target.value)}
                    />
                  </div>
                </div>

                {/* BUTTON */}
                <button
                  type="submit"
                  disabled={loading}
                  className="w-[250px] h-[45px] bg-[#3321c8] text-white rounded-md mt-6"
                >
                  {loading ? "Updating..." : "Update Profile"}
                </button>
              </form>
            </div>
          </>
        )}
      </div>
    </>
  );
};

export default ProfileContent;
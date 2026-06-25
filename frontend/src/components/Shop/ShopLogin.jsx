import React, { useState } from "react";
import {
  AiOutlineEye,
  AiOutlineEyeInvisible,
} from "react-icons/ai";

import styles from "../../styles/styles";
import { Link, useNavigate } from "react-router-dom";

import axios from "axios";

import { toast } from "react-toastify";

const ShopLogin = () => {
  const navigate = useNavigate();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const [visible, setVisible] = useState(false);

  const [loading, setLoading] = useState(false);

  // LOGIN
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      setLoading(true);

      const res = await axios.post(
        "http://localhost:8000/api/login-shop",
        {
          email,
          password,
        },
        {
          headers: {
            Accept: "application/json",
          },
        }
      );
console.log(localStorage.getItem("shop_token"));
      console.log("SHOP LOGIN:", res.data);

      // SAVE TOKEN
      localStorage.setItem("shop_token", res.data.token);

      // SAVE SHOP
      localStorage.setItem(
        "shop",
        JSON.stringify(res.data.shop)
      );

      toast.success("Connexion réussie");

      // REDIRECT
      
      navigate("/dashboard");
       window.location.reload(true); 

    } catch (err) {
      console.log(err);

      if (err.response?.data?.message) {
        toast.error(err.response.data.message);
      } else {
        toast.error("Erreur serveur");
      }

    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">

      {/* TITLE */}
      <div className="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 className="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Login to your shop
        </h2>
      </div>

      {/* CARD */}
      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div className="bg-white py-8 px-4 shadow-lg rounded-lg sm:px-10">

          <form className="space-y-6" onSubmit={handleSubmit}>

            {/* EMAIL */}
            <div>
              <label className="block text-sm font-medium text-gray-700">
                Email address
              </label>

              <div className="mt-1">
                <input
                  type="email"
                  required
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="Enter your email"
                  className="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                />
              </div>
            </div>

            {/* PASSWORD */}
            <div>
              <label className="block text-sm font-medium text-gray-700">
                Password
              </label>

              <div className="mt-1 relative">
                <input
                  type={visible ? "text" : "password"}
                  required
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="Enter your password"
                  className="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                />

                {visible ? (
                  <AiOutlineEye
                    className="absolute right-3 top-2.5 cursor-pointer text-gray-600"
                    size={22}
                    onClick={() => setVisible(false)}
                  />
                ) : (
                  <AiOutlineEyeInvisible
                    className="absolute right-3 top-2.5 cursor-pointer text-gray-600"
                    size={22}
                    onClick={() => setVisible(true)}
                  />
                )}
              </div>
            </div>

            {/* REMEMBER */}
            <div className={`${styles.noramlFlex} justify-between`}>
              <div className={`${styles.noramlFlex}`}>
                <input
                  type="checkbox"
                  id="remember-me"
                  className="h-4 w-4 text-blue-600 border-gray-300 rounded"
                />

                <label
                  htmlFor="remember-me"
                  className="ml-2 block text-sm text-gray-900"
                >
                  Remember me
                </label>
              </div>

              <div className="text-sm">
                <Link
                  to="/shop/forgot-password"
                  className="font-medium text-blue-600 hover:text-blue-500"
                >
                  Forgot password?
                </Link>
              </div>
            </div>

            {/* BUTTON */}
            <div>
              <button
                type="submit"
                disabled={loading}
                className={`group relative w-full h-[45px] flex justify-center items-center border border-transparent text-sm font-medium rounded-md text-white transition ${
                  loading
                    ? "bg-gray-400 cursor-not-allowed"
                    : "bg-blue-600 hover:bg-blue-700"
                }`}
              >
                {loading ? "Loading..." : "Login"}
              </button>
            </div>

            {/* REGISTER */}
            <div className={`${styles.noramlFlex} w-full justify-center`}>
              <h4 className="text-sm">
                Don't have an account?
              </h4>

              <Link
                to="/shop-create"
                className="text-blue-600 pl-2 text-sm font-semibold"
              >
                Sign Up
              </Link>
            </div>

          </form>
        </div>
      </div>
    </div>
  );
};

export default ShopLogin;
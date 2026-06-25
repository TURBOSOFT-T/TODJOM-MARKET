import React, { useState } from "react";
import { AiOutlineEye, AiOutlineEyeInvisible } from "react-icons/ai";
import { Link } from "react-router-dom";
import { RxAvatar } from "react-icons/rx";
import axios from "axios";
import { server } from "../../server";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";


const Signup = () => {
  const [nom, setNom] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [cpassword, setCPassword] = useState("");
  const [visible, setVisible] = useState(false);
  const [avatar, setAvatar] = useState(null);
  const navigate = useNavigate();
  // IMAGE FILE
  const handleFileInputChange = (e) => {
    setAvatar(e.target.files[0]);
  };

  // SUBMIT FORM
  const handleSubmit = async (e) => {
    e.preventDefault();

    if (password !== cpassword) {
      toast.error("Passwords do not match");
      return;
    }

    const formData = new FormData();

    formData.append("nom", nom);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("password_confirmation", cpassword);

    if (avatar) {
      formData.append("avatar", avatar);
    }

    try {
      const res = await axios.post(`${server}/register`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
      setNom("");
      setEmail("");
      setPassword("");
      setCPassword("");
      setAvatar();

      toast.success(res.data.message || "Compte créé 🎉");

    navigate("/");
      
    } catch (error) {
      console.log(error.response?.data);

      const msg = error.response?.data?.errors;

      if (msg?.email) {
        toast.error("Cet email existe déjà");
      } else {
        toast.error("Erreur lors de l'inscription");
      }
      toast.error(error.response?.data?.message || "Registration failed");
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div className="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 className="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Register as a new user
        </h2>
      </div>

      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div className="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
          <form className="space-y-6" onSubmit={handleSubmit}>
            {/* NOM */}
            <div>
              <label className="block text-sm font-medium text-gray-700">
                Full Name
              </label>
              <input
                type="text"
                required
                value={nom}
                onChange={(e) => setNom(e.target.value)}
                className="w-full px-3 py-2 border rounded-md"
              />
            </div>

            {/* EMAIL */}
            <div>
              <label className="block text-sm font-medium text-gray-700">
                Email address
              </label>
              <input
                type="email"
                required
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="w-full px-3 py-2 border rounded-md"
              />
            </div>

            {/* PASSWORD */}
            <div className="relative">
              <label className="block text-sm font-medium text-gray-700">
                Password
              </label>

              <input
                type={visible ? "text" : "password"}
                required
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full px-3 py-2 border rounded-md"
              />

              <span
                className="absolute right-2 top-9 cursor-pointer"
                onClick={() => setVisible(!visible)}
              >
                {visible ? (
                  <AiOutlineEye size={22} />
                ) : (
                  <AiOutlineEyeInvisible size={22} />
                )}
              </span>
            </div>

            {/* CONFIRM PASSWORD */}
            <div className="relative">
              <label className="block text-sm font-medium text-gray-700">
                Confirm Password
              </label>

              <input
                type={visible ? "text" : "password"}
                required
                value={cpassword}
                onChange={(e) => setCPassword(e.target.value)}
                className="w-full px-3 py-2 border rounded-md"
              />
            </div>

            {/* AVATAR */}
            <div className="flex items-center gap-3">
              <span className="h-10 w-10 rounded-full overflow-hidden">
                {avatar ? (
                  <img
                    src={URL.createObjectURL(avatar)}
                    className="h-full w-full object-cover"
                    alt="avatar"
                  />
                ) : (
                  <RxAvatar className="h-10 w-10" />
                )}
              </span>

              <input type="file" accept="*" onChange={handleFileInputChange} />
            </div>

            {/* SUBMIT */}
            <button
              type="submit"
              className="w-full bg-blue-600 text-white py-2 rounded-md"
            >
              Submit
            </button>

            <div className="text-center">
              <h4>
                Already have an account?{" "}
                <Link to="/login" className="text-blue-600">
                  Sign In
                </Link>
              </h4>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Signup;

import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link } from "react-router-dom";
import { toast } from "react-toastify";

import {
  AiFillFacebook,
  AiOutlineWhatsApp,
} from "react-icons/ai";

import { FaTiktok } from "react-icons/fa";
import { FaFacebookMessenger } from "react-icons/fa";

import {
  footercompanyLinks,
  footerProductLinks,
} from "../../static/data";

const Footer = () => {
  const [config, setConfig] = useState(null);
  const [loading, setLoading] = useState(true);
  const [email, setEmail] = useState("");
 const year = new Date().getFullYear();

  const logoUrl = config?.logofooter
    ? `http://localhost:8000/storage/${config.logofooter}`
    : "https://shopo.quomodothemes.website/assets/images/logo.svg";

  // nettoyage numéro téléphone
  const phone = config?.telephone
    ? config.telephone.replace(/\D/g, "")
    : "";

  useEffect(() => {
    const fetchConfig = async () => {
      try {
        setLoading(true);

        const res = await axios.get("http://localhost:8000/api/config");

        setConfig(res.data.data);
      } catch (error) {
        console.log("Erreur API config:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchConfig();
  }, []);

 
  const safeLink = (url) => (url ? url : "#");

  if (loading) {
    /* return (
      <div className="bg-black text-white py-10 text-center">
        Chargement...
      </div>
    ); */
  }


  const handleSubscribe = async () => {
  if (!email) return alert("Email requis");

  try {
    setLoading(true);

    const res = await axios.post("http://localhost:8000/api/subscribe", {
      email,
    });

  
     toast.success(res.data.message || "Inscription réussie 🎉");
    setEmail("");
  } catch (error) {
    console.log(error);

    if (error.response?.data?.message) {
    
       toast.success(error.response.data.message);
    } else {
     
       toast.success("Erreur serveur");
    }
  } finally {
    setLoading(false);
  }
};

  return (
    <div className="bg-black text-white relative">

      {/* ===== FLOATING MESSENGER ===== */}
      <div className="fixed bottom-[160px] right-5 z-50">
        <a
          href={config?.messenger ? `https://m.me/${config.messenger}` : "#"}
          target="_blank"
          rel="noreferrer"
          className="w-[60px] h-[60px] bg-[#006AFF] border-2 border-white rounded-full flex items-center justify-center text-white text-2xl hover:bg-white hover:text-[#006AFF] transition"
        >
          <FaFacebookMessenger />
        </a>
      </div>

      {/* ===== FLOATING WHATSAPP ===== */}
      <div className="fixed bottom-[90px] right-5 z-50">
        <a
          href={phone ? `https://wa.me/${phone}` : "#"}
          target="_blank"
          rel="noreferrer"
          className="w-[60px] h-[60px] bg-[#25D366] border-2 border-white rounded-full flex items-center justify-center text-white text-2xl hover:bg-white hover:text-[#25D366] transition"
        >
          <AiOutlineWhatsApp />
        </a>
      </div>

  {/* ===== SUBSCRIBE ===== */}
<div className="bg-[#342ac8] px-6 py-10 md:flex md:items-center md:justify-between gap-6">

  {/* TEXT */}
  <h1 className="text-2xl md:text-3xl font-semibold md:w-2/5 leading-snug">
    <span className="text-green-400">Subscribe</span> to get news,
    <br /> events and offers
  </h1>

  {/* FORM */}
  <div className="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

    <input
      type="email"
      placeholder="Enter your email..."
      value={email}
      onChange={(e) => setEmail(e.target.value)}
      className="px-4 py-3 rounded-md text-black w-full sm:w-72 focus:outline-none"
    />

    <button
  onClick={handleSubscribe}
  disabled={loading}
  className="bg-green-400 hover:bg-green-500 px-6 py-3 rounded-md font-semibold"
>
  {loading ? "En cours..." : "Submit"}
</button>

  </div>
</div>



      {/* ===== MAIN FOOTER ===== */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-8 py-12">

        {/* LOGO + DESCRIPTION + SOCIAL */}
        <div>
          <img src={logoUrl} alt="logo" className="w-[120px]" />

          <p className="text-gray-400 mt-3">
            {config?.description ||
              "The home and elements needed to create beautiful products."}
          </p>

          {/* SOCIAL ICONS */}
          <div className="flex items-center mt-4 gap-4">

            <a href={safeLink(config?.facebook)} target="_blank" rel="noreferrer">
              <AiFillFacebook size={22} className="hover:text-blue-500" />
            </a>

            <a href={safeLink(config?.tiktok)} target="_blank" rel="noreferrer">
              <FaTiktok size={20} className="hover:text-pink-500" />
            </a>

            <a href={phone ? `https://wa.me/${phone}` : "#"} target="_blank" rel="noreferrer">
              <AiOutlineWhatsApp size={22} className="hover:text-green-500" />
            </a>

          </div>
        </div>

        {/* COMPANY */}
        <div>
          <h1 className="font-bold mb-2">Company</h1>
          {footerProductLinks.map((link, i) => (
            <li key={i} className="list-none text-gray-400">
              <Link to={link.link}>{link.name}</Link>
            </li>
          ))}
        </div>

        {/* SHOP */}
        <div>
          <h1 className="font-bold mb-2">Shop</h1>
          {footercompanyLinks.map((link, i) => (
            <li key={i} className="list-none text-gray-400">
              <Link to={link.link}>{link.name}</Link>
            </li>
          ))}
        </div>

        {/* CONTACT */}
        <div>
          <h1 className="font-bold mb-2">Contact</h1>

          <p className="text-gray-400">{config?.addresse}</p>
          <p className="text-gray-400">{config?.email}</p>
          <p className="text-gray-400">{config?.telephone}</p>
        </div>
      </div>

      {/* ===== BOTTOM ===== */}
      <div className="text-center text-gray-400 text-sm py-5 border-t border-gray-800">
        <span>© {year} TURBOSOFT. All rights reserved.</span>
      </div>

    </div>
  );
};

export default Footer;
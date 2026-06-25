import React, { useEffect } from "react";
import { useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import Login from "../components/Login/Login";

import Footer from "../components/Layout/Footer";
import Header from "../components/Layout/Header";

const LoginPage = () => {
  const navigate = useNavigate();
  const { isAuthenticated } = useSelector((state) => state.user);

  useEffect(() => {
    if (isAuthenticated === true) {
      console.log("Authenticated......");

     
      navigate("/");
       window.location.reload(true); 
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  return (
    <div>
      <Header />

      <Login />
      <Footer />
    </div>
  );
};

export default LoginPage;

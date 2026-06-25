import React from "react";
import DashboardHeader from "../../components/Shop/Layout/DashboardHeader";
import DashboardSideBar from "../../components/Shop/Layout/DashboardSideBar";

import styles from "../../styles/styles";
import Header from "../../components/Layout/Header";
import Footer from "../../components/Layout/Footer";

const ShopAllEvents = () => {
  return (
    <div>
      <Header />
      <DashboardHeader />
      <div className="flex justify-between w-full">
        <div className="w-[80px] 800px:w-[330px]">
          <DashboardSideBar active={5} />
        </div>
        <div className={`${styles.heading}`}>
          <h1>Popular Events</h1>
        </div>
        <div className="w-full justify-center flex">{/*  <AllEvents /> */}</div>
      </div>
      <Footer />
    </div>
  );
};

export default ShopAllEvents;

import React from "react";
import DashboardHeader from "../../components/Shop/Layout/DashboardHeader";
import DashboardSideBar from "../../components/Shop/Layout/DashboardSideBar";
import Header from "../../components/Layout/Header";
import Footer from "../../components/Layout/Footer";
import styles from "../../styles/styles";

const ShopAllOrders = () => {
  return (
    <div>
      <Header />
      <DashboardHeader />
      <div className="flex justify-between w-full">
        <div className="w-[80px] 800px:w-[330px]">
          <DashboardSideBar active={2} />
        </div>
        <div className={`${styles.heading}`}>
          <h1>ALL ORDERS</h1>
        </div>
        <div className="w-full justify-center flex"></div>
      </div>
      <Footer />
    </div>
  );
};

export default ShopAllOrders;

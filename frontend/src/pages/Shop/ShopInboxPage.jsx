import React from 'react'
import DashboardHeader from '../../components/Shop/Layout/DashboardHeader'
import DashboardSideBar from '../../components/Shop/Layout/DashboardSideBar'
import styles from "../../styles/styles";
import Header from '../../components/Layout/Header';
import Footer from '../../components/Layout/Footer';
const ShopInboxPage = () => {
  return (
    <div>
      <Header />
    <DashboardHeader />
    <div className="flex items-start justify-between w-full">
      <div className="w-[80px] 800px:w-[330px]">
        <DashboardSideBar active={8} />
      </div>
     <div className={`${styles.heading}`}>
          <h1>All messages</h1>
        </div>
    </div>
    <Footer />
  </div>
  )
}

export default ShopInboxPage
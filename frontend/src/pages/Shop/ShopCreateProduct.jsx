import React from 'react'
import DashboardHeader from '../../components/Shop/Layout/DashboardHeader'
import DashboardSideBar from '../../components/Shop/Layout/DashboardSideBar'
import Header from '../../components/Layout/Header'
import Footer from '../../components/Layout/Footer'
import CreateProduct from '../../components/Shop/CreateProduct'
const ShopCreateProduct = () => {
  return (
    <div>
      <Header />
        <DashboardHeader />
        <div className="flex items-center justify-between w-full">
            <div className="w-[80px] 800px:w-[330px]">
              <DashboardSideBar active={4} />
            </div>
            <div className="w-full justify-center flex">
                <CreateProduct />
              
            </div>
          </div>
          <Footer />
    </div>
  )
}

export default ShopCreateProduct
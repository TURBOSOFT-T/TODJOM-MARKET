import React from "react";

import { MdOutlineLocalOffer } from "react-icons/md";
import { FiPackage, FiShoppingBag } from "react-icons/fi";
import { useSelector } from "react-redux";
import { Link } from "react-router-dom";
import { BiMessageSquareDetail } from "react-icons/bi";


const DashboardHeader = () => {
  const { seller } = useSelector((state) => state.seller);
  // const userState = useSelector((state) => state.user);
  
   // const user = userState?.user || null;
   console.log("SELLER DASHBOARD :", seller);

     // IMAGE SHOP
  const shopAvatar = seller?.avatar
    ? `http://localhost:8000/Image/Shops/${seller.avatar}`
    : "https://shopo.quomodothemes.website/assets/images/user-1.jpg";

    

  return (
    <div className="w-full h-[80px] bg-white shadow sticky top-0 left-0 z-30 flex items-center justify-between px-4">
      <div>
        <Link to="/dashboard">
          <img
            src={shopAvatar}
             className="w-[35px] h-[35px] rounded-full object-cover border border-white"
                      alt="profile"
          />
        </Link>
      </div>
      <div className="flex items-center">
        <div className="flex items-center mr-4">
         
          <Link to="/dashboard-events" className="800px:block hidden">
            <MdOutlineLocalOffer
              color="#555"
              size={30}
              className="mx-5 cursor-pointer"
            />
          </Link>
          <Link to="/dashboard-products" className="800px:block hidden">
            <FiShoppingBag
              color="#555"
              size={30}
              className="mx-5 cursor-pointer"
            />
          </Link>
          <Link to="/dashboard-orders" className="800px:block hidden">
            <FiPackage color="#555" size={30} className="mx-5 cursor-pointer" />
          </Link>
          <Link to="/dashboard-messages" className="800px:block hidden">
            <BiMessageSquareDetail
              color="#555"
              size={30}
              className="mx-5 cursor-pointer"
            />
          </Link>
          <Link to={`/shop/${seller?._id}`}>
           

            <img
                      src={shopAvatar}
                      className="w-[35px] h-[35px] rounded-full object-cover border border-white"
                      alt="profile"
                    />
          </Link>
<br />
         

           
        </div>
      </div>
    </div>
  );
};

export default DashboardHeader;

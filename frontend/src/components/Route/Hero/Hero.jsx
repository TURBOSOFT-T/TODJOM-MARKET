import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { IoIosArrowForward } from "react-icons/io";
import { useSelector, useDispatch } from "react-redux";
import styles from "../../../styles/styles";
import { getAllBanners } from "../../../redux/actions/banner";

const Hero = () => {
  const dispatch = useDispatch();

  const isSeller = useSelector(
    (state) => state.seller?.isAuthenticated
  );

  const { banners = [] } = useSelector((state) => state.banner);

  const [current, setCurrent] = useState(0);

  // LOAD BANNERS
  useEffect(() => {
    dispatch(getAllBanners());
  }, [dispatch]);

  // AUTO SLIDER
  useEffect(() => {
    if (banners.length === 0) return;

    const interval = setInterval(() => {
      setCurrent((prev) => (prev + 1) % banners.length);
    }, 5000);

    return () => clearInterval(interval);
  }, [banners]);

  const banner = banners[current];

  const imageUrl = banner?.image
    ? `http://localhost:8000/storage/${banner.image}`
    : "https://themes.rslahmed.dev/rafcart/assets/images/banner-1.jpg";

  return (
    <div className="relative w-full overflow-hidden">

      {/* IMAGE BACKGROUND FIXE */}
      <div
        className="relative w-full h-[70vh] 800px:h-[80vh] bg-center bg-cover transition-all duration-700"
        style={{
          backgroundImage: `url(${imageUrl})`,
        }}
      >
        {/* DARK OVERLAY */}
        <div className="absolute inset-0 bg-black/40"></div>

        {/* CONTENT */}
        <br />
        <br />
        <div className={`${styles.section} relative z-10 w-[90%] 800px:w-[60%] text-white`}>

          <h1 className="text-[32px] 800px:text-[55px] font-[600] leading-tight">
            {banner?.titre || "Best Collection for Home Decoration"}
          </h1>

          <p className="pt-5 text-[16px] text-gray-200">
            {banner?.sous_titre ||
              "Discover amazing products at the best prices"}
          </p>
<br /><br />
          <Link to="/products" className="inline-block">
            <div className={`${styles.button} mt-5`}>
              <span className="text-white text-[18px]">
                Shop Now
              </span>
            </div>
          </Link>

          <div className={`${styles.button} w-[60%] 800px:w-[20%] mt-5`}>
            {isSeller ? (
              <Link to="/dashboard">
                <h1 className="text-white flex items-center">
                  Dashboard Seller
                  <IoIosArrowForward className="ml-1" />
                </h1>
              </Link>
            ) : (
              <Link to="/shop-create">
                <h1 className="text-white flex items-center">
                  Become Seller
                  <IoIosArrowForward className="ml-1" />
                </h1>
              </Link>
            )}
          </div>

          {/* DOTS */}
          {banners.length > 1 && (
            <div className="flex gap-2 mt-6">
              {banners.map((_, index) => (
                <div
                  key={index}
                  onClick={() => setCurrent(index)}
                  className={`w-3 h-3 rounded-full cursor-pointer transition ${
                    current === index ? "bg-white" : "bg-gray-400"
                  }`}
                />
              ))}
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default Hero;
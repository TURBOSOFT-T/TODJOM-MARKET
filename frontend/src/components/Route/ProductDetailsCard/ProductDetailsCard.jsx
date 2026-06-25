import React, { useState } from "react";
import { RxCross1 } from "react-icons/rx";
import { Link } from "react-router-dom";
import styles from "../../../styles/styles";
import {
  AiFillHeart,
  AiOutlineHeart,
  AiOutlineMessage,
  AiOutlineShoppingCart,
} from "react-icons/ai";
import { image } from "../../../server";

const ProductDetailsCard = ({ setOpen, data }) => {
  const [count, setCount] = useState(1);
  const [click, setClick] = useState(false);

  // 🔒 SAFE DATA
  const name = data?.nom || data?.name || "Produit";

  const price = data?.prix || data?.price || 0;

  const promoPercent = data?.promotion?.pourcentage || 0;

  const hasPromotion = promoPercent > 0;

  const finalPrice = hasPromotion
    ? price - (price * promoPercent) / 100
    : price;

  const stock = data?.stock || 0;

  const sold = data?.vendus_count || data?.total_sold || 0;
  //const sold = data?.vendus_count || 0;
//const totalSell = data?.total_sold || 0;


  const description =
    data?.description || "Aucune description disponible";

  const handleMessageSubmit = () => {};

  const decrementCount = () => {
    if (count > 1) setCount(count - 1);
  };

  const incrementCount = () => {
    setCount(count + 1);
  };
const handleClose = () => {
  setOpen(false);
};
  return (
    <div className="bg-[#fff]">
      {data && (
        <div className="fixed w-full h-screen top-0 left-0 bg-[#00000030] z-40 flex items-center justify-center"
        
         onClick={handleClose}
        >

          <div className="w-[90%] 800px:w-[60%] h-[90vh] overflow-y-scroll 800px:h-[75vh] bg-white rounded-md shadow-sm relative p-4"
          
          >

           
            <RxCross1
              size={30}
              className="absolute right-3 top-3 z-50 cursor-pointer"
              onClick={() => setOpen(false)}
            />

            <div className="block w-full 800px:flex">

              {/* LEFT SIDE */}
              <div className="w-full 800px:w-[50%]">

                {/* IMAGE */}
                <img
                  src={
                    data?.photo
                      ? `${image}/storage/${data.photo}`
                      : "https://via.placeholder.com/300"
                  }
                  alt=""
                  className="w-full h-[250px] object-contain"
                />

                {/* SHOP */}
                <div className="flex mt-3">
                  <Link
                    to={`/shop/preview/${data?.shop?._id}`}
                    className="flex items-center"
                  >
                    <img
                      src={
                        data?.shop?.shop_avatar?.url ||
                        "https://via.placeholder.com/50"
                      }
                      alt=""
                      className="w-[50px] h-[50px] rounded-full mr-2"
                    />

                    <div>
                      <h3 className={styles.shop_name}>
                        {data?.shop?.name || "Boutique"}
                      </h3>
                      <h5 className="text-[15px]">
                        {data?.shop?.ratings || 0} Ratings
                      </h5>
                    </div>
                  </Link>
                </div>

                {/* MESSAGE */}
                <div
                  className={`${styles.button} bg-[#000] mt-4 rounded-[4px] h-11`}
                  onClick={handleMessageSubmit}
                >
                  <span className="text-[#fff] flex items-center justify-center">
                    Send Message <AiOutlineMessage className="ml-1" />
                  </span>
                </div>

                {/* SOLD */}
                <h5 className="text-[16px] text-[red] mt-5">
                  ({sold}) Sold
                </h5>
              </div>

              {/* RIGHT SIDE */}
              <div className="w-full 800px:w-[50%] pt-5 pl-[10px]">

                {/* NAME */}
                <h1 className={`${styles.productTitle} text-[20px]`}>
                  {name}
                </h1>

                {/* DESCRIPTION */}
                <p className="mt-2 text-gray-700">
                  {description}
                </p>

                {/* PRICE */}
                <div className="flex pt-3 items-center gap-2">

                  {hasPromotion ? (
                    <>
                      <h4 className={styles.productDiscountPrice}>
                        {finalPrice.toFixed(2)}$
                      </h4>

                      <h3 className="line-through text-red-500 font-semibold">
                        {price}$
                      </h3>

                      <span className="text-red-600 font-bold">
                        -{promoPercent}%
                      </span>
                    </>
                  ) : (
                    <h4 className={styles.productDiscountPrice}>
                      {price}$
                    </h4>
                  )}

                </div>

                {/* STOCK */}
                <p className="mt-2">
                  Stock :
                  <span
                    className={
                      stock > 0 ? "text-green-600" : "text-red-600"
                    }
                  >
                    {stock > 0
                      ? stock + " disponible"
                      : "Rupture"}
                  </span>
                </p>

                {/* QUANTITY + WISHLIST */}
                <div className="flex items-center mt-8 justify-between pr-3">

                  {/* QTY */}
                  <div>
                    <button
                      className="bg-teal-500 text-white px-4 py-2"
                      onClick={decrementCount}
                    >
                      -
                    </button>

                    <span className="bg-gray-200 px-4 py-2">
                      {count}
                    </span>

                    <button
                      className="bg-teal-500 text-white px-4 py-2"
                      onClick={incrementCount}
                    >
                      +
                    </button>
                  </div>

                  {/* WISHLIST */}
                  <div>
                    {click ? (
                      <AiFillHeart
                        size={30}
                        color="red"
                        onClick={() => setClick(false)}
                      />
                    ) : (
                      <AiOutlineHeart
                        size={30}
                        onClick={() => setClick(true)}
                      />
                    )}
                  </div>

                </div>

                {/* ADD TO CART */}
                <div
                  className={`${styles.button} mt-6 rounded-[4px] h-11 flex items-center justify-center`}
                >
                  <span className="text-white flex items-center">
                    Add to cart{" "}
                    <AiOutlineShoppingCart className="ml-1" />
                  </span>
                </div>

              </div>
            </div>
          </div>

        </div>
      )}
    </div>
  );
};

export default ProductDetailsCard;
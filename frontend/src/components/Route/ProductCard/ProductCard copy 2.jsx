import React, { useState } from "react";
import {
  AiFillHeart,
  AiFillStar,
  AiOutlineEye,
  AiOutlineHeart,
  AiOutlineShoppingCart,
  AiOutlineStar,
} from "react-icons/ai";
import { Link } from "react-router-dom";
import styles from "../../../styles/styles";
import ProductDetailsCard from "../ProductDetailsCard/ProductDetailsCard";
import { server } from "../../../server";
import { useDispatch } from "react-redux";
import { addToCart } from "../../../redux/reducers/cart";
import { toast } from "react-toastify";

const ProductCard = ({ data }) => {
  const [click, setClick] = useState(false);
  const [open, setOpen] = useState(false);

  const dispatch = useDispatch();

  // SAFE DATA
  const name = data?.nom || "Produit";
  const product_name = name.replace(/\s+/g, "-");

  const shopName = data?.shop?.name || "Boutique";

  const price = data?.prix || 0;
  const finalPrice = data?.final_price || price;

  const totalSell = data?.total_sold || 0;

  const promoPercent = data?.promotion?.pourcentage || 0;
  const hasPromotion = promoPercent > 0;

  return (
    <div className="w-full h-[370px] bg-white rounded-lg shadow-sm p-3 relative cursor-pointer hover:shadow-lg transition">

      {/* IMAGE */}
      <Link to={`/product/${product_name}`}>
        <img
          src={
            data?.photo
              ? `${server}/storage/${data.photo}`
              : "https://via.placeholder.com/200"
          }
          className="w-full h-[170px] object-contain"
        />
      </Link>

      {/* SHOP */}
      <Link to="/">
        <h5 className={styles.shop_name}>{shopName}</h5>
      </Link>

      {/* TITLE */}
      <Link to={`/product/${product_name}`}>
        <h4 className="pb-3 font-[500]">
          {name.length > 40 ? name.slice(0, 40) + "..." : name}
        </h4>

        {/* STARS */}
        <div className="flex">
          <AiFillStar size={20} color="#F6BA00" />
          <AiFillStar size={20} color="#F6BA00" />
          <AiFillStar size={20} color="#F6BA00" />
          <AiFillStar size={20} color="#F6BA00" />
          <AiOutlineStar size={20} color="#F6BA00" />
        </div>

        {/* PRICE */}
        <div className="py-2 flex items-center justify-between">
          <div className="flex gap-2">
            {hasPromotion ? (
              <>
                <h5 className={styles.productDiscountPrice}>
                  {finalPrice}$
                </h5>

                <h4 className="line-through text-red-600 font-semibold opacity-80">
                  {price}$
                </h4>

                <span className="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                  -{promoPercent}%
                </span>
              </>
            ) : (
              <h5 className={styles.productDiscountPrice}>
                {price}$
              </h5>
            )}
          </div>

          <span className="font-[400] text-[17px] text-[#68d284]">
            {totalSell} sold
          </span>
        </div>
      </Link>

      {/* ACTIONS */}
      <div>

        {/* WISHLIST */}
        {click ? (
          <AiFillHeart
            size={22}
            className="cursor-pointer absolute right-2 top-5"
            onClick={() => setClick(false)}
            color="red"
          />
        ) : (
          <AiOutlineHeart
            size={22}
            className="cursor-pointer absolute right-2 top-5"
            onClick={() => setClick(true)}
            color="#333"
          />
        )}

        {/* DETAILS */}
        <AiOutlineEye
          size={22}
          className="cursor-pointer absolute right-2 top-14"
          onClick={() => setOpen(true)}
        />

        {/* ADD TO CART */}
        <AiOutlineShoppingCart
          size={25}
          className="cursor-pointer absolute right-2 top-24 text-green-600 hover:scale-110 transition"
          onClick={() => {
            dispatch(addToCart(data));
            toast.success("Produit ajouté au panier 🛒");
          }}
        />

        {/* MODAL */}
        {open && (
          <ProductDetailsCard setOpen={setOpen} data={data} />
        )}
      </div>
    </div>
  );
};

export default ProductCard;
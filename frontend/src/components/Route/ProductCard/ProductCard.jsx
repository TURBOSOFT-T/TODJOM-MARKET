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
import { image } from "../../../server";

import { addToCartAction } from "../../../redux/actions/cart";
import { toast } from "react-toastify";
import { useDispatch, useSelector } from "react-redux";


const ProductCard = ({ data }) => {
 
  const { cart } = useSelector((state) => state.cart);
  const [click, setClick] = useState(false);
  const [open, setOpen] = useState(false);
  const dispatch = useDispatch();


  // 🔒 SAFE DATA
  const name = data?.nom || "Produit";
  const product_name = name.replace(/\s+/g, "-");
  
  const shopName = data?.shop?.name || "Boutique";

  const price = data?.prix || 0;

  const finalPrice = data?.final_price || price;

  const totalSell = data?.total_sold || 0;

  const hasPromotion = data?.has_promotion;

  const promoPercent = data?.promotion?.pourcentage || 0;
 // const stock = data?.stock || 0;

//const sold = data?.vendus_count || 0;

//const description = data?.description || "Aucune description";
const addToCartHandler = (id) => {
  const isItemExists = cart?.find((item) => item.id === id);

  if (isItemExists) {
    toast.error("Produit déjà dans le panier !");
    return;
  }

  if (data.stock <= 0) {
    toast.error("Produit en rupture de stock !");
    return;
  }

  const cartData = {
    ...data,
    qty: 1,
  };

  dispatch(addToCartAction(cartData));

  toast.success("Produit ajouté au panier !");
};
  return (
    <div className="w-full h-[370px] bg-white rounded-lg shadow-sm p-3 relative cursor-pointer">
      {/* IMAGE */}
     {/*  <Link to={`/product/${product_name}`}> */}
    <Link to={`/product/${product_name}`}>
        <img
          src={`${image}/storage/${data.photo}`}
          className="w-full h-[170px] object-contain" alt="produit"
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
            {/* PROMO */}
            {hasPromotion ? (
              <>
                <h5 className={styles.productDiscountPrice}>{finalPrice}$</h5>

                <h4 className="line-through text-red-600 font-semibold opacity-80">
                  {price}$
                </h4>
                {hasPromotion && (
                  <span className="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                    -{promoPercent}%
                  </span>
                )}
              </>
            ) : (
              <h5 className={styles.productDiscountPrice}>{price}$</h5>
            )}
          </div>

          <span className="font-[400] text-[17px] text-[#68d284]">
            {totalSell} sold
          </span>
        </div>
      </Link>

      {/* ACTIONS */}
      <div>
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

        <AiOutlineEye
          size={22}
          className="cursor-pointer absolute right-2 top-14"
          onClick={() => setOpen(true)}
        />

         {/* ADD TO CART */}
              <AiOutlineShoppingCart
  size={25}
  className="cursor-pointer absolute right-2 top-24"
  onClick={() => addToCartHandler(data.id)}
  color="#444"
  title="Ajouter au panier"
/>

        {open && <ProductDetailsCard setOpen={setOpen} data={data} />}
      </div>
    </div>
  );
};

export default ProductCard;

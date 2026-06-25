import React, { useState, useEffect } from "react";
import { RxCross1 } from "react-icons/rx";
import { IoBagHandleOutline } from "react-icons/io5";
import { HiOutlineMinus, HiPlus } from "react-icons/hi";
import styles from "../../styles/styles";
import { Link } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import {
  addToCartAction,
  removeFromCartAction,
} from "../../redux/actions/cart";
import { image } from "../../server";

/* ================= CART ================= */

const Cart = ({ setOpenCart }) => {
  const { cart } = useSelector((state) => state.cart);

  const totalPrice = cart.reduce(
    (acc, item) => acc + item.prix * item.qty,
    0
  );

  // 🔥 AUTO LOCK SCROLL (PRO)
  useEffect(() => {
    document.body.style.overflow = "hidden";

    return () => {
      document.body.style.overflow = "auto";
    };
  }, []);

  // CLOSE CART
  const closeCart = () => {
    setOpenCart(false);
  };

  return (
    // 🔥 OVERLAY
    <div
      className="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-50"
      onClick={closeCart}
    >
      {/* 🔥 DRAWER */}
      <div
        className="absolute right-0 top-0 h-full w-[90%] md:w-[40%] lg:w-[30%] bg-white flex flex-col shadow-xl
                   animate-slideIn"
        onClick={(e) => e.stopPropagation()}
      >
        {/* HEADER */}
        <div className="flex justify-end p-4">
          <RxCross1
            size={25}
            className="cursor-pointer"
            onClick={closeCart}
          />
        </div>

        {/* TITLE */}
        <div className={`${styles.noramlFlex} p-4 border-b`}>
          <IoBagHandleOutline size={25} />
          <h5 className="pl-2 text-[18px] font-[500]">
            {cart.length} article(s)
          </h5>
        </div>

        {/* ITEMS */}
        <div className="flex-1 overflow-y-auto">
          {cart.length > 0 ? (
            cart.map((item) => (
              <CartSingle key={item.id} data={item} />
            ))
          ) : (
            <div className="p-5 text-center text-gray-500">
              Votre panier est vide
            </div>
          )}
        </div>

        {/* CHECKOUT */}
        {cart.length > 0 && (
          <div className="p-4 border-t">
            <Link to="/checkout">
              <div className="h-[45px] flex items-center justify-center w-full bg-[#e44343] rounded-[5px]">
                <h1 className="text-white text-[16px] font-[600]">
                  Commander (${totalPrice.toFixed(2)})
                </h1>
              </div>
            </Link>
          </div>
        )}
      </div>
    </div>
  );
};

/* ================= CART SINGLE ================= */

const CartSingle = ({ data }) => {
  const dispatch = useDispatch();
  const [value, setValue] = useState(data.qty);

  const totalPrice = data.prix * value;

  // ➕ INCREMENT
  const increment = () => {
    if (value >= data.stock) return;

    const updated = {
      ...data,
      qty: value + 1,
    };

    setValue(value + 1);
    dispatch(addToCartAction(updated));
  };

  // ➖ DECREMENT
  const decrement = () => {
    if (value <= 1) return;

    const updated = {
      ...data,
      qty: value - 1,
    };

    setValue(value - 1);
    dispatch(addToCartAction(updated));
  };

  // ❌ REMOVE
  const removeHandler = () => {
    dispatch(removeFromCartAction(data.id));
  };

  return (
    <div className="border-b p-4 flex items-center">

      {/* QTY */}
      <div className="flex flex-col items-center">
        <div
          className="bg-red-500 w-[25px] h-[25px] rounded-full flex items-center justify-center cursor-pointer"
          onClick={increment}
        >
          <HiPlus size={16} color="#fff" />
        </div>

        <span className="py-1">{value}</span>

        <div
          className="bg-gray-300 w-[25px] h-[25px] rounded-full flex items-center justify-center cursor-pointer"
          onClick={decrement}
        >
          <HiOutlineMinus size={14} />
        </div>
      </div>

      {/* IMAGE */}
      <img
        src={`${image}/storage/${data.photo}`}
        alt={data.nom}
        className="w-[70px] h-[70px] object-cover ml-3 rounded"
      />

      {/* INFO */}
      <div className="flex-1 ml-3">
        <h1 className="font-semibold">{data.nom}</h1>

        <p className="text-sm text-gray-500">
          ${data.prix} × {value}
        </p>

        <p className="font-bold text-red-500">
          US${totalPrice.toFixed(2)}
        </p>
      </div>

      {/* DELETE */}
      <RxCross1
        size={18}
        className="cursor-pointer text-red-500"
        onClick={removeHandler}
      />
    </div>
  );
};

export default Cart;
import { createSlice } from "@reduxjs/toolkit";

const initialState = {
  cart: localStorage.getItem("cartItems")
    ? JSON.parse(localStorage.getItem("cartItems"))
    : [],
};

const cartSlice = createSlice({
  name: "cart",
  initialState,
  reducers: {
    addToCart: (state, action) => {
      const item = action.payload;

      const exist = state.cart.find((i) => i.id === item.id);

      if (exist) {
        state.cart = state.cart.map((i) => (i.id === item.id ? item : i));
      } else {
        state.cart.push(item);
      }

      localStorage.setItem("cartItems", JSON.stringify(state.cart));
    },

   

    removeFromCart: (state, action) => {
      state.cart = state.cart.filter((item) => item.id !== action.payload);

      localStorage.setItem("cartItems", JSON.stringify(state.cart));
    },

    decreaseQty: (state, action) => {
      state.cart = state.cart.map((item) =>
        item.id === action.payload
          ? { ...item, qty: Math.max(1, item.qty - 1) }
          : item,
      );

      localStorage.setItem("cartItems", JSON.stringify(state.cart));
    },

    clearCart: (state) => {
      state.cart = [];
      localStorage.removeItem("cartItems");
    },
  },
});

export const { addToCart, removeFromCart, decreaseQty, clearCart } =
  cartSlice.actions;

export default cartSlice.reducer;

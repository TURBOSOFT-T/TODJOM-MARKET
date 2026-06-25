import {
  addToCart,
  removeFromCart,
  decreaseQty,
  clearCart,
} from "../reducers/cart";

// ➕ ADD TO CART
export const addToCartAction = (data) => (dispatch) => {
  dispatch(addToCart(data));
};

// ❌ REMOVE FROM CART

export const removeFromCartAction = (id) => (dispatch) => {
  dispatch(removeFromCart(id));
};
// 🔻 DECREASE QTY
export const decreaseQtyAction = (id) => (dispatch) => {
  dispatch(decreaseQty(id));
};

// 🧹 CLEAR CART (BONNE PRATIQUE)
export const clearCartAction = () => (dispatch) => {
  dispatch(clearCart());
};
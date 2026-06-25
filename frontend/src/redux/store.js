import { configureStore } from "@reduxjs/toolkit";

import userReducer from "./reducers/user";
import sellerReducer from "./reducers/seller";
import eventReducer from "./reducers/event";
import productReducer from "./reducers/product";
import categoryReducer from "./reducers/category";
import categoriesReducer from "./slices/categoriesSlice";
import cartReducer from './reducers/cart';
import  wishlistReducer  from "./reducers/wishlist";
import bannerReducer from "./reducers/banner";

export const store = configureStore({
  reducer: {
    user: userReducer,
    seller: sellerReducer,
    events: eventReducer,
    products: productReducer,
    category: categoryReducer,
    categories: categoriesReducer,
    cart: cartReducer,
    wishlist: wishlistReducer,
    banner: bannerReducer,
  },
});
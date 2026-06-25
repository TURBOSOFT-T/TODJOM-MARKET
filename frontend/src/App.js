import "./App.css";
import { BrowserRouter, Routes, Route } from "react-router-dom";


import {
  LoginPage,
  SignupPage,
  ShopCreatePage,
  EventsPage, 
  CheckoutPage,
    BestSellingPage,
  FAQPage,
  HomePage,
    ProductsPage,
     ProductDetailsPage,
  ProfilePage,
  ShopLoginPage,
} from "./routes/Routes";
import {
  ShopHomePage,
  ShopDashboardPage,
  ShopSettingsPage,
   ShopAllOrders,
    ShopCreateProduct,
  ShopAllProducts,
  ShopCreateEvents,
  ShopAllEvents,
  ShopInboxPage,
} from "./routes/ShopRoutes";
//import { ShopHomePage } from "./ShopRoutes.js";

import SellerProtectedRoute from "./routes/SellerProtectedRoute";
import ProtectedRoute from "./routes/ProtectedRoute";
import "react-toastify/dist/ReactToastify.css";
import { useEffect } from "react";
import { ToastContainer } from "react-toastify";
import { useDispatch } from "react-redux";
import { loadSeller, loadUser } from "./redux/actions/user";
import { useSelector } from "react-redux";
import { getAllProductsBest, getAllProductsHome, getAllProductsPage } from "./redux/actions/product";
import { getAllBanners } from "./redux/actions/banner";

function App() {
  const dispatch = useDispatch();
  const state = useSelector((state) => state);

  console.log("FULL REDUX USER ET SELLER:", state);
  useEffect(() => {
    const userToken = localStorage.getItem("token");
    const sellerToken = localStorage.getItem("shop_token");

    if (userToken) {
      dispatch(loadUser());
    }

    if (sellerToken) {
      dispatch(loadSeller());
    }
    dispatch(getAllBanners());
    dispatch(getAllProductsHome());
    dispatch(getAllProductsPage());
    dispatch(getAllProductsBest());
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [dispatch]);

  return (
    <BrowserRouter>
      <Routes>

      <Route path='/login' element={<LoginPage />} />
      <Route path='/signup' element={<SignupPage />} />

        <Route path="/" element={<HomePage />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/signup" element={<SignupPage />} />
         <Route path="/best-selling" element={<BestSellingPage />} />
         <Route path="/products" element={<ProductsPage />} />
          
          <Route path="/product/:id" element={<ProductDetailsPage />} />
        <Route path="/events" element={<EventsPage />} />
        <Route path="/faq" element={<FAQPage />} />
         <Route
          path="/checkout"
          element={
            <ProtectedRoute>
              <CheckoutPage />
            </ProtectedRoute>
          }
        />
        <Route path="/profile" element={<ProfilePage />} />

        {/* shop Routes */}
        <Route path="/shop-create" element={<ShopCreatePage />} />
        <Route path="/shop-login" element={<ShopLoginPage />} />
        <Route
          path="/shop/:id"
          element={
            <SellerProtectedRoute>
              <ShopHomePage />
            </SellerProtectedRoute>
          }
        />
        <Route
          path="/settings"
          element={
            <SellerProtectedRoute>
              <ShopSettingsPage />
            </SellerProtectedRoute>
          }
        />
        <Route
          path="/dashboard"
          element={
            <SellerProtectedRoute>
              <ShopDashboardPage />
            </SellerProtectedRoute>
          }
        />
        <Route
          path="/dashboard-create-product"
          element={
            <SellerProtectedRoute>
              <ShopCreateProduct />
            </SellerProtectedRoute>
          }
        />
        <Route
          path="/dashboard-orders"
          element={
            <SellerProtectedRoute>
              <ShopAllOrders />
            </SellerProtectedRoute>
          }
        />
        

      
        <Route
          path="/dashboard-products"
          element={
            <SellerProtectedRoute>
              <ShopAllProducts />
            </SellerProtectedRoute>
          }
        />
        <Route
          path="/dashboard-create-event"
          element={
            <SellerProtectedRoute>
              <ShopCreateEvents />
            </SellerProtectedRoute>
          }
        />
          <Route
          path="/dashboard-messages"
          element={
            <SellerProtectedRoute>
              <ShopInboxPage />
            </SellerProtectedRoute>
          }
        />
        <Route
          path="/dashboard-events"
          element={
            <SellerProtectedRoute>
              <ShopAllEvents />
            </SellerProtectedRoute>
          }
        />

      </Routes>


      <ToastContainer
        position="bottom-center"
        autoClose={5000}
        hideProgressBar={false}
        newestOnTop={false}
        closeOnClick
        rtl={false}
        pauseOnFocusLoss
        draggable
        pauseOnHover
        theme="dark"
      />
    </BrowserRouter>
  );
}
export default App;

import React, { useEffect } from "react";
import Header from "../components/Layout/Header";
import Hero from "../components/Route/Hero/Hero";
import Categories from "../components/Route/Categories/Categories";
import Footer from "../components/Layout/Footer";
import BestDeals from "../components/Route/BestDeals/BestDeals";
import FeaturedProduct from "../components/Route/FeaturedProduct/FeaturedProduct";
import Sponsored from "../components/Route/Sponsored";
import Events from "../components/Events/Events";
import { useDispatch } from "react-redux";
import { getAllProductsHome } from "../redux/actions/product";
const HomePage = () => {


  const dispatch = useDispatch();

 useEffect(() => {
  console.log("Loading home products...");
  dispatch(getAllProductsHome());
}, [dispatch]);
  return (
    <div>
      <Header activeHeading={1} />
      <Hero />
      <Categories />
 <BestDeals />
      <Events />
 <FeaturedProduct />
 
      <Sponsored />
      <Footer />
    </div>
  );
};
export default HomePage;

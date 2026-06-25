import React, { useEffect, useState } from "react";
import { useSelector } from "react-redux";
import { useSearchParams } from "react-router-dom";
import Footer from "../components/Layout/Footer";
import Header from "../components/Layout/Header";
import Loader from "../components/Layout/Loader";
import ProductCard from "../components/Route/ProductCard/ProductCard";
import styles from "../styles/styles";

const ProductsPage = () => {
  const [searchParams] = useSearchParams();
  const categoryData = searchParams.get("category");

  const [data, setData] = useState([]);

  const { allProductsPage, isLoading } = useSelector(
    (state) => state.products
  );

  useEffect(() => {
    if (!allProductsPage) return;

    let filteredData = [...allProductsPage];

    if (categoryData) {
      filteredData = filteredData.filter(
        (i) => i?.category === categoryData
      );
    }

    setData(filteredData);
  }, [allProductsPage, categoryData]);

  return (
    <>
      {isLoading ? (
        <Loader />
      ) : (
        <div>
          <Header activeHeading={3} />
          <br />
          <br />

          <div className={`${styles.section}`}>
            <div className="grid grid-cols-1 gap-[20px] md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 mb-12">
              {data.map((i, index) => (
                <ProductCard data={i} key={index} />
              ))}
            </div>

            {data.length === 0 && (
              <h1 className="text-center w-full pb-[100px] text-[20px]">
                No products Found!
              </h1>
            )}
          </div>

          <Footer />
        </div>
      )}
    </>
  );
};

export default ProductsPage;
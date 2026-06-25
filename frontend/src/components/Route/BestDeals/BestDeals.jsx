import React, { useEffect, useState } from "react";
import styles from "../../../styles/styles";
import { productData } from "../../../static/data";
import ProductCard from "../ProductCard/ProductCard";
import { useSelector } from "react-redux";

const BestDeals = () => {
  const [data, setData] = useState([]);
  const { allProductsBest, isLoading } = useSelector((state) => state.products);
  console.log("The best selling products home page() :", allProductsBest);

  /* useEffect(() => {
    const d =
      allProductsBest &&allProductsBest.sort((a, b) => (b.total_sold || 0) - (a.total_sold || 0));
    const firstFive = d.slice(0, 2);
    setData(firstFive);
  }, []); */

  useEffect(() => {
  if (!allProductsBest) return;

  const d = [...allProductsBest] // copie safe

  const sorted = d.sort(
    (a, b) => (b.total_sold || 0) - (a.total_sold || 0)
  );

  const firstFive = sorted.slice(0, 5);

  setData(firstFive);
}, [allProductsBest]);

  return (
    <div>
      <div className={`${styles.section}`}>
        <div className={`${styles.heading}`}>
          <h1>Best Deals</h1>
        </div>
        <div className="grid grid-cols-1 gap-[20px] md:grid-cols-2 md:gap-[25px] lg:grid-cols-4 lg:gap-[25px] xl:grid-cols-5 xl:gap-[30px] mb-12 border-0">
          {data &&
            data.map((i, index) => {
              return <ProductCard key={index} data={i} />;
            })}
        </div>
      </div>
    </div>
  );
};

export default BestDeals;

import React, { useEffect, useState } from "react";
import { useSelector } from "react-redux";
import ProductCard from "../Route/ProductCard/ProductCard";
import styles from "../../styles/styles";

const SuggestedProduct = ({ data }) => {
  const { allProducts } = useSelector((state) => state.products);
  const [relatedProducts, setRelatedProducts] = useState([]);

  useEffect(() => {
    if (!data || !allProducts?.length) return;

    const products = allProducts.filter(
      (item) =>
        item.category_id === data.category_id &&
        item.id !== data.id
    );

    setRelatedProducts(products);
  }, [allProducts, data]);

  return (
    <div className={`${styles.section}`}>
      <h2 className="text-[25px] font-[600] mb-5">
        Produits similaires
      </h2>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-5">
        {relatedProducts.map((item) => (
          <ProductCard key={item.id} data={item} />
        ))}
      </div>
    </div>
  );
};

export default SuggestedProduct;
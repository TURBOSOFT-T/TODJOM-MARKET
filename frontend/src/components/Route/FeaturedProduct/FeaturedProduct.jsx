import React from "react";
import styles from "../../../styles/styles";
import ProductCard from "../ProductCard/ProductCard";
import { useSelector } from "react-redux";

const FeaturedProduct = () => {

  const {
    productsHome,
    isLoading,
  } = useSelector((state) => state.products);

  console.log("PRODUCTS HOME PAGE:", productsHome);

 
  return (
    <div>
      <div className={styles.section}>

        <div className={styles.heading}>
          <h1>Featured Products</h1>
        </div>

        {isLoading ? (
          <p>Chargement...</p>
        ) : productsHome && productsHome.length > 0 ? (

          <div className="grid grid-cols-1 gap-[20px] md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 mb-12 border-0">

            {productsHome.map((product, index) => (
              <ProductCard
                data={product}
                key={product._id || index}
              />
            ))}

          </div>

        ) : (
          <p>Aucun produit disponible</p>
        )}

      </div>
    </div>
  );
};

export default FeaturedProduct;
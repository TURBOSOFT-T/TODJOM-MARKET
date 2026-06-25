import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { useSelector } from "react-redux";

import Header from "../components/Layout/Header";
import Footer from "../components/Layout/Footer";
import ProductDetails from "../components/Products/ProductDetails";

const slugify = (text) =>
  text
    ?.toLowerCase()
    ?.replace(/\s+/g, "-")
    ?.replace(/[^\w-]+/g, "");

const ProductDetailsPage = () => {
  const { id } = useParams();

  const { allProductsPage = [] } = useSelector(
    (state) => state.products || {}
  );

  const [data, setData] = useState(null);

  console.log("ALL PRODUCTS:", allProductsPage);
  console.log("URL SLUG:", id);
  console.log('les détails produit:',data);
 
  useEffect(() => {
  if (!Array.isArray(allProductsPage) || allProductsPage.length === 0) {
    return;
  }

  const currentSlug = decodeURIComponent(id).toLowerCase();

  const product = allProductsPage.find((item) => {
    const slug = slugify(item?.nom || item?.name || "");
    return slug.toLowerCase() === currentSlug;
  });

  console.log("Produit trouvé :", product);

  setData(product || null);
}, [allProductsPage, id]);

  return (
    <div>
      <Header />
      <br />

      {data ? (
        <ProductDetails data={data} />
      ) : (
        <p className="text-center py-10">
          Produit introuvable ou en chargement...
        </p>
      )}

      <Footer />
    </div>
  );
};

export default ProductDetailsPage;
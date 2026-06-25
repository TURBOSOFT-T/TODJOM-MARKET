import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { brandingData } from "../../../static/data";
import styles from "../../../styles/styles";
import { fetchCategory } from "../../../Api/Api";
import { image } from "../../../server"; // ✅ CORRIGÉ

const Categories = () => {
  const navigate = useNavigate();

  const [categoriesData, setCategoriesData] = useState([]);
  const [loading, setLoading] = useState(true);

  // LOAD CATEGORIES
  useEffect(() => {
    const loadCategories = async () => {
      try {
        setLoading(true);

        const res = await fetchCategory();

        setCategoriesData(res.data.data || []);
      } catch (error) {
        console.log("Erreur categories:", error?.response || error);
      } finally {
        setLoading(false);
      }
    };

    loadCategories();
  }, []);

  // NAVIGATION CATEGORY
  const handleSubmit = (category) => {
    const name = category.nom || category.title || category.name;
  //  navigate(`/products?category=${name}`);
  navigate(`/products?category=${category.id}`);
  };

  return (
    <>
      {/* BRANDING SECTION */}
      <div className={`${styles.section} hidden sm:block`}>
        <div className="branding my-12 flex justify-between w-full shadow-sm bg-white p-5 rounded-md">
          {brandingData.map((i, index) => (
            <div className="flex items-start" key={index}>
              {i.icon}
              <div className="px-3">
                <h3 className="font-bold text-sm md:text-base">{i.title}</h3>
                <p className="text-xs md:text-sm">{i.Description}</p>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* CATEGORIES SECTION */}
      <div className={`${styles.section} bg-white p-6 rounded-lg mb-12`}>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">

          {loading ? (
            <p className="text-center col-span-full">Chargement...</p>
          ) : categoriesData.length > 0 ? (
            categoriesData.map((i) => (
              <div
                key={i.id}
                onClick={() => handleSubmit(i)}
                className="w-full h-[100px] flex items-center justify-between cursor-pointer overflow-hidden border rounded-md p-2 hover:shadow-md transition"
              >
                {/* CATEGORY NAME */}
                <h5 className="text-[18px] leading-[1.3]">
                  {i.nom || i.title || i.name}
                </h5>

                {/* CATEGORY IMAGE */}
                
                <img
                  src={`${image}/storage/${i.photo}`
                     
                  }
                  className="w-[120px] h-[80px] object-cover rounded"
                  alt={i.nom || "category"}
                />
              </div>
            ))
          ) : (
            <p className="text-center col-span-full">
              Aucune catégorie disponible
            </p>
          )}

        </div>
      </div>
    </>
  );
};

export default Categories;
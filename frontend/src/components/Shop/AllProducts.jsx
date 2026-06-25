import { Button } from "@material-ui/core";
import { DataGrid } from "@material-ui/data-grid";
import React, { useEffect } from "react";
import {  AiOutlineEye } from "react-icons/ai";
import { useDispatch, useSelector } from "react-redux";

import { getAllProductsShop } from "../../redux/actions/product";
import { deleteProduct } from "../../redux/actions/product";
import Loader from "../Layout/Loader";
import { toast } from "react-toastify";
import Swal from "sweetalert2";
import { image } from "../../server";

const AllProducts = () => {
  const { products, isLoading } = useSelector((state) => state.products);
  const { seller } = useSelector((state) => state.seller);

  const [open, setOpen] = React.useState(false);
const [selectedProduct, setSelectedProduct] = React.useState(null);

const getPromoPrice = (item) => {
  if (item?.promotion?.pourcentage) {
    return item.prix - (item.prix * item.promotion.pourcentage) / 100;
  }
  return item.prix;
};

const handleView = (product) => {
  setSelectedProduct(product);
  setOpen(true);
};

console.log("SELLER:", seller);
console.log("PRODUCTS shop page:", products);
  const dispatch = useDispatch();

useEffect(() => {
  if (seller?._id || seller?.id) {
    dispatch(getAllProductsShop(seller._id || seller.id));
  }
  
}, [dispatch, seller]);

 const handleDelete = (id) => {

  Swal.fire({
    title: "Êtes-vous sûr ?",
    text: "Ce produit sera supprimé définitivement !",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Oui, supprimer",
    cancelButtonText: "Annuler",
  }).then((result) => {

    if (result.isConfirmed) {

      dispatch(deleteProduct(id));

      toast.success("Le produit est supprimé");
 dispatch(
        getAllProductsShop(seller._id || seller.id)
      );
    }

  });

};

  const columns = [
    { field: "id", headerName: "Product Id", minWidth: 150, flex: 0.7 },
    {
      field: "name",
      headerName: "Name",
      minWidth: 180,
      flex: 1.4,
    },
    {
      field: "price",
      headerName: "Price",
      minWidth: 100,
      flex: 0.6,
    },
    {
  field: "stockBadge",
  headerName: "Statut",
  flex: 0.8,
  renderCell: (params) => {
    return (
      <span
        style={{
          padding: "4px 10px",
          borderRadius: "12px",
          color: "white",
          backgroundColor:
            params.value === "En stock" ? "green" : "red",
          fontSize: "12px",
        }}
      >
        {params.value}
      </span>
    );
  },
},

    {
      field: "sold",
      headerName: "Sold out",
      type: "number",
      minWidth: 130,
      flex: 0.6,
    },

    
    {
  field: "Preview",
  headerName: "",
  flex: 0.8,
  renderCell: (params) => {
    return (
      <Button onClick={() => handleView(params.row)}>
        <AiOutlineEye size={20} />
      </Button>
    );
  },
},

{
  field: "promoPrice",
  headerName: "Prix promo",
  minWidth: 120,
  flex: 0.8,
  renderCell: (params) => {
    return (
      <span style={{ color: "green", fontWeight: "bold" }}>
        {params.value}
      </span>
    );
  },
},
{
  field: "promoPercent",
  headerName: "Promotion",
  minWidth: 120,
  flex: 0.6,
  renderCell: (params) => {
    return params.value !== "—" ? (
      <span
        style={{
          color: "white",
          backgroundColor: "red",
          padding: "4px 10px",
          borderRadius: "12px",
          fontSize: "12px",
        }}
      >
        -{params.value}
      </span>
    ) : (
      <span style={{ color: "#999" }}>—</span>
    );
  },
},
{
  field: "Delete",
  headerName: "",
  flex: 0.8,
  renderCell: (params) => {
    return (
      <Button
        onClick={() => handleDelete(params.id)}
        style={{ color: "red" }}
      >
        🗑
      </Button>
    );
  },
}
  ];

  const row = [];

  products &&
    products.forEach((item) => {
     row.push({
  id: item.id || item._id,
    photo: item.photo,
  name: item.nom,
  price: "US$ " + item.prix,
  promoPrice: item?.promotion
    ? "US$ " + getPromoPrice(item).toFixed(2)
    : "—",
  promoPercent: item?.promotion
    ? item.promotion.pourcentage + "%"
    : "—",

 stock: item.stock || 0,

  stockBadge:
    item.stock > 10
      ? "En stock"
      : item.stock > 0
      ? "Stock faible"
      : "Rupture",


  sold:
  item.total_sold > 0
    ? item.total_sold
    : "Aucune vente",
});
    });

  return (
    <>

    {open && selectedProduct && (
  <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[999]">
    
    <div className="bg-white w-[400px] p-5 rounded shadow-lg relative">

      {/* CLOSE BUTTON */}
      <button
        className="absolute top-2 right-2 text-black"
        onClick={() => setOpen(false)}
      >
        ✖
      </button>

      {/* DETAILS */}
      <h2 className="text-xl font-bold mb-3">
        {selectedProduct.name}
      </h2>
       <img
                src={`${image}/storage/${selectedProduct.photo}`}
                className="w-full h-[170px] object-contain"
           alt="produit"   />

      <p><strong>Prix:</strong> {selectedProduct.price}</p>
      <p><strong>Stock:</strong> {selectedProduct.stock}</p>
      <p><strong>Vendu:</strong> {selectedProduct.sold}</p>

    </div>
  </div>
)}
      {isLoading ? (
        <Loader />
      ) : (
        <div className="w-full mx-8 pt-1 mt-10 bg-white">
          <DataGrid
            rows={row}
            columns={columns}
            pageSize={10}
            disableSelectionOnClick
            autoHeight
          />
        </div>
      )}
    </>
  );
};

export default AllProducts;

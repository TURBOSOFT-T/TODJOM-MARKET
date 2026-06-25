import React, {  useEffect, useState } from "react";
import { AiOutlinePlusCircle } from "react-icons/ai";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { createProduct } from "../../redux/actions/product";
import { toast } from "react-toastify";

const CreateProduct = () => {
  const { seller } = useSelector((state) => state.seller);
  const { success, error } = useSelector((state) => state.products);
  const { categories } = useSelector((state) => state.categories);

  const dispatch = useDispatch();
  const navigate = useNavigate();

  // ================= STATES =================
  const [photo, setPhoto] = useState(null);
  const [photoPreview, setPhotoPreview] = useState("");

  const [photos, setPhotos] = useState([]);
  const [photosPreview, setPhotosPreview] = useState([]);

  const [nom, setNom] = useState("");
  const [reference, setReference] = useState("");
  const [description, setDescription] = useState("");
  const [category_id, setCategory_id] = useState("");
  const [prix, setPrix] = useState("");
  const [prix_achat, setPrix_achat] = useState("");
  const [stock, setStock] = useState("");

  // ================= EFFECT =================
useEffect(() => {
  if (success) {
    toast.success("Produit créé avec succès 🎉");

    setNom("");
    setReference("");
    setDescription("");
    setCategory_id("");
    setPrix("");
    setPrix_achat("");
    setStock("");
    setPhoto(null);
    setPhotoPreview("");
    setPhotos([]);
    setPhotosPreview([]);

    navigate("/dashboard");
  }
}, [success]);
  // ================= MAIN PHOTO =================
  const handlePhotoChange = (e) => {
    const file = e.target.files[0];
    setPhoto(file);

    const reader = new FileReader();
    reader.onload = () => setPhotoPreview(reader.result);
    reader.readAsDataURL(file);
  };

  // ================= GALLERY =================
  const handlePhotosChange = (e) => {
    const files = Array.from(e.target.files);

    setPhotos([]);
    setPhotosPreview([]);

    files.forEach((file) => {
      const reader = new FileReader();

      reader.onload = () => {
        setPhotos((old) => [...old, file]);
        setPhotosPreview((old) => [...old, reader.result]);
      };

      reader.readAsDataURL(file);
    });
  };
const handleSubmit = async (e) => {
  e.preventDefault();

  try {
    const shopId = seller?.id || seller?._id;

    if (!shopId) {
      toast.error("Seller introuvable ❌");
      return;
    }

    if (!nom || !prix || !reference) {
      toast.error("Veuillez remplir les champs obligatoires ❌");
      return;
    }

    const formData = new FormData();

    // MAIN IMAGE
    if (photo) {
      formData.append("photo", photo);
    }

    // GALLERY
    photos.forEach((img) => {
      formData.append("photos[]", img);
    });

    formData.append("nom", nom);
    formData.append("reference", reference);
    formData.append("description", description);
    formData.append("category_id", category_id);
    formData.append("prix", prix);
    formData.append("prix_achat", prix_achat);
    formData.append("stock", stock);
    formData.append("id_shop", shopId);

    // DEBUG
    console.log("===== FORM DATA DEBUG =====");
    for (let pair of formData.entries()) {
      console.log(pair[0], pair[1]);
    }

    await dispatch(createProduct(formData));

    toast.success("Produit envoyé avec succès 🚀");
   // navigate("/dashboard-create-product");
     window.location.reload(true); 

  } catch (error) {
    console.log("ERROR CREATE PRODUCT:", error);
    toast.error("Erreur serveur ❌");
  }
};

  return (
    <div className="w-[90%] 800px:w-[50%] bg-white shadow h-[80vh] rounded-[4px] p-3 overflow-y-scroll">
      <h5 className="text-[30px] font-Poppins text-center">
        Create Product
      </h5>

      <form onSubmit={handleSubmit}>
        <br />

        {/* NAME */}
        <div>
          <label>Name *</label>
          <input
            type="text"
            value={nom}
            onChange={(e) => setNom(e.target.value)}
            className="mt-2 w-full h-[35px] border rounded px-3"
          />
        </div>

        <br />

        {/* DESCRIPTION */}
        <div>
          <label>Description *</label>
          <textarea
            rows="5"
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            className="mt-2 w-full border rounded px-3 pt-2"
          />
        </div>

        <br />

        {/* CATEGORY */}
        <div>
          <label>Category *</label>
          <select
            className="w-full h-[35px] border rounded mt-2"
            value={category_id}
            onChange={(e) => setCategory_id(e.target.value)}
          >
            <option value="">Choose category</option>
            {categories &&
              categories.map((c) => (
                <option key={c.id} value={c.id}>
                  {c.nom}
                </option>
              ))}
          </select>
        </div>

        <br />

        {/* PRICES */}
        <div>
          <label>Prix achat</label>
          <input
            type="number"
            value={prix_achat}
            onChange={(e) => setPrix_achat(e.target.value)}
            className="mt-2 w-full h-[35px] border rounded px-3"
          />
        </div>

        <br />

        <div>
          <label>Prix vente *</label>
          <input
            type="number"
            value={prix}
            onChange={(e) => setPrix(e.target.value)}
            className="mt-2 w-full h-[35px] border rounded px-3"
          />
        </div>

        <br />

        {/* REFERENCE */}
        <div>
          <label>Reference *</label>
          <input
            type="text"
            value={reference}
            onChange={(e) => setReference(e.target.value)}
            className="mt-2 w-full h-[35px] border rounded px-3"
          />
        </div>

        <br />

        {/* STOCK */}
        <div>
          <label>Stock *</label>
          <input
            type="number"
            value={stock}
            onChange={(e) => setStock(e.target.value)}
            className="mt-2 w-full h-[35px] border rounded px-3"
          />
        </div>

        <br />

        {/* MAIN IMAGE */}
        <div>
          <label className="font-bold">Image principale</label>
          <input type="file" onChange={handlePhotoChange} />

          {photoPreview && (
            <img
              src={photoPreview}
              className="w-[120px] h-[120px] object-cover mt-2 rounded"
            />
          )}
        </div>

        <br />

        {/* GALLERY */}
        <div>
          <label className="font-bold">Galerie images</label>
          <input type="file" multiple onChange={handlePhotosChange} />

          <div className="flex flex-wrap gap-2 mt-2">
            {photosPreview.map((img, i) => (
              <img
                key={i}
                src={img}
                className="w-[100px] h-[100px] object-cover rounded"
              />
            ))}
          </div>
        </div>

        <br />

        {/* BUTTON */}
        <input
          type="submit"
          value="Create"
          className="w-full h-[40px] bg-[#3321c8] text-white rounded cursor-pointer"
        />
      </form>
    </div>
  );
};

export default CreateProduct;
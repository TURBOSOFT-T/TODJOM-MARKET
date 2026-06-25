import { createSlice } from "@reduxjs/toolkit";

const productSlice = createSlice({
  name: "product",

  initialState: {
    isLoading: false,

    // 📦 Produits page accueil
    productsHome: [],

    // 🏪 Produits boutique
    products: [],

    // 🛠️  (tous produits)
    allProductsPage: [],
    // Produits filtrés par catégorie
    categoryProducts: [],

    allProductsBest: [],
    // 📌 Produit unique
    product: null,
    searchResults: [],
     
    error: null,
    success: false,
    message: null,
  },

  reducers: {
    /* =========================
       CREATE PRODUCT
    ========================= */
    productCreateRequest: (state) => {
      state.isLoading = true;
    },
    productCreateSuccess: (state, action) => {
      state.isLoading = false;
      state.product = action.payload;
      state.success = true;
    },
    productCreateFail: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
      state.success = false;
    },

    /* =========================
   GET PRODUCTS BY CATEGORY
========================= */
    getProductsByCategoryRequest: (state) => {
      state.isLoading = true;
    },

    getProductsByCategorySuccess: (state, action) => {
      state.isLoading = false;
      state.categoryProducts = action.payload;
    },

    getProductsByCategoryFailed: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },

    /* =========================
       GET SHOP PRODUCTS
    ========================= */
    getAllProductsShopRequest: (state) => {
      state.isLoading = true;
    },
    getAllProductsShopSuccess: (state, action) => {
      state.isLoading = false;
      state.products = action.payload;
    },
    getAllProductsShopFailed: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },

    /* =========================
       GET HOME PRODUCTS
    ========================= */
    getAllProductsHomeRequest: (state) => {
      state.isLoading = true;
    },
    getAllProductsHomeSuccess: (state, action) => {
      state.isLoading = false;
      state.productsHome = action.payload; // ✅ IMPORTANT FIX
    },
    getAllProductsHomeFailed: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },

    /* =========================
       GET ALL PRODUCTS 
    ========================= */
    getAllProductsPageRequest: (state) => {
      state.isLoading = true;
    },
    getAllProductsPageSuccess: (state, action) => {
      state.isLoading = false;
      state.allProductsPage = action.payload;
    },
    getAllProductsPageFailed: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },

    productSearchRequest: (state) => {
      state.isLoading = true;
    },

    productSearchSuccess: (state, action) => {
      state.isLoading = false;
      state.searchResults = action.payload;
    },

    productSearchFail: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },
searchProductsRequest: (state) => {
  state.isLoading = true;
},

searchProductsSuccess: (state, action) => {
  state.isLoading = false;
  state.searchResults = action.payload;
},

searchProductsFail: (state, action) => {
  state.isLoading = false;
  state.error = action.payload;
},


    /* =========================
       GET ALLBESTSELLING PRODUCTS 
    ========================= */
    getAllProductsBestRequest: (state) => {
      state.isLoading = true;
    },
    getAllProductsBestSuccess: (state, action) => {
      state.isLoading = false;
      state.allProductsBest = action.payload;
    },
    getAllProductsBestFailed: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },

    getAllProductsRequest: (state) => {
      state.isLoading = true;
    },
    getAllProductsSuccess: (state, action) => {
      state.isLoading = false;
      state.allProducts = action.payload;
    },
    getAllProductsFailed: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },
    /* =========================
       DELETE PRODUCT
    ========================= */
    deleteProductRequest: (state) => {
      state.isLoading = true;
    },
    deleteProductSuccess: (state, action) => {
      state.isLoading = false;
      state.message = action.payload;
    },
    deleteProductFailed: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },

    /* =========================
       CLEAR ERRORS
    ========================= */
    clearErrors: (state) => {
      state.error = null;
    },
  },
});

export const {
  productCreateRequest,
  productCreateSuccess,
  productCreateFail,

  getAllProductsShopRequest,
  getAllProductsShopSuccess,
  getAllProductsShopFailed,

  getAllProductsHomeRequest,
  getAllProductsHomeSuccess,
  getAllProductsHomeFailed,

  getAllProductsPageFailed,
  getAllProductsPageSuccess,
  getAllProductsPageRequest,

  getAllProductsRequest,
  getAllProductsSuccess,
  getAllProductsFailed,

  getAllProductsBestFailed,
  getAllProductsBestSuccess,
  getAllProductsBestRequest,

  deleteProductRequest,
  deleteProductSuccess,
  deleteProductFailed,

  getProductsByCategoryRequest,
  getProductsByCategorySuccess,
  getProductsByCategoryFailed,

  productSearchFail,
  productSearchSuccess,
  productSearchRequest,
  searchProductsRequest,
  searchProductsFail,
  searchProductsSuccess,
  clearErrors,
} = productSlice.actions;

export default productSlice.reducer;

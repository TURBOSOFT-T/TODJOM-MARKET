import axios from "axios";
import { server } from "../../server";
import {
  getAllProductsBestFailed,
  getAllProductsBestRequest,
  getAllProductsBestSuccess,
  getAllProductsFailed,
  getAllProductsHomeFailed,
  getAllProductsHomeRequest,
  getAllProductsHomeSuccess,
  getAllProductsPageFailed,
  getAllProductsPageRequest,
  getAllProductsPageSuccess,
  getAllProductsRequest,
  getAllProductsShopFailed,
  getAllProductsShopRequest,
  getAllProductsShopSuccess,
  getAllProductsSuccess,
  getProductsByCategoryFailed,
  getProductsByCategoryRequest,
  getProductsByCategorySuccess,
  productSearchFail,
  productSearchRequest,
  productSearchSuccess,
} from "../reducers/product";

// create product
export const createProduct = (formData) => async (dispatch) => {
  try {
    dispatch({ type: "productCreateRequest" });

    const { data } = await axios.post(`${server}/create-product`, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    dispatch({
      type: "productCreateSuccess",
      payload: data.product,
    });
  } catch (error) {
    dispatch({
      type: "productCreateFail",
      payload: error.response?.data?.message || "Erreur serveur",
    });
  }
};
// get All Products of a shop
export const getAllProductsShop = (id) => async (dispatch) => {
  try {
    dispatch(getAllProductsShopRequest());
    const { data } = await axios.get(`${server}/get-all-products-shop/${id}`);

    console.log("Data SHOP from Acttions", data);

    dispatch(getAllProductsShopSuccess(data.products));
  } catch (error) {
    dispatch(getAllProductsShopFailed(error.response.data.message));
  }
};

export const getAllProductsHome = () => async (dispatch) => {
  try {
    dispatch(getAllProductsHomeRequest());

    const { data } = await axios.get(`${server}/get-all-products-home`);

    console.log("HOME API RESPONSE:", data);

    dispatch(getAllProductsHomeSuccess(data.products));
  } catch (error) {
    console.log("HOME ERROR:", error);

    dispatch(
      getAllProductsHomeFailed(
        error.response?.data?.message || "Erreur serveur",
      ),
    );
  }
};
export const deleteProduct = (id) => async (dispatch) => {
  try {
    dispatch({
      type: "deleteProductRequest",
    });

    const { data } = await axios.delete(`${server}/delete-shop-product/${id}`, {
      withCredentials: true,
    });

    dispatch({
      type: "deleteProductSuccess",
      payload: data.message,
    });
  } catch (error) {
    dispatch({
      type: "deleteProductFailed",
      payload: error.response.data.message,
    });
  }
};

// get all products
export const getAllProductsPage = () => async (dispatch) => {
  try {
    dispatch(getAllProductsPageRequest());
    const { data } = await axios.get(`${server}/get-all-products`);

    console.log("All PRODUCTS:", data);

    dispatch(getAllProductsPageSuccess(data.products));
  } catch (error) {
    dispatch(getAllProductsPageFailed(error.response.data.message));
  }
};

/////////BEST SELLING PRODUCTS /////////////
export const getAllProductsBest = () => async (dispatch) => {
  try {
    dispatch(getAllProductsBestRequest());
    const { data } = await axios.get(`${server}/get-all-products`);

    console.log("All BEST PRODUCTS:", data);

    dispatch(getAllProductsBestSuccess(data.products));
  } catch (error) {
    dispatch(getAllProductsBestFailed(error.response.data.message));
  }
};

export const getAllProducts = () => async (dispatch) => {
  try {
    dispatch(getAllProductsRequest());
    const { data } = await axios.get(`${server}/get-all-products`);

    console.log("All  PRODUCTS:", data);

    dispatch(getAllProductsSuccess(data.products));
  } catch (error) {
    dispatch(getAllProductsFailed(error.response.data.message));
  }
};
export const getProductsByCategory = (categoryId) => async (dispatch) => {
  try {
    dispatch(getProductsByCategoryRequest());

    const { data } = await axios.get(
      `${server}/products/category/${categoryId}`,
    );
 console.log("SEARCH PRODUCT:", data);

    dispatch(getProductsByCategorySuccess(data.data));
  } catch (error) {
    dispatch(
      getProductsByCategoryFailed(
        error.response?.data?.message || error.message,
      ),
    );
  }
};

export const searchProducts = (query) => async (dispatch) => {
  try {
    dispatch(productSearchRequest());

    const { data } = await axios.get(
      `${server}/products/search?q=${query}`,
    );
console.log("SEARCH RESPONSE:", data);
    dispatch(productSearchSuccess(data.data));
  } catch (error) {
    dispatch(productSearchFail( error.response?.data?.message || error.message,));
  }
};

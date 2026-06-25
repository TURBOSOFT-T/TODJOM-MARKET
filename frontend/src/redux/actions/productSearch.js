import axios from "axios";
import { server } from "../../server";
import {
  productSearchRequest,
  productSearchSuccess,
  productSearchFail,
} from "../slices/productSlice";

export const searchProducts = (keyword) => async (dispatch) => {
  try {
    dispatch(productSearchRequest());

    const { data } = await axios.get(
      `${server}/products/search?q=${keyword}`
    );

    dispatch(productSearchSuccess(data.data));
  } catch (error) {
    dispatch(productSearchFail(error.response?.data?.message));
  }
};
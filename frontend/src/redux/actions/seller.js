import axios from "axios";
import { server } from "../../server";
import { loadSellerFail, loadSellerRequest, loadSellerSuccess } from "../reducers/seller";

export const loadSeller = () => async (dispatch) => {
  const token = localStorage.getItem("shop_token");

  if (!token) {
    dispatch(loadSellerFail("No seller token"));
   
    return;
  }

  try {
    dispatch(loadSellerRequest());
   

    const { data } = await axios.get(`${server}/getseller`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    dispatch(loadSellerSuccess(data.seller || data.data.seller));
  } catch (error) {
    dispatch(loadSellerFail(error?.response?.data?.message || "Erreur seller"));
  }
};
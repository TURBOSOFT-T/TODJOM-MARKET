import axios from "axios";
import { server } from "../../server";

import {
  loadUserRequest,
  loadUserSuccess,
  loadUserFail,
} from "../reducers/user";
import { loadSellerFail, loadSellerSuccess } from "../reducers/seller";

export const loadUser = () => async (dispatch) => {
  const token = localStorage.getItem("token");

  console.log("Token USER envoyé:", token);

  try {
    dispatch(loadUserRequest());

    const { data } = await axios.get(`${server}/user`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
      withCredentials: true,
    });

    console.log("USER DATA:", data);

    dispatch(loadUserSuccess(data.data.user ));
    // dispatch(loadUserSuccess(data.user));
    // dispatch(loadUserSuccess(data.user || data));
  } catch (error) {
    dispatch(loadUserFail(error.response?.data?.message));
  }
};

// load seller

export const loadSeller = () => async (dispatch) => {
 // const token = localStorage.getItem("token");
  const token = localStorage.getItem("shop_token");

  if (!token) {
    dispatch(loadSellerFail("No seller token"));
    return;
  }
console.log("Token SELLER envoyé:", token);
  try {
    dispatch({ type: "LoadSellerRequest" });

    const { data } = await axios.get(`${server}/getseller`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
      withCredentials: true,
    });

    console.log("SELLER DATA:", data);
   dispatch(loadSellerSuccess(data.seller || data.data.seller));
  

  } catch (error) {
     dispatch(loadSellerFail(error?.response?.data?.message || "Erreur seller"));
    
   
  }
};

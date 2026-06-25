import axios from "axios";
import { server } from "../../server";

import {
  getAllBannersRequest,
  getAllBannersSuccess,
  getAllBannersFailed,
} from "../reducers/banner";

export const getAllBanners = () => async (dispatch) => {
  try {
    dispatch(getAllBannersRequest());

    const { data } = await axios.get(
      `${server}/banners`
    );

    console.log("BANNERS API:", data);

    dispatch(getAllBannersSuccess(data.banners));
  } catch (error) {
    dispatch(
      getAllBannersFailed(
        error.response?.data?.message
      )
    );
  }
};
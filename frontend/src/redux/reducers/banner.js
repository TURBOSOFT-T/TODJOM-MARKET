import { createSlice } from "@reduxjs/toolkit";

const bannerSlice = createSlice({
  name: "banner",
  initialState: {
    isLoading: false,
    banners: [],
    error: null,
  },
  reducers: {
    getAllBannersRequest: (state) => {
      state.isLoading = true;
    },

    getAllBannersSuccess: (state, action) => {
      state.isLoading = false;
      state.banners = action.payload;
      state.error = null;
    },

    getAllBannersFailed: (state, action) => {
      state.isLoading = false;
      state.error = action.payload;
    },
  },
});

export const {
  getAllBannersRequest,
  getAllBannersSuccess,
  getAllBannersFailed,
} = bannerSlice.actions;

export default bannerSlice.reducer;
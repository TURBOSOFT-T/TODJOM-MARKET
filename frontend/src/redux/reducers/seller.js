import { createSlice } from "@reduxjs/toolkit";

const sellerSlice = createSlice({
  name: "seller",

  initialState: {
    seller: null,
    isAuthenticated: false,
    loading: true,
    error: null,
  },

  reducers: {
    loadSellerRequest: (state) => {
      state.loading = true;
    },

    loadSellerSuccess: (state, action) => {
      state.loading = false;
      state.seller = action.payload;
      state.isAuthenticated = true;
      state.error = null;
    },

    loadSellerFail: (state, action) => {
      state.loading = false;
      state.seller = null;
      state.isAuthenticated = false;
      state.error = action.payload;
    },

    logoutSeller: (state) => {
      state.loading = false;
      state.seller = null;
      state.isAuthenticated = false;
      state.error = null;
    },
     logout: (state) => {
      state.seller = null;
      state.isAuthenticated = false;
    },
  },
});

export const {
  loadSellerRequest,
  loadSellerSuccess,
  loadSellerFail,
  logoutSeller,
  logout,
} = sellerSlice.actions;

export default sellerSlice.reducer;

/* import { createSlice } from "@reduxjs/toolkit";

const sellerSlice = createSlice({
  name: "seller",
  initialState: {
    seller: null,
    isAuthenticated: false,
    loading: false,
    error: null,
  },
  reducers: {
    loadSellerRequest: (state) => {
      state.loading = true;
    },

    
    loadSellerSuccess: (state, action) => {
      state.loading = false;
      state.seller = action.payload;
      state.isAuthenticated = true;
      state.error = null;
    },

    loadSellerFail: (state, action) => {
      state.loading = false;
      state.seller = null;
      state.isAuthenticated = false;
      state.error = action.payload;
    },

    logout: (state) => {
      state.seller = null;
      state.isAuthenticated = false;
    },
  },
});

export const {
  loadSellerRequest,
  loadSellerSuccess,
  loadSellerFail,
  logout,
} = sellerSlice.actions;

export default sellerSlice.reducer; */
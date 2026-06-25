import { createSlice } from "@reduxjs/toolkit";



const categorytSlice = createSlice({


     name: "categories",
  
  initialState: {
  loading: false,
  error: null,
  },

  reducers: {

     loadCategoryRequest: (state) => {
      state.loading = true;
    },

    loadCategorySuccess: (state, action) => {
      state.loading = true;
      
    },

    loadCategoryFail: (state, action) => {
      state.loading = false;
     
      state.error = action.payload;
    },
   
 },
});

export const {
    loadCategoryFail,
    loadCategorySuccess,
    loadCategoryRequest,
 
} = categorytSlice.actions;

export default categorytSlice.reducer;

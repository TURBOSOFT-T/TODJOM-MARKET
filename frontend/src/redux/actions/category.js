import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axios from "axios";
import { server } from "../../server";


// 🔥 API CALL
export const fetchCategories = createAsyncThunk(
  "categories/fetchCategories",
  async (_, { rejectWithValue }) => {
    try {
      const { data } = await axios.get(`${server}/categories`, {
        headers: {
          Accept: "application/json",
        },
      });

      return data.data;
    } catch (error) {
      return rejectWithValue(
        error.response?.data?.message || "Erreur categories"
      );
    }
  }
);
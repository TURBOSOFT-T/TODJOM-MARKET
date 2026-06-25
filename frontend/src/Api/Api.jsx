import axios from "axios";
import { backend_url } from "../server";

axios.defaults.baseURL = `${backend_url}/`;

const fetchCategory = async () => {
    const url = "categories";
    const response = await axios.get(url);
    return response;
};

const fetchProducts = async () => {
    const url = "products";
    const response = await axios.get(url);
    return response;
};

const LoginPage = async (data) => {
    const url ='login';
    const response = await axios.post(
        url,data,
        // { withCredentials: true }
      )

      return response;
}



export { fetchCategory,fetchProducts,LoginPage };
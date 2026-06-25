import { useSelector } from "react-redux";
import { Navigate } from "react-router-dom";
import Loader from "../components/Layout/Loader";

const SellerProtectedRoute = ({ children }) => {
  const { loading, isAuthenticated } = useSelector(
    (state) => state.seller
  );

  if (loading) {
    return <Loader />;
  }

  if (!isAuthenticated) {
    return <Navigate to="/shop-login" replace />;
  }

  return children;
};

export default SellerProtectedRoute;
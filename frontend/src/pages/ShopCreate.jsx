import React from "react";

import ShopCreate from "../components/Shop/ShopCreate";
import Header from "../components/Layout/Header";
import Footer from "../components/Layout/Footer";

const ShopCreatePage = () => {
  /* const navigate = useNavigate();
  const { isSeller,seller } = useSelector((state) => state.seller);

  useEffect(() => {
    if(isSeller === true){
      navigate(`/shop/${seller._id}`);
    }
  }, []) */
  return (
    <div>
      <Header />
      <ShopCreate />
      <Footer />
    </div>
  );
};

export default ShopCreatePage;

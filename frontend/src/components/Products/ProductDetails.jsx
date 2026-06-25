import React, { useEffect, useState } from "react";
import {
  AiFillHeart,
  AiOutlineHeart,
  AiOutlineMessage,
  AiOutlineShoppingCart,
} from "react-icons/ai";
import { useDispatch, useSelector } from "react-redux";
import { Link, useNavigate } from "react-router-dom";
import { getAllProductsShop } from "../../redux/actions/product";
import { image, server } from "../../server";
import styles from "../../styles/styles";
import {
  addToWishlist,
  removeFromWishlist,
} from "../../redux/actions/wishlist";
import { addToCartAction } from "../../redux/actions/cart";
import { toast } from "react-toastify";
import Ratings from "./Ratings";
import axios from "axios";

const ProductDetails = ({ data }) => {
  const { wishlist } = useSelector((state) => state.wishlist);
  const { cart } = useSelector((state) => state.cart);
  const { user, isAuthenticated } = useSelector((state) => state.user);
  const { allProductsPage } = useSelector((state) => state.products);
  const { seller } = useSelector((state) => state.seller);
  const shopAvatar = seller?.avatar
    ? `http://localhost:8000/Image/Shops/${seller.avatar}`
    : "https://shopo.quomodothemes.website/assets/images/user-1.jpg";

    

  const [count, setCount] = useState(1);
  const [click, setClick] = useState(false);
  const [select, setSelect] = useState(0);

  const navigate = useNavigate();
  const dispatch = useDispatch();
const price = data?.prix || 0;

   const finalPrice = data?.final_price || price;

  const hasPromotion = data?.has_promotion;

  const promoPercent = data?.promotion?.pourcentage || 0;

  // SAFE EFFECT
  useEffect(() => {
    if (data?.shop?.id) {
      dispatch(getAllProductsShop(data.shop._id));
    }

    const exists = wishlist?.find((i) => i.id === data?.id);
    setClick(!!exists);
  }, [data, wishlist, dispatch]);

  const incrementCount = () => setCount((c) => c + 1);
  const decrementCount = () => setCount((c) => (c > 1 ? c - 1 : 1));

  const removeFromWishlistHandler = (data) => {
    setClick(false);
    dispatch(removeFromWishlist(data));
  };

  const addToWishlistHandler = (data) => {
    setClick(true);
    dispatch(addToWishlist(data));
  };

  const addToCartHandler = (id) => {
    const isItemExists = cart?.find((i) => i._id === id);

    if (isItemExists) {
      toast.error("Item already in cart!");
      return;
    }

    if ((data?.stock || 0) < 1) {
      toast.error("Product stock limited!");
      return;
    }

    dispatch(addToCartAction({ ...data, qty: count }));
    toast.success("Item added to cart successfully!");
  };

  // SAFE REVIEWS CALCULATION
  const totalReviewsLength =
    allProductsPage?.reduce(
      (acc, product) => acc + (product?.reviews?.length || 0),
      0
    ) || 0;

  const totalRatings =
    allProductsPage?.reduce(
      (acc, product) =>
        acc +
        (product?.reviews?.reduce(
          (sum, review) => sum + (review?.rating || 0),
          0
        ) || 0),
      0
    ) || 0;

  const avg =
    totalReviewsLength > 0 ? totalRatings / totalReviewsLength : 0;

  const averageRating = avg.toFixed(2);

  const handleMessageSubmit = async () => {
    if (!isAuthenticated) {
      toast.error("Please login to create a conversation");
      return;
    }

    try {
      const res = await axios.post(
        `${server}/conversation/create-new-conversation`,
        {
          groupTitle: data._id + user._id,
          userId: user._id,
          sellerId: data.shop._id,
        }
      );

      navigate(`/inbox?${res.data.conversation._id}`);
    } catch (error) {
      toast.error(error?.response?.data?.message);
    }
  };

  return (
    <div className="bg-white">
      {data ? (
        <div className={`${styles.section} w-[90%] 800px:w-[80%]`}>
          <div className="w-full py-5">
            <div className="block w-full 800px:flex">
              <div className="w-full 800px:w-[50%]">

                
                <img
                  src={`${image}/storage/${data.photo}`}
                  alt=""
                  /* className="w-[80%]" */ className="w-[100%] h-[400px] object-contain"
                />

                <div className="w-full flex">
                  {data?.images?.map((i, index) => (
                    <div
                      key={index}
                      className={`cursor-pointer ${
                        select === index ? "border" : ""
                      }`}
                    >
                      <img
                        src={i?.url}
                        alt=""
                        className="h-[200px] overflow-hidden mr-3 mt-3"
                        onClick={() => setSelect(index)}
                      />
                    </div>
                  ))}
                </div>
              </div>

              <div className="w-full 800px:w-[50%] pt-5">
                <h1 className={styles.productTitle}>{data.nom}</h1>
                <p>{data.description}</p>

                <div className="flex pt-3">
                 {/*  <h4 className={styles.productDiscountPrice}>
                    {data.prix}$
                  </h4>
                  <h3 className={styles.price}>
                    {data.originalPrice ? data.originalPrice + "$" : null}
                  </h3> */}


                   {hasPromotion ? (
              <>
                <h5 className={styles.productDiscountPrice}>{finalPrice}$</h5>

                <h4 className="line-through text-red-600 font-semibold opacity-80">
                  {price}$
                </h4>
                <br />
                
                {hasPromotion && (
                  <span className="line-through bg-red-500 text-white text-xs px-2 py-1 rounded">
                    -{promoPercent}%
                  </span>
                )}
              </>
            ) : (
              <h5 className={styles.productDiscountPrice}>{price}$</h5>
            )}
                </div>

                <div className="flex items-center mt-12 justify-between pr-3">
                  <div>
                    <button
                      className="bg-gradient-to-r from-teal-400 to-teal-500 text-white font-bold rounded-l px-4 py-2"
                      onClick={decrementCount}
                    >
                      -
                    </button>
                    <span className="bg-gray-200 px-4 py-[11px]">
                      {count}
                    </span>
                    <button
                      className="bg-gradient-to-r from-teal-400 to-teal-500 text-white font-bold px-4 py-2"
                      onClick={incrementCount}
                    >
                      +
                    </button>
                  </div>

                  <div>
                    {click ? (
                      <AiFillHeart
                        size={30}
                        color="red"
                        onClick={() => removeFromWishlistHandler(data)}
                      />
                    ) : (
                      <AiOutlineHeart
                        size={30}
                        onClick={() => addToWishlistHandler(data)}
                      />
                    )}
                  </div>
                </div>

                <div
                  className={`${styles.button} !mt-6 !h-11 flex items-center`}
                  onClick={() => addToCartHandler(data._id)}
                >
                  <span className="text-white flex items-center">
                    Add to cart <AiOutlineShoppingCart className="ml-1" />
                  </span>
                </div>

                <div className="flex items-center pt-8">
                  <Link to={`/shop/preview/${data?.shop?._id}`}>
                    <img
                     /*  src={data?.shop?.shopAvatar} */
                        src={shopAvatar}
                      alt="" 
                      className="w-[50px] h-[50px] rounded-full mr-2"
                    />
                  </Link>

                  <div className="pr-8">
                    <h3 className={styles.shop_name}>{data.shop.name}</h3>
                    <h5>
                      ({averageRating}/5) Ratings
                    </h5>
                  </div>

                  <div
                    className={`${styles.button} bg-[#6443d1] mt-4 !h-11`}
                    onClick={handleMessageSubmit}
                  >
                    <span className="text-white flex items-center">
                      Send Message <AiOutlineMessage className="ml-1" />
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* KEEP YOUR ORIGINAL COMPONENT */}
           <ProductDetailsInfo
            data={data}
            allProductsPage={allProductsPage}
            totalReviewsLength={totalReviewsLength}
            averageRating={averageRating}
          /> 
        </div>
      ) : (
        <p className="text-center py-10">Loading...</p>
      )}
    </div>
  );
};


const ProductDetailsInfo = ({
  data,
  products,
  totalReviewsLength,
  averageRating,
}) => {
  const [active, setActive] = useState(1);
   const { seller } = useSelector((state) => state.seller);
 //const { user, isAuthenticated } = useSelector((state) => state.user);
   const shopAvatar = seller?.avatar
    ? `http://localhost:8000/Image/Shops/${seller.avatar}`
    : "https://shopo.quomodothemes.website/assets/images/user-1.jpg";

   

  return (
    <div className="bg-[#f5f6fb] px-3 800px:px-10 py-2 rounded">
      <div className="w-full flex justify-between border-b pt-10 pb-2">
        <div className="relative">
          <h5
            className={
              "text-[#000] text-[18px] px-1 leading-5 font-[600] cursor-pointer 800px:text-[20px]"
            }
            onClick={() => setActive(1)}
          >
            Product Details
          </h5>
          {active === 1 ? (
            <div className={`${styles.active_indicator}`} />
          ) : null}
        </div>
        <div className="relative">
          <h5
            className={
              "text-[#000] text-[18px] px-1 leading-5 font-[600] cursor-pointer 800px:text-[20px]"
            }
            onClick={() => setActive(2)}
          >
            Product Reviews
          </h5>
          {active === 2 ? (
            <div className={`${styles.active_indicator}`} />
          ) : null}
        </div>
        <div className="relative">
          <h5
            className={
              "text-[#000] text-[18px] px-1 leading-5 font-[600] cursor-pointer 800px:text-[20px]"
            }
            onClick={() => setActive(3)}
          >
            Seller Information
          </h5>
          {active === 3 ? (
            <div className={`${styles.active_indicator}`} />
          ) : null}
        </div>
      </div>
      {active === 1 ? (
        <>
          <p className="py-2 text-[18px] leading-8 pb-10 whitespace-pre-line">
            {data.description}
          </p>
        </>
      ) : null}

      {active === 2 ? (
        <div className="w-full min-h-[40vh] flex flex-col items-center py-3 overflow-y-scroll">
          {data &&
            data.reviews.map((item, index) => (
              <div className="w-full flex my-2">
                <img
                 /*  src={`${item.user.avatar?.url}`} */
                 src={shopAvatar}
                  alt=""
                  className="w-[50px] h-[50px] rounded-full"
                />
                <div className="pl-2 ">
                  <div className="w-full flex items-center">
                    <h1 className="font-[500] mr-3">{item.user.nom}</h1>
                    <Ratings rating={data?.ratings} />
                  </div>
                  <p>{item.comment}</p>
                </div>
              </div>
            ))}

          <div className="w-full flex justify-center">
            {data && data.reviews.length === 0 && (
              <h5>No Reviews have for this product!</h5>
            )}
          </div>
        </div>
      ) : null}

      {active === 3 && (
        <div className="w-full block 800px:flex p-5">
          <div className="w-full 800px:w-[50%]">
            <Link to={`/shop/preview/${data.shop._id}`}>
              <div className="flex items-center">
                <img
                  src={`${data?.shop?.avatar?.url}`}
                  className="w-[50px] h-[50px] rounded-full"
                  alt=""
                />
                <div className="pl-3">
                  <h3 className={`${styles.shop_name}`}>{data.shop.name}</h3>
                  <h5 className="pb-2 text-[15px]">
                    ({averageRating}/5) Ratings
                  </h5>
                </div>
              </div>
            </Link>
            <p className="pt-2">{data.shop.description}</p>
          </div>
          <div className="w-full 800px:w-[50%] mt-5 800px:mt-0 800px:flex flex-col items-end">
            <div className="text-left">
              <h5 className="font-[600]">
                Joined on:{" "}
                <span className="font-[500]">
                  {data.shop?.createdAt?.slice(0, 10)}
                </span>
              </h5>
              <h5 className="font-[600] pt-3">
                Total Products:{" "}
                <span className="font-[500]">
                  {products && products.length}
                </span>
              </h5>
              <h5 className="font-[600] pt-3">
                Total Reviews:{" "}
                <span className="font-[500]">{totalReviewsLength}</span>
              </h5>
              <Link to="/">
                <div
                  className={`${styles.button} !rounded-[4px] !h-[39.5px] mt-3`}
                >
                  <h4 className="text-white">Visit Shop</h4>
                </div>
              </Link>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};


export default ProductDetails;
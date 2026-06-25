import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import styles from "../../styles/styles";
import { productData } from "../../static/data";

import {
  AiOutlineSearch,
  AiOutlineShoppingCart,
  AiOutlineHeart,
} from "react-icons/ai";

import { IoIosArrowDown, IoIosArrowForward } from "react-icons/io";

import { BiMenuAltLeft } from "react-icons/bi";
import { CgProfile } from "react-icons/cg";
import { RxCross1 } from "react-icons/rx";

import DropDown from "./Dropdown";
import Navbar from "./Navbar";

import Cart from "../cart/Cart.jsx";
import Wishlist from "../Wishlist/Wishlist.jsx";

import { useSelector, useDispatch } from "react-redux";
import { fetchCategories } from "../../redux/slices/categoriesSlice";
import { searchProducts } from "../../redux/actions/product";
import axios from "axios";
import { server } from "../../server.js";

const Header = ({ activeHeading }) => {
  const [searchTerm, setSearchTerm] = useState("");
  const [searchData, setSearchData] = useState([]);
  const [active, setActive] = useState(false);
  const [dropDown, setDropDown] = useState(false);
  const [openCart, setOpenCart] = useState(false);
  const [openWishlist, setOpenWishlist] = useState(false);
  const [open, setOpen] = useState(false);
  const [config, setConfig] = useState(null);
  const [loading, setLoading] = useState(true);
  
const { searchResults } = useSelector((state) => state.products);

  /* const { isAuthenticated, user } = useSelector((state) => state.user); */
  const userState = useSelector((state) => state.user);

  const user = userState?.user || null;
  const isAuthenticated = userState?.isAuthenticated;
  const { seller } = useSelector((state) => state.seller);
  const isSeller = useSelector((state) => state.seller?.isAuthenticated);
  const { cart } = useSelector((state) => state.cart);
  console.log("Nombre element carte:", cart);
  console.log("data SELLER dasboard:", seller);

  console.log("data USER dasboard:", user);
  // ✅ LOGO dynamique Laravel
  const logoUrl = config?.logo
    ? `http://localhost:8000/storage/${config.logo}`
    : "https://shopo.quomodothemes.website/assets/images/logo-3.svg";

  const avatarUrl =
    user && user.avatar
      ? `http://localhost:8000/Image/Users/${user.avatar}`
      : "https://shopo.quomodothemes.website/assets/images/user-1.jpg";

  const dispatch = useDispatch();

  const { categories } = useSelector((state) => state.categories);

  // LOAD CATEGORIES
  useEffect(() => {
    dispatch(fetchCategories());
  }, [dispatch]);

  console.log("CATEGORIES:", categories);
  // FETCH CONFIG API
  // =========================
  useEffect(() => {
    const fetchConfig = async () => {
      try {
        setLoading(true);
        const { res } = await axios.get(`${server}/config`);

        
        console.log("CONFIG:", res.data);

        // ⚠️ adapte selon ton API Laravel
        setConfig(res.data.data);
      } catch (error) {
        console.log("Erreur config:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchConfig();
  }, []);

  // scroll effect
  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 70) {
        setActive(true);
      } else {
        setActive(false);
      }
    };

    window.addEventListener("scroll", handleScroll);

    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  // search

  const handleSearchChange = (e) => {
    const term = e.target.value;

    setSearchTerm(term);

    const filteredProducts = productData.filter((product) =>
      product.name.toLowerCase().includes(term.toLowerCase()),
    );

    setSearchData(filteredProducts);
  };
  if (loading) {
    /*  return <p className="text-center py-5">Chargement...</p>; */
  }

  const handleClose = () => {
    setOpen(false);
  };
  const openCartHandler = () => {
    setOpenCart(true);
    document.body.style.overflow = "hidden"; // mobile lock scroll
  };

  /* const closeCartHandler = () => {
  setOpenCart(false);
  document.body.style.overflow = "auto";
}; */

  return (
    <>
      {/* TOP HEADER */}
      <div className={`${styles.section}`}>
        <div
          className="hidden 800px:h-[50px] 800px:my-[20px] 800px:flex items-center justify-between"
          onClick={handleClose}
        >
          {/* LOGO */}
          {/* LOGO */}
          <div>
            <Link to="/">
              <img src={logoUrl} alt="logo" className="w-[140px]" />
            </Link>
          </div>
          <br />
          {/* SEARCH */}
          <div className="w-[50%] relative">
            <input
              type="text"
              placeholder="Search Product..."
              value={searchTerm}
              onChange={handleSearchChange}
              className="h-[40px] w-full px-2 border-[#3957db] border-[2px] rounded-md"
            />

            <AiOutlineSearch
              size={30}
              className="absolute right-2 top-1.5 cursor-pointer"
            />

            {searchData && searchData.length !== 0 && (
              <div className="absolute bg-white shadow-lg z-[9] p-4 w-full">
                {searchData.map((i, index) => {
                  const product_name = i.name.replace(/\s+/g, "-");

                  return (
                    <Link to={`/product/${product_name}`} key={index}>
                      <div className="w-full flex items-center py-2">
                        <img
                          src={i.image_Url[0].url}
                          alt=""
                          className="w-[40px] h-[40px] mr-[10px]"
                        />

                        <h1>{i.name}</h1>
                      </div>
                    </Link>
                  );
                })}
              </div>
            )}
          </div>

          {/* SELLER BUTTON */}

          <div className={`${styles.button} ml-4 !rounded-[4px]`}>
            {isSeller ? (
              <Link to="/dashboard">
                <h1 className="text-[#fff] flex items-center">
                  Dashboard Seller
                  <IoIosArrowForward className="ml-1" />
                </h1>
              </Link>
            ) : (
              <Link to="/shop-create">
                <h1 className="text-[#fff] flex items-center">
                  Become Seller
                  <IoIosArrowForward className="ml-1" />
                </h1>
              </Link>
            )}
          </div>
        </div>
      </div>

      {/* MAIN HEADER */}
      <div
        className={`${active ? "shadow-sm fixed top-0 left-0 z-10" : ""}
        transition hidden 800px:flex items-center justify-between w-full bg-[#3321c8] h-[70px]`}
      >
        <div
          className={`${styles.section} relative ${styles.noramlFlex} justify-between`}
        >
          {/* CATEGORIES */}
          <div onClick={() => setDropDown(!dropDown)}>
            <div className="relative h-[60px] mt-[10px] w-[270px] hidden 1000px:block">
              <BiMenuAltLeft size={30} className="absolute top-3 left-2" />

              <button className="h-[100%] w-full flex justify-between items-center pl-10 bg-white font-sans text-lg font-[500] select-none rounded-t-md">
                All Categories
              </button>

              <IoIosArrowDown
                size={20}
                className="absolute right-2 top-4 cursor-pointer"
              />

              {dropDown ? (
                <DropDown
                  categoriesData={
                    Array.isArray(categories)
                      ? categories.map((cat) => ({
                          id: cat?.id,
                          title: cat?.nom || cat?.name,

                          image: cat.photo,
                        }))
                      : []
                  }
                  setDropDown={setDropDown}
                />
              ) : null}
            </div>
          </div>

          {/* NAVBAR */}
          <div className={`${styles.noramlFlex}`}>
            <Navbar active={activeHeading} />
          </div>

          {/* RIGHT SIDE */}
          <div className="flex">
            {/* WISHLIST */}
            <div className={`${styles.noramlFlex}`}>
              <div
                className="relative cursor-pointer mr-[15px]"
                onClick={() => setOpenWishlist(true)}
              >
                <AiOutlineHeart size={30} color="rgb(255 255 255 / 83%)" />

                <span className="absolute right-0 top-0 rounded-full bg-[#3bc177] w-4 h-4 text-white font-mono text-[12px] leading-tight text-center">
                  0
                </span>
              </div>
            </div>

            {/* CART */}
            <div className={`${styles.noramlFlex}`}>
              <div
                className="relative mr-[20px]"
                onClick={() => setOpenCart(true)}
              >
                <AiOutlineShoppingCart
                  size={30}
                  color="rgb(255 255 255 / 83%)"
                  onClick={openCartHandler}
                />
                <span class="absolute right-0 top-0 rounded-full bg-[#3bc177] w-4 h-4 top right p-0 m-0 text-white font-mono text-[12px]  leading-tight text-center">
                  {cart && cart.length}
                </span>
              </div>
            </div>

            {/* PROFILE */}
            <div className={`${styles.noramlFlex}`}>
              <div className="relative cursor-pointer mr-[15px]">
                {isAuthenticated ? (
                  <Link to="/profile">
                    <img
                      src={avatarUrl}
                      className="w-[35px] h-[35px] rounded-full object-cover border border-white"
                      alt="profile"
                    />
                  </Link>
                ) : (
                  <Link to="/login">
                    <CgProfile size={30} color="rgb(255 255 255 / 83%)" />
                  </Link>
                )}
              </div>
            </div>

            {/* CART POPUP */}
            {openCart && <Cart setOpenCart={setOpenCart} />}

            {/* WISHLIST POPUP */}
            {openWishlist && <Wishlist setOpenWishlist={setOpenWishlist} />}
          </div>
        </div>
      </div>

      {/* MOBILE HEADER */}
      <div
        className={`${active ? "shadow-sm fixed top-0 left-0 z-10" : ""}
        w-full h-[60px] bg-[#fff] z-50 top-0 left-0 shadow-sm 800px:hidden`}
      >
        <div className="w-full flex items-center justify-between">
          {/* MENU */}
          <div>
            <BiMenuAltLeft
              size={40}
              className="ml-4"
              onClick={() => setOpen(true)}
            />
          </div>

          {/* LOGO */}
          <div>
            <Link to="/">
              <img src={logoUrl} alt="logo" className="w-[140px]" />
            </Link>
          </div>

          {/* CART */}
          <div>
            <div className="relative mr-[20px]">
              <AiOutlineShoppingCart size={30} onClick={openCartHandler} />

              <span className="absolute right-0 top-0 rounded-full bg-[#3bc177] w-4 h-4 text-white font-mono text-[12px] leading-tight text-center">
                {cart.length}
              </span>
            </div>
          </div>
        </div>

        {/* MOBILE SIDEBAR */}
        {open && (
          <div className="fixed w-full bg-[#0000005f] z-20 h-full top-0 left-0">
            <div className="fixed w-[60%] bg-[#fff] h-screen top-0 left-0 z-10 overflow-y-scroll">
              {/* TOP */}
              <div className="w-full justify-between flex pr-3">
                <div>
                  <div className="relative mr-[15px]">
                    <AiOutlineHeart size={30} className="mt-5 ml-3" />

                    <span className="absolute right-0 top-0 rounded-full bg-[#3bc177] w-4 h-4 text-white font-mono text-[12px] leading-tight text-center">
                      0
                    </span>
                  </div>
                </div>

                <RxCross1
                  size={30}
                  className="ml-4 mt-5"
                  onClick={() => setOpen(false)}
                />
              </div>

              {/* SEARCH */}
              <div className="my-8 w-[92%] m-auto">
                <input
                  type="search"
                  placeholder="Search Product..."
                  className="h-[40px] w-full px-2 border-[#3957db] border-[2px] rounded-md"
                  value={searchTerm}
                  onChange={handleSearchChange}
                />

                {searchData && searchData.length !== 0 && (
                  <div className="absolute bg-[#fff] z-10 shadow w-full left-0 p-3">
                    {searchData.map((i, index) => {
                      const product_name = i.name.replace(/\s+/g, "-");

                      return (
                        <Link to={`/product/${product_name}`} key={index}>
                          <div className="flex items-center py-2">
                            <img
                              src={i.image_Url[0].url}
                              alt=""
                              className="w-[50px] mr-2"
                            />

                            <h5>{i.name}</h5>
                          </div>
                        </Link>
                      );
                    })}
                  </div>
                )}
              </div>

              {/* NAVBAR */}
              <Navbar active={activeHeading} />

              {/* SELLER BUTTON */}

              <div className={`${styles.button} ml-4 !rounded-[4px]`}>
                {isSeller ? (
                  <Link to="/dashboard">
                    <h1 className="text-[#fff] flex items-center">
                      Dashboard Seller
                      <IoIosArrowForward className="ml-1" />
                    </h1>
                  </Link>
                ) : (
                  <Link to="/shop-create">
                    <h1 className="text-[#fff] flex items-center">
                      Become Seller
                      <IoIosArrowForward className="ml-1" />
                    </h1>
                  </Link>
                )}
              </div>

              <br />
              <br />

              {/* PROFILE */}
              <div className="flex w-full justify-center">
                {isAuthenticated ? (
                  <Link to="/profile">
                    <img
                      src={avatarUrl}
                      className="w-[35px] h-[35px] rounded-full object-cover border border-white"
                      alt="profile"
                    />
                  </Link>
                ) : (
                  <>
                    <Link
                      to="/login"
                      className="text-[18px] pr-[10px] text-[#000000b7]"
                    >
                      Login /
                    </Link>

                    <Link to="/signup" className="text-[18px] text-[#000000b7]">
                      Sign up
                    </Link>
                  </>
                )}
              </div>
            </div>
          </div>
        )}
      </div>
    </>
  );
};

export default Header;

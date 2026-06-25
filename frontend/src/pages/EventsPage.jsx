import React from "react";
/* import { useSelector } from "react-redux"; */
//port EventCard from "../components/Events/EventCard";
import Header from "../components/Layout/Header";
/* import Loader from "../components/Layout/Loader"; */
import Footer from "../components/Layout/Footer";
import Events from "../components/Events/Events";

const EventsPage = () => {
  ///st { allEvents, isLoading } = useSelector((state) => state.events);
  //const { allEvents, isLoading } = useSelector((state) => state.events);
  return (
    <>
      <Header />
      <br />
      <Events />
      <br />
      <Footer />
    </>
  );
};

export default EventsPage;

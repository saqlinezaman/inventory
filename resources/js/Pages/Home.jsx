import React from "react";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css"; // Import CSS
import { Link } from "@inertiajs/react";


export default function Home() {
  const showToast = () => {
    Toastify({
      text: "Wel come to the Home Page",
      duration: 3000,
      close: true,
      gravity: "top", // top or bottom
      position: "right", // left, center, right
      style: {
        background: "linear-gradient(to right, #00b09b, #96c93d)",
      },
      onClick: function(){} // optional callback
    }).showToast();
  };

  return (
    <div className="container mt-5" onClick={showToast}>
      <h1 className="text-primary">Hello Bootstrap + React + Tailwind</h1>
      <button className="btn btn-success mt-3">Click Me</button>
    </div>
  );
}


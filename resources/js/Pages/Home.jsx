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
    <div className="flex flex-col items-center justify-center min-h-screen bg-gray-100 gap-4">
      <h1 className="text-3xl font-bold text-blue-600">hello world</h1>

     

      <Link onClick={showToast}
        href="/about"
        className="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition"
      >
        Go to About Page
      </Link>
    </div>
  );
}


import React from "react";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css"; // Import CSS
import { Link } from "@inertiajs/react";
export default function About() {
     const showToast = () => {
        Toastify({
          text: "Welcome to the About Page",
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
        <div className="">
            <h2 className="" >About</h2>
            <button className="...">submit</button>
            <Link onClick={showToast} href="/">Go to Home Page</Link>
        </div>
    );
}

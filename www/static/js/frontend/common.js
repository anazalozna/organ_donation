"use strict";

(function () {

    /* Full Height */
    //set the header slider's height equal to the window's height
    var all_slides = document.querySelectorAll(".slider_h .all_slides");
    window.addEventListener("resize", setHeight, false);
    window.addEventListener("load", setHeight, false);

    function setHeight() {
        all_slides.forEach(function (slide) {
            slide.style.height = window.innerHeight;
        });
    }
    /* End Full Height */

    /* Vertical Nav Animation */
    //slides website's content to the right if nav is active
    var mobile_menu = document.querySelector("#mobile-menu"),
        content_main = document.querySelector(".content_main");

    mobile_menu.addEventListener("change", function () {
        if (mobile_menu.checked != false) {
            content_main.style.transform = "translateX(200px)";
        } else {
            content_main.style.transform = "translateX(0px)";
        }
    }, false);
    /* End Vertical Nav */
})();
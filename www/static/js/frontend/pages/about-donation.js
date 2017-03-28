"use strict";

/**
 * Created by nasia on 24.03.17.
 */

//shows & hides elements when scroll
window.addEventListener("scroll", function () {
    var about_blocks_left = new AnimateElements(".flex_organs .flex_item:nth-child(2n+1)", "transform_X_left");
    about_blocks_left.scroll();
    var about_blocks_right = new AnimateElements(".flex_organs .flex_item:nth-child(2n)", "transform_X_right");
    about_blocks_right.scroll();
}, false);
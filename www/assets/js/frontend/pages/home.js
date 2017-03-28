/**
 * Created by nasia on 24.03.17.
 */

//calls the slider
window.addEventListener("load", function(){goSlider();}, false);
//shows & hides elements when scroll
window.addEventListener("scroll", function () {
    var faq_home = new AnimateElements(".flex_faq .flex_item", "transform_Y");
    faq_home.delayedEffect(250);
}, false);
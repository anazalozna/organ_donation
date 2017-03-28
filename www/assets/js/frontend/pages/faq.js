/**
 * Created by nasia on 24.03.17.
 */

//calls the function when on page load
window.addEventListener("load", function () {
    var faq_blocks = new AnimateElements(".faq_box", "opacity_anim");
    faq_blocks.click(".faq_answer");
}, false);
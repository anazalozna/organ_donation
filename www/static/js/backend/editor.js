"use strict";

/**
 * Created by nasia on 11.03.17.
 */

tinymce.init({
    selector: "textarea", // change this value according to your HTML
    plugins: ["code", "charmap", "link", "image"],
    toolbar: ["undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | charmap code"]
}).then(function () {
    setTimeout(function () {
        return document.querySelector('#mceu_32').style.display = 'none';
    }, 300);
});
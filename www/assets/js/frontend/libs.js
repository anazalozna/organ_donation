function AnimateElements(selector, effect_class) {
    this._selector = selector;
    this._effect_class = effect_class;
    this._time = 0;
    this._reset_effect = "reset_transform";
    this._space_before= 0;
    this._space_after= 700;
}

/**
 * Pass elements to click on and call a _swapClasses
 * with _addClass or _deleteClass passing toggled elements
 *
 * @param toggle_selector String
 */
AnimateElements.prototype.click = function (toggle_selector) {
    var self = this;

    document.querySelectorAll(this._selector).forEach(function (element) {
        element.addEventListener("click", function () {

            document.querySelectorAll(self._selector).forEach(function (other_element) {
                if(element != other_element){
                    self._swapClasses(other_element.querySelector(toggle_selector), self._deleteClass);
                }
            }, false);

            var item = this.querySelector(toggle_selector);
            var class_index = [].indexOf.call(item.classList, self._effect_class);
            if (class_index > -1) {
                self._swapClasses(item, self._addClass);
            }else{
                self._swapClasses(item, self._deleteClass);
            }
        },false);
    });
};

/**
 * Scroll through elements and call a _swapClasses
 * with _addClass or _deleteClass passing toggled elements
 *
 */
AnimateElements.prototype.scroll = function () {
    var self = this;
    document.querySelectorAll(this._selector).forEach(function (element, index) {
        window.addEventListener("scroll", function () {
            var element_pos = element.offsetTop; //element's offset top

            if ((document.documentElement.scrollTop || document.body.scrollTop) >= element_pos - self._space_before &&
                (document.documentElement.scrollTop || document.body.scrollTop) <= element_pos + self._space_after) {
                //console.log("s");
                self._swapClasses(element, self._addClass, index);
            } else {
                self._swapClasses(element, self._deleteClass, index);
            }
        },false);
    });
};

/**
 * Make animation go with delay
 *
 * @param delay
 */
AnimateElements.prototype.delayedEffect = function (delay) {
    this._time = delay;
    this.scroll();
};

/**
 * Find a class with effect and swap it with a reset_effect
 *
 * @param item
 * @param index
 * @private
 */
AnimateElements.prototype._swapClasses = function (item, func, index=0) {
    var self = this;
    if(this._time){
        setTimeout(function(){func.call(self, item)}, index*this._time);
    }else{
        func.call(self, item);
    }

};

/**
 * Reset effects
 *
 * @param item
 * @private
 */
AnimateElements.prototype._addClass = function (item) {
    item.classList.remove(this._effect_class);
    item.classList.add(this._reset_effect);
};

/**
 * Add effects
 *
 * @param item
 * @private
 */
AnimateElements.prototype._deleteClass = function (item) {
    item.classList.add(this._effect_class);
    item.classList.remove(this._reset_effect);
};




/**
 * Slider
 */
function goSlider() {
    //slider
    var slides = document.querySelectorAll(".slide"), //an arr with all slides
        prev_slide = document.querySelector("#prev_slide"), //prev_slide btn
        next_slide = document.querySelector("#next_slide"), //next_slide btn
        cnt = 0, //count every step in slider
        num_of_slides = 1; //number of visible slides

    /**
     * check if current slide is the last
     * if so, all slides become block (not active are hidden with css)
     * if not, specified number of slides become display: none
     *
     * @param e
     */
    function plus_slide(e){
        e ? e.preventDefault() : "";
        if(cnt == slides.length-num_of_slides){
            cnt=0;
            for(let i=0; i<slides.length; ++i){
                slides[i].style.display = "block";
            }
        }else{
            slides[cnt].style.display = "none";
            cnt+=1;
        }
    }

    /**
     * the same as plus_slide but backwards
     *
     * @param e
     */
    function minus_slide(e){
        e ? e.preventDefault() : "";
        if(cnt == 0){
            cnt=slides.length-(num_of_slides-1);
            for(let i=0; i<slides.length-num_of_slides; ++i){
                slides[i].style.display = "none";
            }
        }
        cnt=cnt-1;
        slides[cnt].style.display = "block";
    }

    /**
     * add click events to buttons on slider
     */
    next_slide.addEventListener("click", plus_slide, false);
    prev_slide.addEventListener("click", minus_slide, false);

    /**
     * autoplay
     */
    setInterval(plus_slide, 7000);
}

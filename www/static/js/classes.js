/**
 * Created by nasia on 02/02/17.
 */

'use strict';

/**
 * Class for adding new users
 */

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var NewUser = function () {
    function NewUser(form) {
        _classCallCheck(this, NewUser);

        this.form = form;

        this.logins = this.form.querySelectorAll('input[name="login[]"]');
        this.emails = this.form.querySelectorAll('input[name="email[]"]');
        this.roles = this.form.querySelectorAll('select[name="role[]"]');

        this.errors = [];
    }

    /**
     * Form validation
     */


    _createClass(NewUser, [{
        key: 'validate',
        value: function validate() {
            var self = this;

            // hide success block
            document.querySelector('#users #success').style.display = 'none';

            // remove all errors
            this.form.querySelectorAll('.error').forEach(function (element) {
                element.classList.remove('error');
            });

            var checkField = function checkField(element) {
                if (!element.value) {
                    element.classList.add('error');
                    self.errors.push('Empty field');
                }
            };

            this.logins.forEach(checkField);
            this.emails.forEach(checkField);
            this.roles.forEach(checkField);
        }

        /**
         * Show errors on the page
         */

    }, {
        key: 'showErrors',
        value: function showErrors() {

            // clear previous errors
            document.querySelectorAll('#errors li').forEach(function (li) {
                li.parentNode.removeChild(li);
            });

            if (!this.errors) {
                return;
            }

            // remove duplicates
            this.errors = this.errors.filter(function (item, i, ar) {
                return ar.indexOf(item) === i;
            });

            this.errors.forEach(function (error) {
                var text = document.createTextNode(error);
                var li = document.createElement('li');

                li.appendChild(text);
                document.querySelector('#errors').appendChild(li);
            });
        }

        /**
         * Send ajax query
         */

    }, {
        key: 'send',
        value: function send() {

            // do not send if errors
            if (this.errors.length) {
                return;
            }

            var formData = this.getFormData();
            var ajax = new Ajax('/admin/user/add', true);
            var self = this;

            ajax.setData(formData);

            document.querySelector('#loading').style.display = 'block';

            ajax.send().then(function (response) {
                self.errors = self.errors.concat(response);
                if (self.errors.length) {
                    self.showErrors();
                } else {
                    document.querySelector('#users #success').style.display = 'block';
                    self.refreshPage();
                }
            }, function (error) {
                self.errors.push('Sending error');
                self.showErrors();
                document.querySelector('#loading').style.display = 'none';
            });
        }

        /**
         * Get data of form
         * @returns {{login: *, email: *, role: *}}
         */

    }, {
        key: 'getFormData',
        value: function getFormData() {
            var getValue = function getValue(item) {
                return item.value;
            };
            return {
                'login': [].map.call(this.logins, getValue),
                'email': [].map.call(this.emails, getValue),
                'role': [].map.call(this.roles, getValue)
            };
        }

        /**
         * Refresh use list page data
         */

    }, {
        key: 'refreshPage',
        value: function refreshPage() {
            var ajax = new Ajax('/admin/users');
            var self = this;

            ajax.send().then(function (response) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(response, "text/html");

                self.form.innerHTML = doc.querySelector('form').innerHTML;
                document.querySelector('#loading').style.display = 'none';
            }, function () {
                document.querySelector('#loading').style.display = 'none';
            });
        }
    }]);

    return NewUser;
}();

/**
 * Ajax query based on Promises
 * https://developers.google.com/web/fundamentals/getting-started/primers/promises
 */


var Ajax = function () {
    function Ajax(url, json) {
        _classCallCheck(this, Ajax);

        this.url = url;
        this.method = 'POST';
        this.data = '';
        this.json = json;
    }

    /**
     * Set method type. POST or GET
     *
     * @param type
     */


    _createClass(Ajax, [{
        key: 'setMethod',
        value: function setMethod(type) {
            this.method = type;
        }

        /**
         * Set query data and transform it to str
         *
         * @param data Object
         */

    }, {
        key: 'setData',
        value: function setData(data) {
            var paramStr = '';

            var _loop = function _loop(name) {
                if (!data.hasOwnProperty(name)) {
                    return 'continue';
                }
                if (data[name].forEach) {
                    data[name].forEach(function (element) {
                        paramStr += name + '[]=' + encodeURIComponent(element) + '&';
                    });
                } else {
                    paramStr += name + '=' + encodeURIComponent(data[name]) + '&';
                }
            };

            for (var name in data) {
                var _ret = _loop(name);

                if (_ret === 'continue') continue;
            }
            this.data = paramStr;
        }

        /**
         * Send ajax query
         *
         * @returns {Promise}
         */

    }, {
        key: 'send',
        value: function send() {
            var self = this;

            return new Promise(function (resolve, reject) {
                // Do the usual XHR stuff
                var req = new XMLHttpRequest();
                req.open(self.method, self.url);

                req.onload = function () {
                    // This is called even on 404, 200 etc
                    // so check the status
                    if (req.status == 200) {
                        if (self.json) {
                            resolve(JSON.parse(req.responseText));
                        } else {
                            resolve(req.response);
                        }
                    } else {
                        // Otherwise reject with the status text
                        // which will hopefully be a meaningful error
                        reject(Error(req.statusText));
                    }
                };

                // Handle network errors
                req.onerror = function () {
                    reject(Error("Network Error"));
                };

                req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                // Make the request
                req.send(self.data);
            });
        }
    }]);

    return Ajax;
}();

var Gallery = function () {
    function Gallery(img) {
        var _this = this;

        _classCallCheck(this, Gallery);

        this._img = img;
        this._popup_box = document.querySelector(".popup_bg_dark");
        this._close_icon = document.querySelector(".close_icon");
        this._popup_img = document.querySelector(".popup_img img");
        this._popup_text = document.querySelector(".popup_text");

        document.querySelector(".gal_next").onclick = function () {
            _this._next();
        };
        document.querySelector(".gal_prev").onclick = function () {
            _this._prev();
        };

        this._close_icon.addEventListener("click", function () {
            _this.closePopup();
        }, false);
    }

    _createClass(Gallery, [{
        key: '_next',
        value: function _next() {
            var nextSibling = this._img.parentNode.nextSibling;
            while (nextSibling && nextSibling.nodeType != 1) {
                nextSibling = nextSibling.nextSibling;
            }

            if (!nextSibling) {
                nextSibling = this._img.parentNode.parentNode.querySelector('.flex_item:first-child');
            }
            nextSibling.querySelector("img").click();
        }
    }, {
        key: '_prev',
        value: function _prev() {
            var previousSibling = this._img.parentNode.previousSibling;
            while (previousSibling && previousSibling.nodeType != 1) {
                previousSibling = previousSibling.previousSibling;
            }

            if (!previousSibling) {
                previousSibling = this._img.parentNode.parentNode.querySelector('.flex_item:last-child');
            }

            previousSibling.querySelector("img").click();
        }
    }, {
        key: 'openPopup',
        value: function openPopup() {
            this._clearPopup();

            this._popup_box.style.display = "block";
            var id = this._img.id;
            var ajax = new Ajax("/gallery/" + id, true);
            var self = this;

            ajax.send().then(function (response) {
                self._popup_img.src = "/" + response.image.img;
                self._popup_img.alt = self._img.alt;
                self._popup_img.title = self._img.title;

                self._popup_text.appendChild(document.createTextNode(response.image.text));
            });
        }
    }, {
        key: 'closePopup',
        value: function closePopup() {
            this._popup_box.style.display = "none";
        }
    }, {
        key: '_clearPopup',
        value: function _clearPopup() {
            this._popup_img.src = "";
            this._popup_img.alt = "";
            this._popup_img.title = "";
            while (this._popup_text.firstChild) {
                this._popup_text.removeChild(this._popup_text.firstChild);
            }
        }
    }]);

    return Gallery;
}();
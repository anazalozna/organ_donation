/**
 * Created by nasia on 09.03.17.
 */

'use strict';

/**
 * Class for adding new users
 */

Object.defineProperty(exports, "__esModule", {
    value: true
});

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

exports.default = NewUser;
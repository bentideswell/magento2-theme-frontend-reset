//
//
//
define([], function() {
    var errorClass = 'mage-error';

    function isEmpty(v) {
        return !v;
    };
    var tests = {
        required: function(form, input, value, flag) {
            if (flag && isEmpty(value)) {
                return 'Value required';
            }
        },
        "validate-email": function (form, input, value, flag) {
            if (!value.includes('@') || !value.includes('.')) {
                return 'Invalid email format.';
            }
        },
        "validate-password": function (form, input, value, flag) {
            if (value.length < 8) {
                return 'Minimum length: 8 characters';
            }
        },
        "validate-price": function (form, input, value, flag) {
            if (isNaN(parseFloat(value))) {
                return 'Enter a valid price.'
            }
        },
        equalTo: function (form, input, value, sel) {
            var el = form.querySelector(sel);
            if (!el || getValue(el) !== value) {
                return 'Passwords do not match';
            }
        }
    };

    function getValue(e) {
        if (e.tagName === 'INPUT' || e.tagName === 'TEXTAREA') {
            return e.value;
        } else if (e.tagName === 'SELECT') {
            return e.value;
        } else {
            return null;
        }
    }

    function validateField(form, input) {
        if (input.offsetParent === null) {
            return;
        }
        var data = input.getAttribute('data-validate');
        var value = getValue(input);

        if (data === '{required:true}') {
            data = {required: true};
        } else {
            try {
                data = JSON.parse(data);
            } catch (e) {
                console.error('Failed to parse JSON: ' + data);
                return false;
            }
        }

        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                if (typeof tests[key] === 'function') {
                    var result = tests[key](form, input, value, data[key]);

                    if (typeof result === 'string') {
                        return result;
                    }
                }
            }
        }
    }

    function validateOnSubmit(ev) {
        var form = ev.currentTarget;
        var inputs = form.querySelectorAll('*[data-validate]');
        var hasError = false;

        if (inputs.length > 0) {
            for (var i = 0; i < inputs.length; i++) {
                var result = validateField(form, inputs[i]);

                if (result) {
                    hasError = true;
                    inputs[i].classList.add(errorClass);
                    ev.preventDefault();
                    var inputMsg = inputs[i].nextElementSibling;

                    if (!inputMsg || !inputMsg.classList.contains('mage-error')) {
                        inputMsg = document.createElement('div');
                        inputMsg.classList.add('mage-error');
                        inputs[i].parentNode.insertBefore(inputMsg, inputs[i].nextSibling);
                    }

                    inputMsg.innerHTML = result;
                } else {
                    inputs[i].classList.remove(errorClass);

                    var inputMsg = inputs[i].nextElementSibling;

                    if (inputMsg) {
                        inputMsg.remove();
                    }
                }
            }
        }

        if (hasError === false) {
            fpjs.loader.on();
        }
    };

    return function (config, form) {
        form.addEventListener('submit', validateOnSubmit);
    };
});
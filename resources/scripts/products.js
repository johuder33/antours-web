(function(window, $){
    var AJAX_ANTOURS = window.AJAX_ANTOURS;
    var PubSub = window.PubSub;
    var fields = $('.simple-form-field');
    var forms = {};
    var ERROR_FIELD_CLASS = 'is-invalid';
    var ERROR_FIELD_ERROR_CLASS = 'invalid-feedback';
    var btnSender = $('.btn-package');
    var validators = {
        fullname: function(element) {
            var value = element.val();
            var min = element.attr('min') || 0;

            if (min) {
                min = isNaN(parseInt(min, 10)) ? 0 : parseInt(min, 10);
            }

            return value.length > min;
        },

        passport: function(element) {
            var value = element.val();

            if (value.length === 0) {
                return true;
            }

            var regexp = /^[A-Z]?\d+$/;

            return regexp.test(value);
        },

        id_number: function(element, types) {
            validatorName = getValueFrom(types);

            if (!validatorName) {
                return false;
            }

            return this[validatorName](element);
        },

        rut: function(element) {
            var value = element.val();

            if (value.length === 0) {
                return false;
            }

            var regexp = /^\d{7,8}-[k|K|\d]{1}$/;

            return regexp.test(value);
        },

        passport: function(element) {
            var value = element.val();

            if (value.length === 0) {
                return false;
            }

            var regexp = /^([A-Z0-9])+$/;

            return regexp.test(value);
        },

        telephone: function(element) {
            var value = element.val();
            var regexp = /^\d{5,}$/;

            return regexp.test(value);
        },

        email: function(element) {
            var value = element.val();
            var regexp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            return regexp.test(value);
        },

        passengers: function(element) {
            var value = element.val();

            if (isNaN(parseInt(value, 10))) {
                return false;
            }

            value = parseInt(value, 10);

            var min = element.attr('min');
            min = parseInt(min, 10);
            var max = element.attr('max');
            max = parseInt(max, 10);

            return !(value < min || value > max);
        },

        hotel_address: function(element) {
            return true;
        }
    };

    function getValueFrom(fields) {
        var value;

        $.each(fields, function(index, type){
            var field = $(type);
            if (field.is(':checked')) {
                value = field.val();
            }
        });

        return value;
    }

    function parseRUT(rut) {
        var separator = '-';
        if (!rut) {
            return rut;
        }

        rut = rut.replace(separator, '');

        return rut;
    }

    function showForm(element) {
        if (element && element.length > 0) {
            var formId = element.data('form-id');
            var wrapperForm = $('#product-' + formId + ' > .product-form');
            console.log("wrapperForm", wrapperForm);

            if (wrapperForm && wrapperForm.length > 0) {
                wrapperForm.addClass('active');
                element.data('formShown', true);
            }
        }
    }

    function sendForm(element) {
        const formId = element.data('form-id');
        PubSub.emit('product.form.validate', formId);
    }

    PubSub.on('product.form.validate', function(formId){
        var fields = $('#form-' + formId + ' .simple-form-field');
        var types = $('#form-' + formId + ' .id_type');
        var errors = [];

        $.each(fields, function(index, field){
            var currentField = $(field);
            var currentFieldName = currentField.attr('name');

            // clean current field
            PubSub.emit('product.form.field.clean', currentField);

            if (validators.hasOwnProperty(currentFieldName)) {
                var isValidInput = validators[currentFieldName](currentField, types);

                if (!isValidInput) {
                    errors.push(isValidInput);
                    PubSub.emit('product.form.field.error', currentField);
                }
            }
        });

        if (errors.length === 0) {
            PubSub.emit('product.form.submit', formId);
        }
    });

    PubSub.on('product.form.field.clean', function(field) {
        field.removeClass(ERROR_FIELD_CLASS);
        var nextElement = field.next();
        nextElement.removeClass(ERROR_FIELD_ERROR_CLASS);
        nextElement.html('');
    });

    PubSub.on('product.form.field.error', function(field){
        var errorMessage = field.data('error-message');
        field.addClass(ERROR_FIELD_CLASS);
        var nextElement = field.next();
        nextElement.addClass(ERROR_FIELD_ERROR_CLASS);
        nextElement.html(errorMessage);
    });

    PubSub.on('product.form.submit', function(formId) {
        var formElement = $('#form-' + formId);
        var closeIcon = $('.closeIcon[data-form-id="' + formId + '"]');
        var form = forms[formId];

        if (!form.hasOwnProperty('id_type')) {
            var types = $('#form-' + formId + ' .id_type');
            form['id_type'] = getValueFrom(types);
        }

        form['id_number'] = parseRUT(form.id_number);

        var body = {
            nonce: AJAX_ANTOURS.nonce,
            action: AJAX_ANTOURS.package_reservation.action,
            postId: formId
        };

        body = $.extend(body, form);

        $.ajax({
            url: AJAX_ANTOURS.server_url,
            method: 'POST',
            data: body,
            dataType: 'json',
            success: function(response) {
                var resp = response.data;
                if (resp) {
                    var successTitle = AJAX_ANTOURS.translation.RESERVATION_PACKAGE_SUCCESS_TITLE;
                    var successMessage = AJAX_ANTOURS.translation.RESERVATION_PACKAGE_SUCCESS_MESSAGE;
                    if (resp.hasOwnProperty('mail') && resp.mail.hasOwnProperty('sent') && resp.mail.sent.hasOwnProperty('customer') && resp.mail.sent.customer) {
                        formElement.removeClass('running');
                        closeIcon.trigger('click');
                        // reset the form and delete from froms object
                        PubSub.emit('product.form.remove', formId);
                        toastr.success(successMessage, successTitle);
                    }
                }
            },
            error: function(error) {
                var response = error.responseJSON;
                if (response) {
                    var errorTitle = AJAX_ANTOURS.translation.RESERVATION_PACKAGE_ERROR_TITLE;
                    if (response.hasOwnProperty('data')) {
                        toastr.error(response.data, errorTitle);
                    }
                }
            },
            beforeSend: function() {
                formElement.addClass('running');
            }
        })
    });

    btnSender.on('click', function(){
        var formId = $(this).data('id');

        PubSub.emit('product.form.validate', formId);
    });

    $('.products-widgets').on('click', '.form-control-submit', function(){
        var element = $(this);
        var isFormShown = element.data('formShown');

        if (isFormShown) {
            return sendForm(element);
        }

        PubSub.emit('product.form.show', element);
    });

    PubSub.on('product.form.show', function(element){
        if (element && element.length > 0) {
            var formId = element.data('form-id');

            // create current form into forms object
            if (formId && !forms[formId]) {
                forms[formId] = {};
            }

            var wrapperForm = $('#product-' + formId);

            if (wrapperForm && wrapperForm.length > 0) {
                wrapperForm.addClass('active');
                element.data('formShown', true);
            }
        }
    });

    $('.products-widgets').on('click', '.closeIcon', function() {
        var currentBtnClose = $(this);
        var formId = currentBtnClose.data('form-id');
        var formSender = $('.form-control-submit.sender-' + formId);
        var wrapper = $('#product-' + formId);

        if (formSender && formSender.length > 0) {
            formSender.removeData('formShown');
        }

        if (wrapper && wrapper.length > 0) {
            wrapper.removeClass('active');
        }
    });

    PubSub.on('product.form.remove', function(formId) {
        var form = $('#form-' + formId);

        if (formId && forms.hasOwnProperty(formId)) {
            delete forms[formId];
        }

        if (form && form.length > 0) {
            form[0].reset();
        }
    });

    $('.products-widgets, .product-form-quick').on('blur', '.simple-form-field', function() {
        PubSub.emit('product.form.field.change', this);
    });

    PubSub.on('product.form.field.change', function(element){
        var self = $(element);
        var currentFieldName = self.attr('name');
        var fieldValue = self.val() || '';
        var formId = self.data('form-id');

        if (!forms.hasOwnProperty(formId)) {
            forms[formId] = {};
        }

        forms[formId][currentFieldName] = $.trim(fieldValue);
    });
})(window, jQuery);
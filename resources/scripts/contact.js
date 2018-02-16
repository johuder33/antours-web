(function(window, $){
    AJAX_ANTOURS = window.AJAX_ANTOURS;
    var PubSub = window.PubSub;
    var canSendContactForm = true;
    var iconProgress = $('<i class="fa fa-refresh fa-spin icon-progress"></i>');
    var iconAlert = $('<i class="fa" aria-hidden="true"></i>');
    var fields = $('.contact-field');
    var contactButton = $('#contact-btn');
    var notice = $('.block-notice');
    var contactData = {};
    var timer = null;

    function resetForm() {
        var form = $("#contact-form");

        if (form && form[0]) {
            form[0].reset();
            contactData = {};
        }
    }

    PubSub.on('contact.typing', function(name, value) {
        var _value = $.trim(value)
        _value = _value.length === 0 ? null : _value;
        contactData[name] = _value;
    });

    fields.on('keyup', function(){
        var _this = $(this);
        var name = _this.attr('name');
        var value = _this.val();
        PubSub.emit('contact.typing', name, value);
    });
    
    PubSub.on('contact.checkError', function(){
        fields.each(function(index, element){
            var _this = $(element);
            var isRequired = _this.data("required");
            var _value = $.trim(_this.val());
            _this.removeClass('is-invalid');

            if (isRequired && _value.length <= 0) {
                PubSub.emit('contact.field.showError', _this);
            }
        });
    });

    PubSub.on('contact.canSendForm', function(canSendForm) {
        canSendContactForm = canSendForm;
    })

    PubSub.on('contact.field.showError', function(element){
        element.addClass('is-invalid');
        PubSub.emit('contact.canSendForm', false);
    });

    PubSub.on('contact.form.sent', function(sent, timeout, alertClass){
        iconAlert.addClass(sent ? 'fa-check' : 'fa-times');
        var text = notice.data(sent ? 'sent' : 'notsent');
        notice.addClass(alertClass);
        notice.html([iconAlert, ' ', text]);
        notice.removeClass('d-none');

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(function() {
            notice.addClass('d-none');
            notice.removeClass(alertClass);
        }, timeout);
    });

    contactButton.on('click', function(event){
        event.preventDefault();
        PubSub.emit('contact.canSendForm', true);
        PubSub.emit('contact.checkError');
        PubSub.emit('contact.sendForm');
    });

    PubSub.on('contact.btn.disabled', function(isDisabled) {
        var text = isDisabled ? 'progress' : 'default';
        text = contactButton.data(text);
        contactButton.text(text);

        if (isDisabled) {
            contactButton.attr('disabled', 'disabled');
            contactButton.append(iconProgress);
        } else {
            contactButton.removeAttr('disabled');
            contactButton.find(iconProgress).remove();
        }
    });

    PubSub.on('contact.sendForm', function(){
        if (canSendContactForm) {
            // fill action and nonce data
            contactData.action = AJAX_ANTOURS.contact.action;
            contactData.nonce = AJAX_ANTOURS.nonce;
            var url = AJAX_ANTOURS.server_url;

            $.ajax({
                url: url,
                type : 'post',
                data : contactData,
                success : function( response ) {
                    resetForm();
                    PubSub.emit('contact.form.sent', true, 3000, 'alert-success');
                },
                error : function(error) {
                    PubSub.emit('contact.form.sent', false, 3000, 'alert-danger');
                },
                beforeSend: function() {
                    PubSub.emit('contact.canSendForm', false);
                    PubSub.emit('contact.btn.disabled', true);
                },
                complete: function() {
                    PubSub.emit('contact.canSendForm', true);
                    PubSub.emit('contact.btn.disabled', false);
                }
            });
        }
    });
})(window, jQuery);
(function(window, $){
    var AJAX_ANTOURS = window.AJAX_ANTOURS;
    var currentRequest;
    var featureContainer = $('.container-feature');
    var loadingIcon = $('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

    $('.category-radio').on('change', function(event) {
        var category = $(this).val();

        if (currentRequest && currentRequest.readyState !== 4) {
            // if ajax is still running, so cancel it
            currentRequest.abort(900);
        }

        var body = {
            category: category,
            nonce: AJAX_ANTOURS.nonce,
            action: AJAX_ANTOURS.featured.action
        }

        currentRequest = $.ajax({
            url: AJAX_ANTOURS.server_url,
            method: 'POST',
            data: body,
            dataType: 'json',
            success: function(response) {
                featureContainer.html(response.data);
            },
            error: function(error) {
                console.log("error", error);
            },
            abort: function(aborted) {
                console.log("aborted", aborted);
            },
            beforeSend: function() {
                featureContainer.html(loadingIcon);
            }
        });
    });
})(window, jQuery);
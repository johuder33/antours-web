(function($){
    $(document).ready(function(){
        $("#clon_telephone_field, #clon_email_field").on("click", function(){
            var self = $(this);
            var hiddenId = self.attr("id") + "_hidden";
            var cloneInformation = $("#" + hiddenId);
            cloneInformation = cloneInformation.data("field");
            var clone = $("<input/>");
            clone.attr("type", cloneInformation.type);
            clone.attr("name", cloneInformation.name);
            clone.attr("class", cloneInformation.class);
            clone.attr("placeholder", cloneInformation.placeholder);
            $(".container-" + cloneInformation.key).append(clone);
        })

        $(".telephone_field").keydown(function(event){
            var code = event.which || event.keyCode;
            var keyAllowed = [8, 37, 38, 39, 40, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105];

            if (keyAllowed.indexOf(code) > -1) {
                return true;
            }

            event.preventDefault();
        });
    });
})(jQuery);
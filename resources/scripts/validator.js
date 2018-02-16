var AntoursValidator = (function(window, $){
    // create element object validator
    var mapper = null;
    var validators = {};
    var functions = {
        check_name,
        check_idNumber,
        check_phone,
        check_address,
        check_email,
        check_amount_passenger
    };

    /* HELPERS */
    function setMapper(validatorMap) {
        if (mapper) {
            return false;
        }

        mapper = getProtectedJSON(validatorMap);
        fillValidator();
    }

    function getProtectedJSON(json) {
        return JSON.parse(JSON.stringify(json));
    }

    function fillValidator() {
        var colletion = mapper.validators;
        for(key in colletion) {
            var rule = colletion[key];
            var jsFunction = rule['js_func'];

            if (jsFunction && functions.hasOwnProperty(jsFunction)) {
                validators[key] = functions[jsFunction];
            }
        }
    }

    function getMapper() {
        var cloneMapper = getProtectedJSON(mapper);

        return cloneMapper;
    }
    /* HELPERS */

    function check_name(currentValue, rules) {
        var maxlength = rules.maxlength;
        
        if (currentValue && (typeof currentValue === "string")) {
            if (currentValue.length <= maxlength) {
                return true;
            }
        }

        return false;
    }

    function check_idNumber(currentValue, rules) {
        var maxlength = rules.maxlength;

        if (currentValue && (typeof currentValue === "string")) {
            if (currentValue.length <= maxlength) {
                var regexp = /^[0-9]+$/g;

                if (currentValue.match(regexp)) {
                    return true;
                }
            }
        }

        return false;
    }

    function check_phone(currentValue, rules) {
        return check_idNumber(currentValue, rules);
    }

    function check_address(currentValue, rules) {
        return check_name(currentValue, rules);
    }

    function check_email(currentValue, rules) {
        var maxlength = rules.maxlength;

        if (currentValue && (typeof currentValue === "string")) {
            if (currentValue.length <= maxlength) {
                var isEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/g;

                if (currentValue.match(isEmail)) {
                    return true;
                }
            }
        }

        return false;
    }

    function check_amount_passenger(currentValue, rules) {
        var maxlength = rules.maxlength;

        if (currentValue && (typeof currentValue === "string")) {
            if (currentValue.length <= maxlength) {
                var regexp = /^[0-9]+$/g

                if (currentValue.match(regexp)) {
                    return true;
                }
            }
        }

        return false;
    }

    return {
        setMapper,
        getMapper,
        validators
    };
})(window, jQuery);
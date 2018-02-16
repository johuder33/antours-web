jQuery(document).ready(function(){
    (function($, AntoursValidator, self){
        self.AJAX_ANTOURS = AJAX_ANTOURS;
        // register reservation config
        //  AntoursValidator.setMapper(reservation_config);
        var quickFields = AntoursValidator.getMapper();
        var validators = AntoursValidator.validators;

        var language = AJAX_ANTOURS.language;

        var spinner = $('<div class="container-loading"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');

        var page = 0;
        var canLoadComments = true;
        var commentList = $(".comment-list");
        var loadCommentsButton = $('#load-comments');
        var iconProgress = $('#progress-icon');
        var loadBtnText = $('#load-btn-text');
        var tomorrow = new Date();
        var reservation = {};
        var btnMenuMobile = $("#btn-menu");
        var nextToReserverButton = $('.step4');
        var _moment = moment;
        _moment.locale(language);

        // object for making service for transportation
        var roundTrip = $(".roundtrip");
        var startfrom = $(".startfrom");
        var passengerIdMode = $('.passengerId');

        var transports = {
            city_id: null,
            city: null,
            commune_id: null,
            is_round_trip: getInitialCheckedValue(roundTrip),
            start_from_home: getInitialCheckedValue(startfrom),
            street: null,
            build_nro: null,
            dpto: null,
            reference_point: null,
            passengers: $("#passengers").val() * 1,
            service_id: null,
            service: {},
            date_start: null,
            time_start: null,
            date_end: null,
            time_end: null,
            passenger_fullname: null,
            passenger_email: null,
            passenger_phone: null,
            passenger_id_mode: getInitialCheckedValue(passengerIdMode),
            passenger_id: null
        };

        var lastCommuneId = null;
        var canReserve = false;

        tomorrow.setDate(tomorrow.getDate() + 1);

        var currentDate = new Date();
        datesConfig = {
            "pt": {
                startDate: currentDate,
                format: 'dd/mm/yyyy',
                days: ["Domingo", "Segunda-feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"],
                daysShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
                daysMin: ['D','S','T','Q','Q','S','S'],
                monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Sep", "Out", "Nov", "Dez"]
            },
            "es": {
                startDate: currentDate,
                format: 'dd/mm/yyyy',
                days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
            },
            "en": {
                startDate: currentDate,
                format: 'dd/mm/yyyy',
            }
        }

        // var datePickerOptions = datesConfig[language];
        var datePickerOptions = datesConfig['es'];

        var currentTime = new Date();
        var lastCurrentDate = null;
        // reset hours day to 00:00:00
        currentDate.resetHours();

        currentTime.addHours(2);

        var timePickerOptions = {
            'minTime': "00:00",
            'disableTimeRanges': [["00:00", currentTime]],
            'timeFormat': 'H:i',
            'step': 10,
            'forceRoundTime': true
        };

        var goDatePicker = $("#go-date-transport").datepicker(datePickerOptions);
        //$("#go-date-transport").datepicker("setDate", currentDate);

        var returnDatePicker = $("#return-date-transport").datepicker(datePickerOptions);

        var goTimePicker = $("#go-time-transport").timepicker(timePickerOptions);
        // let's set current time and disabled time passed
        var returnTimePicker = $("#return-time-transport").timepicker({ 'timeFormat': 'H:i' });

        // onSelect startDate datepicker
        goDatePicker.on('pick.datepicker', function(e) {
            goDatePicker.datepicker("hide");
            transports['date_start'] = e.date;
            $("#go-time-transport").val("");
            transports.time_start = null;

            if (e.date.getTime() > currentDate.getTime()) {
                timePickerOptions.disableTimeRanges = new Date();
            } else {
                timePickerOptions.disableTimeRanges = [["00:00", currentTime]];
            }

            goTimePicker.timepicker("option", timePickerOptions);

            var _currentDate = goDatePicker.datepicker("getDate");
            // if exist returnDate, so verify if less than new startDate, if so, let's delete it
            var hasReturnDate = removeBlanks(returnDatePicker.val());
            if (hasReturnDate.length > 0) {
                var returnDate = returnDatePicker.datepicker("getDate");
                if ((_currentDate.getTime() === returnDate.getTime()) || _currentDate.getTime() > returnDate.getTime()) {
                    returnDatePicker.datepicker("reset");
                    transports['date_end'] = null;
                }
            }
            
            returnDatePicker.datepicker("setStartDate", e.date);
        });

        //onSelect startTime timepicker
        goTimePicker.on('changeTime', function(e){
            var currentLocalTime = goTimePicker.timepicker('getTime');
            var currentReturnTime = returnTimePicker.timepicker('getTime');
            var hasReturnDate = removeBlanks(returnDatePicker.val());
            var hasGoDate = removeBlanks(goDatePicker.val());
            // save start time
            transports['time_start'] = currentLocalTime;

            if (hasReturnDate.length > 0 && hasGoDate.length > 0) {
                if (goDatePicker.datepicker("getDate").getTime() === returnDatePicker.datepicker("getDate").getTime()) {
                    if ((currentLocalTime && currentLocalTime.getTime()) > (currentReturnTime && currentReturnTime.getTime())) {
                        returnTimePicker.val("");
                        transports['time_start'] = null;
                    }

                    timePickerOptions.disableTimeRanges = [["00:00", currentLocalTime]];
                } else {
                    timePickerOptions.disableTimeRanges = currentLocalTime;
                }
            }

            returnTimePicker.timepicker("option", timePickerOptions);
        });

        // onSelect returnDate datepicker
        returnDatePicker.on('pick.datepicker', function(e) {
            returnDatePicker.datepicker("hide");
            var startDate = goDatePicker.datepicker('getDate');
            // save return human date 
            transports['date_end'] = e.date;

            if (startDate.getTime() === e.date.getTime()) {
                var currentLocalTime = goTimePicker.timepicker('getTime');

                returnTimePicker.val("");
                // reset return time picker
                transports['time_end'] = null;
                currentLocalTime = currentLocalTime ? currentLocalTime : currentTime;
                timePickerOptions.disableTimeRanges = [["00:00", currentLocalTime]];
            } else {
                timePickerOptions.disableTimeRanges = [];
            }

            returnTimePicker.timepicker("option", timePickerOptions);
        });

        returnTimePicker.on('changeTime', function(e){
            var currentLocalTime = returnTimePicker.timepicker('getTime');
            // save return time
            transports['time_end'] = currentLocalTime;
        });

        // handle btn-category to change its class css
        var lastActive = $(".btn-category.active");
        $(".btn-category").click(function(){
            lastActive.removeClass("active");
            lastActive = $(this);
            lastActive.addClass("active");
        });

        btnMenuMobile.on("click", function(){
            $(".menu-list").toggleClass("open");
        });

        /* QUICK FORM */
        // handle open and close mini reserve window
        $('.btn-reserve').on('click' ,function(){
            var currentPackage = $(this);
            var quickForm = currentPackage.data("id");
            var fields = $("#" + quickForm + ' .quick-field');

            if (!reservation.hasOwnProperty(quickForm)) {
                reservation[quickForm] = {};
            }

            fields.each(function(index, element){
                var current = $(element);
                var name = current.attr('name');

                reservation[quickForm][name] = {
                    value: current.val(),
                    field: current
                }
            });

            $("#" + quickForm).addClass("open");
        });

        // handle close quick form
        $('.btn-close-quick-form').on('click', function(){
            var currentPackage = $(this);
            var targetId = currentPackage.data("id");
            var target = $("#" + targetId);
            var quickForm = $("#" + targetId + " form");
            if (quickForm.length && quickForm[0] instanceof HTMLElement) {
                quickForm[0].reset();
            }

            // remove any data stored if close the quick form
            if (reservation[targetId]) {
                delete reservation[targetId];
            }

            target.removeClass("open");
        });

        $('.quick-field').on('keyup', function(e){
            var currentField = $(this);
            var currentPackage = currentField.data('id');
            var name = currentField.attr('name');
            var value = removeBlanks(currentField.val());

            var currentReservation = reservation[currentPackage];

            currentReservation[name].value = value;
        });

        $('.btn-makeReserve').on('click', function() {
            var packageId = $(this).data("id");
            var form = $("#" + packageId + " form");
            var fields = reservation[packageId];
            var emptyFormMessage = quickFields.empty;
            var postId = packageId.split("-");
            postId = postId ? postId.pop() : false;

            if (!fields) {
                window.alert(emptyFormMessage);
                return;
            }

            var fieldsToValidate = quickFields.validators;
            var errors = [];

            for (field in fieldsToValidate) {
                var currentField = fieldsToValidate[field];
                var attributes = currentField.attributes;
                var isRequired = attributes.required;
                var currentData = fields[field];
                var currentValue = currentData ? currentData.value : false;
                var currentFieldHTML = currentData.field;
                var errorItem = currentFieldHTML.next();

                if (isRequired || (currentValue && removeBlanks(currentValue).length > 0)) {
                    var validator = validators[field];
                    var error;

                    if (validator) {
                        isValid = validator(currentValue, attributes);

                        if (!isValid) {
                            var errorMessage = currentField.error;
                            currentFieldHTML.parent().addClass('has-error');
                            errorItem.text(errorMessage);
                            errors.push(true);
                            break;
                        }
                    }

                    if (!errorItem.is(':empty')) {
                        errorItem.text("");
                        currentFieldHTML.parent().removeClass('has-error');
                    }
                }
            }

            if (errors.length > 0) {
                return; 
            }

            var data = normalizeDataPackage(fields);

            data.action = quickFields.actionName;
            data.nonce = quickFields.nonce;
            data.postId = postId;
            var loader = $("#"+ packageId + " .layout-loader");
            var btnClosing = $("#" + packageId + " .btn-close-quick-form");

            sendRequest(data, function(data, status) {
                if (form.length > 0) {
                    form.trigger("reset");
                    btnClosing.trigger("click");
                }
            }, function(XHR) {
                console.log("XHR error", XHR);
            }, function() {
                loader.addClass("active");
            }, function() {
                loader.removeClass("active");
            });
            
        });
        /* QUICK FORM */

        function normalizeDataPackage(fields) {
            var data = {};
            $.each(fields, function(fieldName, object) {
                var value = object['value'];
                if (value.length > 0) {
                    data[fieldName] = value;
                }
            });

            return data;
        }

        function sendRequest(data, onSuccess, onError, beforeSend, onComplete) {
            $.ajax({
                url : AJAX_ANTOURS.server_url,
                type : 'post',
                data : data,
                success: function(_data, textStatus, XHR) {
                    if (onSuccess) {
                        onSuccess(_data, textStatus, XHR);
                    }
                },
                error: function(XHR, textStatus, errorThrown) {
                    if (onError) {
                        onError(XHR, textStatus, errorThrown);
                    }
                },
                beforeSend: function(XHR, object) {
                    if (beforeSend) {
                        beforeSend(XHR, object);
                    }
                },
                complete: function(XHR, textStatus) {
                    if(onComplete) {
                        onComplete(XHR, textStatus);
                    }
                }
            });
        }

        //handle scrollable links
        $('.menu-link').on('click', function(e){
            var self = $(this);
            var isScrollable = self.data('scrollable');
            if (isScrollable) {
                e.preventDefault();
                var target = self.attr('href');
                target = $(target);

                if (target.length > 0) {
                    var offset = target.offset();
                    var screen = $('html, body');
                    screen.stop().animate({scrollTop: offset.top}, 500, 'swing');
                }
            }
        });

        var validatorByName = {
            fullname: function(field) {
                var isSuccessful = false;
                var maxLength = 100;
                var minLength = 5;
                var value = removeBlanks(field.val());
                var isRequired = field.attr('required');
                var length = value.length;

                if (isRequired) {
                    if (length >= minLength && length <= maxLength) {
                        isSuccessful = true;
                    }
                }

                return isSuccessful;
            },
            id_number: function(field) {
                var isSuccessful = false;
                var idNumberRegExp = /^(?!^0+$)[a-zA-Z0-9]{3,20}$/;
                var value = field.val();

                if (value.match(idNumberRegExp)) {
                    isSuccessful = true;
                }

                return isSuccessful;
            },
            phones: function(field, isPureValue) {
                isPureValue = isPureValue || false;
                var isSuccessful = false;
                var phoneRegExp = /^[0-9]{5,15}$/;
                var value = isPureValue ? field : field.val();

                if (value.match(phoneRegExp)) {
                    isSuccessful = true;
                }

                return isSuccessful;
            },
            amount_passenger: function(field) {
                var isSuccessful = false;
                var amountRegExp = /^[0-9]{1,3}$/;
                var value = field.val();

                if (value.match(amountRegExp)) {
                    isSuccessful = true;
                }

                return isSuccessful;
            },
            hotel_address: function(field) {
                var isSuccessful = true;
                var value = field.val();

                if (removeBlanks(value).length > 0) {
                    if (value.length > 255) {
                        isSuccessful = false;
                    }
                }

                return isSuccessful;
            },
            service_type: function(field) {
                var isSuccessful = true;
                var value = field.val();

                return isSuccessful;
            },
            email: function(field, isPureValue) {
                isPureValue = isPureValue || false;
                var isSuccessful = false;
                var value = isPureValue ? field : field.val();
                var emailRegexp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if (value.match(emailRegexp)) {
                    isSuccessful = true;
                }

                return isSuccessful;
            }
        }

        function validateFields(postId) {
            if (!postId) return false;
            var fields = $('#package-'+postId+' .quick-field');
            var limit = fields.length;
            var hasValidInputs = true;
            
            fields.each(function(index, element){
                if (!hasValidInputs) {
                    return false;
                }

                var field = $(this);
                var name = field.attr('name');

                if (validatorByName.hasOwnProperty(name)) {
                    hasValidInputs = validatorByName[name](field);
                    if (!hasValidInputs) {
                        field.addClass('error');
                    }
                }
            });

            return !hasValidInputs;
        }

        $('#passengers').change(function(){
            var selector = $(this);
            var passengers = selector.val() * 1;

            transports.passengers = passengers;
        });

        // handle active links
        var pathname = document.location.pathname;
        var links = $('.menu-link');
        
        links.each(function(index, element){
            var self = $(element);
            var href = self.data('href');

            if (href) {
                if (pathname.indexOf(href) > -1) {
                    self.addClass('active');
                    return;
                }
            }
        });

        function hideButtonWhenNotMore(more) {
            var loaderText = 'Cargar mas';
            if(!more) {
                loadBtnText.text(loaderText);
                iconProgress.addClass('d-none');
                loadCommentsButton.addClass('d-none');
                canLoadComments = false;
                return;
            }
            
            loadBtnText.text(loaderText);
            iconProgress.addClass('d-none');
            canLoadComments = true;
        }

        $("#loader_posts").click(function(){
            var self = $(this);

            if (page === 0) {
                page = 1;
            }

            page++;

            jQuery.ajax({
                url : services_config.ajax_url,
                type : 'post',
                data : {
                    action: services_config.actionName,
                    nonce: services_config.nonce,
                    page: page,
                    taxID: self.data('tax')
                },
                success : function( response ) {
                    if (response.success) {
                        var packages = response.data.packages;

                        if (packages && packages.length > 0) {
                            packages.forEach(function(item){
                                $('.each-package').append(item);
                            });
                        }
                    }
                    
                    if (!response.data.more) {
                        self.remove();
                    }
                },
                error : function(error) {
                    console.log("error", error);
                },
                beforeSend: function() {
                    return;
                }
            });
        });

        loadCommentsButton.click(function(){
            if (!canLoadComments) {
                return;
            }
            
            page++;

            jQuery.ajax({
                url : AJAX_ANTOURS.server_url,
                type : 'post',
                data : {
                    action : AJAX_ANTOURS.comments.action,
                    post_id : AJAX_ANTOURS.postId,
                    page: page,
                    nonce: AJAX_ANTOURS.nonce
                },
                success : function( response ) {
                    var more = response.data.more;
                    
                    if (response.success) {
                        var comments = response.data.comments;
                        if (comments.length > 0) {
                            comments.forEach(function(comment) {
                                commentList.append(comment);
                            });
                        }
                    }

                    hideButtonWhenNotMore(more);
                },
                error : function(error) {
                    console.log("error", error);
                },
                beforeSend: function() {
                    loadBtnText.text('cargando...');
                    iconProgress.removeClass('d-none');
                    canLoadComments = false;
                }
            });
        });

        function validateSecondStep() {
            var errors = [];
            var isRoundTrip = transports.is_round_trip;
            var dateGo = transports.date_start;
            var timeGo = transports.time_start;
            var dateReturn = transports.date_end;
            var timeReturn = transports.time_end;

            if (isRoundTrip) {
                if (!(dateGo instanceof Date) || !(dateReturn instanceof Date) || !(timeGo instanceof Date) || !(timeReturn instanceof Date)) {
                    errors.push(true);
                }
            } else {
                if (!(dateGo instanceof Date) || !(timeGo instanceof Date)) {
                    errors.push(true);
                }
            }

            return errors;
        }

        /* Listen for click on reservation button hanlders */
        $(".btn-next-step").on("click", function(event){
            event.preventDefault();
            var currentButton = $(this);
            var nextStep = currentButton.data("step");
            var errors = [];

            if (nextStep === ".step2") {
                errors = validateFirstStep();
            }

            if (nextStep === ".step3") {
                errors = validateSecondStep();

                if (errors.length <= 0) {
                    var hasCommuneId = transports.commune_id;

                    if (hasCommuneId !== null && hasCommuneId !== lastCommuneId) {
                        getServicesByCommune();
                    }
                }
            }

            if (nextStep === ".step4") {
                if (!canReserve) {
                    return;
                }

                var preview = new Previewer(transports, _moment, $);

                preview.createTableHTML();

                $(".container-resume").html(preview.getTable());
            }

            if (errors.length > 0) {
                return;
            }

            $(".steps").removeClass("current");
            $(nextStep).addClass("current");
        });

        $('.steps').on('click', '.service-radio', function() {
            var radio = $(this);
            var serviceId = radio.val();
            var serviceObj = JSON.parse(radio.data('service'));
            transports.service_id = serviceId;
            transports.service = serviceObj;
        });

        $('.btn-submit').click(function(event){
            event.preventDefault();

            var error = validatePassengerInfo();

            if (error) {
                return;
            }

            var startFrom = transports.start_from_home ? getAddress() : AJAX_ANTOURS.translation.TAXI_BOOKING_AIRPORT;
            var endTo = !transports.start_from_home ? getAddress() : AJAX_ANTOURS.translation.TAXI_BOOKING_AIRPORT;
            var isRoundTrip = transports.is_round_trip;
            var communeId = transports.commune_id;
            var date_start = transports.date_start instanceof Date ? transports.date_start.getTime() : null;
            var date_end = transports.date_end instanceof Date ? transports.date_end.getTime() : null;
            var time_start = transports.time_start instanceof Date ? transports.time_start.getTime() : null;
            var time_end = transports.time_end instanceof Date ? transports.time_end.getTime() : null;
            var passengers = transports.passengers;
            var passenger_email = transports.passenger_email;
            var passenger_phone = transports.passenger_phone;
            var passenger_fullname = transports.passenger_fullname;
            var price = transports.service ? transports.service.price : null;
            var service_id = transports.service_id;
            var passenger_id = transports.passenger_id;
            var passenger_id_mode = transports.passenger_id_mode;

            var body = {
                startFrom: startFrom,
                endTo: endTo,
                communeId: communeId,
                isRoundTrip: isRoundTrip,
                departureDate: date_start,
                departureTime: time_start,
                returnDate: date_end,
                returnTime: time_end,
                passengers: passengers,
                service_id: service_id,
                price: price,
                passenger_id: passenger_id,
                passenger_id_mode: passenger_id_mode,
                passenger_email: passenger_email,
                passenger_phone: passenger_phone,
                passenger_fullname: passenger_fullname,
                action: AJAX_ANTOURS.transbooking.reservation.action,
                nonce: AJAX_ANTOURS.nonce
            };

            $.ajax({
                url: AJAX_ANTOURS.server_url,
                method: 'POST',
                data: body,
                success: function(data) {
                    console.log("Data", data);
                },
                error: function(error) {
                    console.log("error", error);
                }
            })

            console.log("Completed", transports);
        });

        function getAddress() {
            var street = transports.street;
            var build_nro = transports.build_nro;
            var dpto = transports.dpto;
            var reference_point = transports.reference_point;
            var city = transports.city;
            var address = [street, "#" + build_nro, "DEPTO. " + dpto, city];
            if (reference_point) {
                address.push(reference_point);
            }
            address = address.join(", ");

            return address;
        }

        function validatePassengerInfo() {
            var fullname = transports.passenger_fullname;
            var customerId = transports.passenger_id;
            var idMode = transports.passenger_id_mode;
            var email = transports.passenger_email;
            var phone = transports.passenger_phone;
            var modeEnabled = ['rut', 'passport'];

            if (!fullname || !customerId || !email || !idMode) {
                return true;
            }

            if ($.trim(fullname).length === 0 || $.trim(customerId ).length === 0 || $.trim(email).length === 0) {
                return true;
            }

            var isValidEmail = validatorByName.email(email, true);

            if (!isValidEmail) {
                return true;
            }

            if (phone && $.trim(phone).length > 0) {
                var isValidPhone = validatorByName.phones(phone, true);

                if (!isValidPhone) {
                    return true;
                }
            }

            if(modeEnabled.indexOf(idMode) < 0) {
                return true;
            }

            return false;
        }

        function resetFields() {
            transports.service_id = null;
        }

        function getServicesByCommune() {
            var communeId = transports.commune_id;

            var body = {
                action: AJAX_ANTOURS.transbooking.services.action,
                nonce: AJAX_ANTOURS.nonce,
                communeId: communeId
            };

            var servicesContainer = $('.services_container');

            $.ajax({
                url: AJAX_ANTOURS.server_url,
                type: 'post',
                data: body,
                success: function(data){
                    var services = data.data;

                    if (services && services.length > 0) {
                        var table = new TableServices([
                            {
                                content: $('<i class="fa fa-car" aria-hidden="true"></i>')
                            },
                            {
                                content: AJAX_ANTOURS.translation.TAXI_BOOKING_PRICE
                            },
                            {
                                content: AJAX_ANTOURS.translation.TAXI_BOOKING_SERVICE_NAME
                            },
                            {
                                content: AJAX_ANTOURS.translation.TAXI_BOOKING_SERVICE_DESC
                            }
                        ], $);

                        table.buildRowsData(services);
                        table.buildTable();

                        var servicesTable = table.getTable();

                        servicesContainer.html(servicesTable);
                        var service = services[0];
                        var serviceId = service ? service.id_single_service : null;
                        transports.service_id = serviceId;
                        transports.service = service;
                    }

                    canReserve = true;
                    nextToReserverButton.removeAttr('disabled');
                },
                error: function(error){
                    var response = error.responseJSON;

                    if (!response.success) {
                        servicesContainer.html(response.data);
                    }
                    canReserve = false;
                    nextToReserverButton.attr('disabled', 'disabled');
                },
                beforeSend: function() {
                    if (servicesContainer && servicesContainer.length > 0) {
                        servicesContainer.html(spinner);
                    }
                },
                complete: function() {
                    lastCommuneId = transports.commune_id;
                }
            });

            return true;
        }

        $("#getCities").change(function() {
            var communeSelectId = "#getCommuneByCityId";
            var selectByCommune = $(communeSelectId);
            var firstOptionText = $(communeSelectId + " option:first").text();
            var spinner = $(".spinner-commune");
            var value = $(this).val();
            var city = $(this).find(':selected').data('name');

            transports["city_id"] = value;
            transports["commune_id"] = null;
            transports["city"] = city;

            $.ajax({
                url : AJAX_ANTOURS.server_url,
                type : 'post',
                dataType: 'json',
                data : { cityId: value, action: AJAX_ANTOURS.transbooking.communes.action, nonce: AJAX_ANTOURS.nonce },
                success: function(_data, textStatus, XHR) {
                    selectByCommune.text("");
                    selectByCommune.append($("<option>", {
                        value: "",
                        text: firstOptionText
                    }));

                    if (_data && _data.success) {
                        var communes = _data.data;
                        $.each(communes, function(index, item) {
                            selectByCommune.append($("<option>", {
                                value: item.id_commune,
                                text: item.name
                            }))
                        });
                    }
                },
                error: function(XHR, textStatus, errorThrown) {
                    
                },
                beforeSend: function(XHR, object) {
                    spinner.removeClass("d-none");
                    selectByCommune.addClass("d-none");
                },
                complete: function(XHR, textStatus) {
                    spinner.addClass("d-none");
                    selectByCommune.removeClass("d-none");
                }
            });
        });

        $("#getCommuneByCityId").change(function(evt){
            var self = $(this);
            var communeId = self.val();

            // assign the value to the object transport
            transports["commune_id"] = communeId;
        });

        startfrom.click(function(){
            // update start trip from value
            // 0 => Airport
            // 1 => Home
            var startFrom = $(this).val();
            startFrom = getValAsBool(startFrom);
            transports.start_from_home = startFrom;
        })

        passengerIdMode.click(function(){
            var idMode = $(this).val();
            idMode = getValAsBool(idMode);
            transports.passenger_id_mode = idMode;
        });

        function getValAsBool(value) {
            if (value) {
                var val = parseInt(value, 10);

                if (!isNaN(val)) {
                    val = !!val;
                    return val;
                }
            }

            return value;
        }

        function removeBlanks(value) {
            var val = $.trim(value);

            return val;
        }

        function getInitialCheckedValue(field) {
            var value = null;
            for(var i = 0, limit = field.length; i < limit; i++) {
                var currentField = field[i];
                if (currentField.checked) {
                    var val = currentField.value;
                    value = getValAsBool(val);
                    break;
                }
            }

            return value;
        }

        $(".roundtrip").click(function(){
            // update start trip from value
            // 0 => one trip
            // 1 => round trip
            var roundtrip = $(this).val();
            roundtrip = getValAsBool(roundtrip);
            transports["is_round_trip"] = roundtrip;
            var containerReturnDate = $(".container-return-date");

            if (roundtrip) {
                containerReturnDate.show();
            } else {
                containerReturnDate.hide();
            }
        })

        function sanitizeValue(value) {
            var val = removeBlanks(value);

            return val.length > 0 ? val : null;
        }

        $(".t-input-control").keyup(function(){
            var currentInput = $(this);
            var dataId = currentInput.data("id");
            var newValue = sanitizeValue(currentInput.val());
            var oldValue = transports[dataId];

            if (newValue !== oldValue) {
                transports[dataId] = newValue;
            }
        });

        function validateFirstStep() {
            var errors = [];
            var city_id = transports.city_id;
            var commune_id = transports.commune_id;
            var street = transports.street;
            var build_nro = transports.build_nro;
            var dpto = transports.dpto;
            
            if (city_id === "" || city_id === null || city_id === undefined) {
                errors.push("City is missing");
            }

            if (commune_id === "" || commune_id === null || commune_id === undefined) {
                errors.push("Commune is missing");
            }

            if (street === "" || street === null || street === undefined) {
                errors.push("Street is missing");
            }

            if (build_nro === "" || build_nro === null || build_nro === undefined) {
                errors.push("Nro is missing");
            }

            if (dpto === "" || dpto === null || dpto === undefined) {
                errors.push("Dpto is missing");
            }

            return errors;
        }
    })(jQuery, AntoursValidator, window);
});

/* alter prototype for Date Object */

Date.prototype.addHours = function(hours) {
    if (!hours) return;
    var hoursAdded = (Math.abs(hours) * 60 * 60 * 1000);
    this.setTime(this.getTime() + hoursAdded);
    return this;
}

Date.prototype.getHumanDate = function(separator) {
    separator = separator || "/";
    var year = this.getFullYear();
    var month = this.getHumanMonth();
    var day = this.getHumanDay();
    var humanDate = [day, month, year];

    return humanDate.join(separator);
}

Date.prototype.getHumanMonth = function() {
    var month = this.getMonth() + 1;

    month = month < 10 ? '0' + month : month;

    return month;
}

Date.prototype.getHumanDay = function() {
    var day = this.getDate();

    day = day < 10 ? '0' + day : day;

    return day;
}

Date.prototype.resetHours = function() {
    this.setHours(0, 0, 0, 0);
}

/**
 * Create a Validator for fields
 */

function Validator(values, $) {
    this.$ = $;
    this.fields = {};
    this.errors = [];
    this.values = {};
}

Validator.prototype.setFields = function(fields) {
    for(var i = 0, limit = fields.length; i < limit; i++) {
        var field = fields[i];
        var name = field.element.data("name");
        this.values[name] = field.element.val();
        this.listen(field);
        this.fields[name] = field;
    }
}

Validator.prototype.listen = function(field) {
    field.element.change(function(){
        var name = field.element.data("name");
        this.values[name] = field.element.val();
    }.bind(this));
}

Validator.prototype.setValidator = function(fieldName, validator) {
    this.fields[fieldName] = validator;
}

Validator.prototype.flushErrors = function() {
    this.errors.length = 0;
}

Validator.prototype.makeValidation = function() {
    var limit = arguments.length;

    for(var i = 0; i < limit; i++) {
        var field = arguments[i];

        if (this.fields.hasOwnProperty(field)) {
            var currentField = this.fields[field];
            var value = this.values[field];
            currentField.validator.call(this, value, currentField);
        }
    }
}

Validator.prototype.hasErrors = function() {
    return this.errors.length;
}

Validator.prototype.addError = function(message) {
    this.errors.push(message);
}

/**
 * Field class type
 */

function Field(element) {
    this.element = element;
}

function TableServices(cols, $) {
    this.table = $("<table class='table table-responsive'>");
    this.head = $("<thead>");
    this.body = $("<tbody>");
    this.cols = buildRowsHead(cols);
    this.children = null;
    this.UUID = new Date() * 1;

    function buildRowsHead(cols) {
        var headRows = [];

        for(var i = 0, limit = cols.length; i < limit; i++) {
            var column = cols[i];
            var text = column.content;
            var HTMLCol = $("<th>");

            HTMLCol.append(text);

            headRows.push(HTMLCol);
        }

        return headRows;
    }

    this.buildRowsData = function(services) {
        var bodyRows = [];
        for(var i = 0, limit = services.length; i < limit; i++) {
            var service = services[i];
            var serviceAsJSON = JSON.stringify(service);
            var price = service.price;
            var serviceName = service.service_name;
            var descService = service.desc_service;
            var commune = service.name;
            var serviceId = service.id_single_service;
            // create input ratio instance
            var radio = $("<input type='radio' class='service-radio'>");
            radio.data('service', serviceAsJSON);
            radio.attr('name', 'service-' + this.UUID);
            radio.val(serviceId);

            if (i === 0) {
                // first row as marked
                radio.attr('checked', 'checked');
            }

            var HTMLTr = $("<tr>");
            var ratioContainer = $("<td>");
            ratioContainer.append(radio);

            var priceContainer = $("<td>");
            priceContainer.append(price);

            var serviceNameContainer = $("<td>");
            serviceNameContainer.append(serviceName);

            var serviceDescContainer = $("<td>");
            serviceDescContainer.append(descService);

            HTMLTr.append([ratioContainer, priceContainer, serviceNameContainer, serviceDescContainer]);

            bodyRows.push(HTMLTr);
        }

        this.children = bodyRows;
    }

    this.buildTable = function() {
        // add header rows
        this.head.append(this.cols);

        // add header to table
        this.table.append(this.head);

        // add children to body
        this.body.append(this.children);

        // add body to table
        this.table.append(this.body);
    }

    this.getTable = function() {
        return this.table;
    }
}


function Previewer(data, moment, $) {
    this.data = JSON.parse(JSON.stringify(data));
    this.isHome = this.data.start_from_home;
    this.$ = $;
    this.table = [];
    this.moment = moment;
}

Previewer.prototype.isFloat = function(n) {
    return Number(n) === n && n % 1 !== 0;
}

Previewer.prototype.getGoTrip = function() {
    var $ = this.$;
    var data = this.data;

    var title = this.getTitle(true);
    var origin = this.getAddress(this.isHome);
    var destiny = this.getAddress(!this.isHome);
    var service = this.getServiceName();
    var timeObj = this.getTime('HH:mm');
    var passengers = this.getPassengers();
    var price = this.calculatePrice();
    var time = timeObj.go;

    var table = $("<table class='table table-responsive table-bordered table-sm'>");
    var thead = $("<thead>");
    var tbody = $("<tbody>");
    var tr = $("<tr>");
    var th = $("<th class='title-table'>");
    th.attr("colspan", "2");
    th.text(title);
    tr.append(th);
    thead.append(tr);

    var rows = [
        [AJAX_ANTOURS.translation.TAXI_BOOKING_ORIGIN, origin],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_DESTINY, destiny],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_SERVICE_LABEL, service],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_TIME_GO, time],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_PASSENGERS, passengers],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_PRICE, price]
    ];

    for(var i = 0, limit = rows.length; i < limit; i++) {
        var row = $("<tr>");
        var cols = rows[i];

        for(var j = 0, size = cols.length; j < size; j++) {
            var _td = cols[j];
            var col = $("<td>");

            col.text(_td);

            row.append(col);
        }

        tbody.append(row);
    }

    table.append(thead);
    table.append(tbody);

    this.table.push(table);
}

Previewer.prototype.getReturnTrip = function() {
    var $ = this.$;
    var data = this.data;

    var title = this.getTitle(false);
    var origin = this.getAddress(!this.isHome);
    var destiny = this.getAddress(this.isHome);
    var service = this.getServiceName();
    var timeObj = this.getTime('HH:mm');
    var passengers = this.getPassengers();
    var price = this.calculatePrice();
    var time = timeObj.return;

    var table = $("<table class='table table-responsive table-bordered table-sm'>");
    var thead = $("<thead>");
    var tbody = $("<tbody>");
    var tr = $("<tr>");
    var th = $("<th class='title-table'>");
    th.attr("colspan", "2");
    th.text(title);
    tr.append(th);
    thead.append(tr);

    var rows = [
        [AJAX_ANTOURS.translation.TAXI_BOOKING_ORIGIN, origin],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_DESTINY, destiny],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_SERVICE_LABEL, service],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_TIME_RETURN, time],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_PASSENGERS, passengers],
        [AJAX_ANTOURS.translation.TAXI_BOOKING_PRICE, price]
    ];

    for(var i = 0, limit = rows.length; i < limit; i++) {
        var row = $("<tr>");
        var cols = rows[i];

        for(var j = 0, size = cols.length; j < size; j++) {
            var _td = cols[j];
            var col = $("<td>");

            col.text(_td);

            row.append(col);
        }

        tbody.append(row);
    }

    table.append(thead);
    table.append(tbody);

    this.table.push(table);
}

Previewer.prototype.createTableHTML = function() {
    var data = this.data;

    if (data.is_round_trip) {
        this.getGoTrip();
        this.getReturnTrip();
    } else {
        this.getGoTrip();
    }
}

Previewer.prototype.getTable = function() {
    return this.table;
}

Previewer.prototype.getTitle = function(isHome) {
    var data = this.data;
    var moment = this.moment;
    var label = isHome ? 'TAXI_BOOKING_GO' : 'TAXI_BOOKING_RETURN';
    var labelDate = isHome ? 'date_start' : 'date_end';
    var mode = AJAX_ANTOURS.translation[label];

    var dateStart = data[labelDate];
    var dateStart = moment(dateStart).format('dddd DD/MM/YYYY');
    var title = mode + ' - ' + dateStart;

    return title;
}

Previewer.prototype.getAddress = function(isHome) {
    var data = this.data;
    var street = data.street;
    var build_nro = data.build_nro;
    var dpto = data.dpto;
    var city = data.city;
    var address = null;

    if (isHome) {
        address = street + ', #' + build_nro + ', DEPTO. ' + dpto + ', ' + city;
    } else {
        address = AJAX_ANTOURS.translation.TAXI_BOOKING_AIRPORT;
    }

    return address;
}

Previewer.prototype.getServiceName = function() {
    var data = this.data;
    var service = data.service.service_name || "N/A";

    return service;
}

Previewer.prototype.getTime = function(format) {
    var data = this.data;
    var timeGo = data['time_start'] ? this.moment(data['time_start']).format(format) : null;
    var timeReturn = data['time_end'] ? this.moment(data['time_end']).format(format) : null;

    return {
        go: timeGo,
        return: timeReturn
    };
}

Previewer.prototype.calculatePrice = function() {
    var data = this.data;
    var passengers = data.passengers;
    var price = data.service.price;
    var total = 0;
    
    if (price) {
        price = parseFloat(price, 2);
        total = (passengers * price);
        total = this.isFloat(total) ? total.toFixed(3) : total;
    }


    return total;
}

Previewer.prototype.getPassengers = function() {
    var data = this.data;
    var passengers = data.passengers;

    return passengers;
}
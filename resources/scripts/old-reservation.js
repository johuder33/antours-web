// (function(window, $){
//     var spinner = $('<div class="container-loading"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
//     var Reservation = (function(self, $){
//         var globalState = {};
//         var steps = [];
//         var pubsub = self.PubSub;
//         var stepsByNames = [];
//         var currentStepIndex = 0;
//         var currentStep = null;
//         var nextStepKey = '.next-step';
//         var prevStepKey = '.prev-step';
    
//         var defaultEventByFieldTypes = {
//             text: 'keyup',
//             checkbox: 'change',
//             radio: 'change',
//             'select-one': 'change',
//             textarea: 'keyup'
//         };
    
//         var normalizerByFieldType = {
//             radio: _normalizeSelectorValue,
//             checkbox: _normalizeSelectorValue,
//             default: _normalizeDefaultValue
//         };
    
//         function _normalizeDefaultValue(field) {
//             return !field ? null : field.val();
//         };
    
//         function _normalizeSelectorValue(field) {
//             if (!field.length) {
//                 return null;
//             }
            
//             var value = field.is(':checked') ? field.val() : null;
    
//             if (field.length > 1) {
//                 value = _normalizeValueFromMultipleFields(field);
//             }
    
//             return value;
//         }
    
//         function _normalizeFieldName(field) {
//             return field.attr('name') || field.attr('id');
//         }
    
//         pubsub.on('reservation.field.change', function(field, step){
//             step = step || currentStep;
//             var name = _normalizeFieldName(field);
//             var value = _normalizeFieldValue(field);
    
//             globalState[step][name] = value;
//             console.log("globalState", globalState);
//         });
    
//         var notifyChange = function(field, step) {
//             pubsub.emit('reservation.field.change', field, step);
//         }
    
//         var notifyValueChange = function(name, value, step) {
//             step = step || currentStep;
    
//             globalState[step][name] = value;
//         }
    
//         var registerFields = function() {
//             var stepsLimit = steps.length;
//             for(var stepIndex = 0; stepIndex < stepsLimit; stepIndex++) {
//                 var step = steps[stepIndex];
//                 var nameStep = step.name;
//                 var fields = Object.prototype.toString.call(step.fields) === '[object Array]' ? step.fields : [step.fields];
//                 var fieldsLimit = fields.length;
    
//                 for(var fieldIndex = 0; fieldIndex < fieldsLimit; fieldIndex++) {
//                     var field = fields[fieldIndex];
//                     registerField(field, nameStep)
//                 }
//             }
//         }
    
//         var registerSteps = function() {
//             var stepsLimit = steps.length;
//             var defaultStepExist = false;
    
//             for(var stepIndex = 0; stepIndex < stepsLimit; stepIndex++) {
//                 var step = steps[stepIndex];
//                 var stepName = step.name;
    
//                 if (stepName === currentStep) {
//                     defaultStepExist = true;
//                     currentStepIndex = stepIndex;
//                 }
    
//                 stepsByNames.push(stepName);
//             }
    
//             if (!defaultStepExist) {
//                 setDefaultStep(stepsByNames[0]);
//             }
//         }
    
//         var setDefaultStep = function(stepName) {
//             currentStep = stepName;
//         }
    
//         var _normalizeField = function(field) {
//             if (Object.prototype.toString.call(field) === '[object Object]') {
//                 return field;
//             }
    
//             return {
//                 key: field
//             }
//         }
    
//         var _normalizeFieldValue = function(field) {
//             var fieldType = getFieldType(field);
//             var normalizer = normalizerByFieldType[fieldType] || normalizerByFieldType['default'];
    
//             return normalizer(field);
//         }
    
//         var _normalizeValueFromMultipleFields = function(field) {
//             var value = null;
    
//             $.each(field, function(index, currentField){
//                 var _field = $(currentField);
//                 if (!value && _field.is(':checked')) {
//                     value = _field.val();
//                 }
//             });
    
//             return value;
//         }
    
//         var registerField = function(field, nameStep) {
//             field = _normalizeField(field);
//             var fieldKey = field.key;
//             var fieldInstance = $(fieldKey);
//             var listener = field.on;
//             var fieldType = getFieldType(fieldInstance);
//             var value = _normalizeFieldValue(fieldInstance);
//             var name = _normalizeFieldName(fieldInstance);
//             var handler = field.handler || handlerEvent;
//             listener = listener ? listener : getEventByFieldType(fieldType);
    
//             globalState[nameStep][name] = value;
    
//             $('.' + nameStep).on(listener, fieldKey, handler);
//         }
    
//         function handlerEvent() {
//             var currentField = $(this);
//             notifyChange(currentField, currentStep)
//         }
    
//         var getFieldType = function(field) {
//             return field.prop('type');
//         }
    
//         var getEventByFieldType = function(fieldType) {
//             return defaultEventByFieldTypes[fieldType || 'text'];
//         }
    
//         var addStep = function(options,name, fields, onNextStep) {
//             var step = options;
//             // var step = {
//             //     fields: fields,
//             //     nextStep: onNextStep,
//             //     name: name
//             // };
    
//             globalState[step.name] = {};
//             steps.push(step);
//         };
    
//         var registerControls = function() {
//             $(nextStepKey).on('click', _nextStep);
//             $(prevStepKey).on('click', _prevStep);
//         }
    
//         var init = function() {
//             registerSteps();
//             registerControls();
//             registerFields();
//         }
    
//         function getTotalSteps() {
//             return stepsByNames.length - 1;
//         }
    
//         function _nextStep(event) {
//             event.preventDefault();
//             var totalOfSteps = getTotalSteps();
//             var errors = validate();
//             var nextStepIndex = currentStepIndex + 1;
    
//             if (errors && errors.length > 0) {
//                 return;
//             }

//             if (nextStepIndex && (steps.length - 1 >= nextStepIndex)) {
//                 var stepName = steps[nextStepIndex];
//                 var _step = findStepByName(stepName);

//                 if (_step && _step.onNext) {
//                     if(!_step.onNext()) {
//                         return;
//                     }
//                 }
//             }
    
//             if (currentStepIndex < totalOfSteps) {
//                 currentStepIndex++;
//                 var lastStep = currentStep;
//                 currentStep = stepsByNames[currentStepIndex];
//                 setCurrentToNextStep(lastStep, currentStep);
//                 var step = steps[currentStepIndex];

//                 if (step && typeof step.onEnter === 'function') {
//                     step.onEnter(globalState);
//                 }
//             }
//         }
    
//         function _prevStep(event) {
//             event.preventDefault();
//             var totalOfSteps = getTotalSteps();
    
//             if (currentStepIndex > 0) {
//                 currentStepIndex--;
//                 var lastStep = currentStep;
//                 currentStep = stepsByNames[currentStepIndex];
//                 setCurrentToNextStep(lastStep, currentStep);
//             }
//         }
    
//         function _isRequired(field) {
//             if (_fieldExists(field)) {
//                 var isRequired = field.data('required') || field.attr('required');
    
//                 if (isRequired) {
//                     return true;
//                 }
//             }
    
//             return false;
//         }
    
//         function _fieldExists(field) {
//             return field && field.length > 0;
//         }
    
//         function _isEmpty(field) {
//             if (_fieldExists(field)) {
//                 var value = _normalizeDefaultValue(field);
    
//                 if (value && (typeof value === 'string') && $.trim(value).length > 0) {
//                     return false;
//                 }
    
//                 return true;
//             }
    
//             return false;
//         }
    
//         function validate() {
//             var currentStepFields = findStepByName(currentStep);
//             var fields = currentStepFields.fields;
//             var errors = [];
//             var fieldLimit = fields.length;
    
//             for(var i = 0; i < fieldLimit; i++) {
//                 var fieldName = fields[i];
//                 var field = $(fieldName);
    
//                 if (_isRequired(field)) {
//                     if (_isEmpty(field)) {
//                         errors.push(fieldName + ' is required.');
//                     }
//                 }
//             }
    
//             return errors;
//         }
    
//         function setCurrentToNextStep(lastStep, nextStep) {
//             $('.' + lastStep).removeClass('current');
//             $('.' + nextStep).addClass('current');
//         }

//         function getValue(step, key) {
//             var state = globalState[step];

//             if (state) {
//                 if (state.hasOwnProperty(key)) {
//                     return state[key];
//                 }
//             }

//             return false;
//         }
    
//         function findStepByName(stepName) {
//             var limit = steps.length;
//             var _step = false;
//             for(var index = 0; index < limit; index++) {
//                 var _currentState = steps[index];
    
//                 if (_currentState && _currentState.name === stepName) {
//                     _step = _currentState;
//                     break;
//                 }
//             }
    
//             return _step;
//         }

//         function getGlobalState() {
//             return globalState;
//         }
    
//         return {
//             addStep: addStep,
//             setDefaultStep: setDefaultStep,
//             notifyChange: notifyChange,
//             notifyValueChange: notifyValueChange,
//             getValue: getValue,
//             getGlobalState: getGlobalState,
//             init: init
//         }
//     })(window, $);

//     Date.prototype.resetHours = function() {
//         this.setHours(0, 0, 0, 0);
//     }

//     Date.prototype.addHours = function(hours) {
//         if (!hours) return;
//         var hoursAdded = (Math.abs(hours) * 60 * 60 * 1000);
//         this.setTime(this.getTime() + hoursAdded);
//         return this;
//     }

//     Reservation.addStep({
//         name: 'firstStep',
//         fields: ['#street', '#build_nro', '.roundtrip', '.startfrom', '#getCities', '#passengers', '#getCommuneByCityId', '#dpto']
//     });

//     Reservation.addStep({
//         name: 'secondStep',
//         fields: [{ key: '#date_start', handler: notEvent, on: 'keydown' }, { key: '#time_start', handler: notEvent, on: 'keydown' }, { key: '#date_end', handler: notEvent, on: 'keydown' }, { key: '#time_end', handler: notEvent, on: 'keydown' }]
//     });

//     Reservation.addStep({
//         name: 'thirdStep',
//         fields: [
//             {
//                 key: '.service-radio',
//                 on: 'change'
//             }
//         ],
//         onEnter: getServicesByCommune
//     });

//     Reservation.init();

//     function onNextStep() {
//         console.log("vamos loco");
//         return false;
//     }

//     function getServicesByCommune(state) {
//         var communeId = state['firstStep']['getCommuneByCityId'];

//         var body = {
//             action: AJAX_ANTOURS.transbooking.services.action,
//             nonce: AJAX_ANTOURS.nonce,
//             communeId: communeId
//         };

//         var servicesContainer = $('.services_container');

//         $.ajax({
//             url: AJAX_ANTOURS.server_url,
//             type: 'post',
//             data: body,
//             success: function(data){
//                 var services = data.data;

//                 if (services && services.length > 0) {
//                     var table = new TableServices([
//                         {
//                             content: $('<i class="fa fa-car" aria-hidden="true"></i>')
//                         },
//                         {
//                             content: AJAX_ANTOURS.translation.TAXI_BOOKING_PRICE
//                         },
//                         {
//                             content: AJAX_ANTOURS.translation.TAXI_BOOKING_SERVICE_NAME
//                         },
//                         {
//                             content: AJAX_ANTOURS.translation.TAXI_BOOKING_SERVICE_DESC
//                         }
//                     ], $);

//                     table.buildRowsData(services);
//                     table.buildTable();

//                     var servicesTable = table.getTable();

//                     servicesContainer.html(servicesTable);
//                     var service = services[0];
//                     var serviceId = service ? service.id_single_service : null;
//                     Reservation.notifyValueChange('service_id', serviceId);
//                     Reservation.notifyValueChange('service', service);
//                 }
//             },
//             error: function(error){
//                 var response = error.responseJSON;

//                 if (!response.success) {
//                     servicesContainer.html(response.data);
//                 }
//             },
//             beforeSend: function() {
//                 if (servicesContainer && servicesContainer.length > 0) {
//                     servicesContainer.html(spinner);
//                 }
//             }
//         });

//         return true;
//     }

//     var dateStart = $("#date_start");
//     var timeStart = $("#time_start");
//     var dateEnd = $("#date_end");
//     var timeEnd = $("#time_end");
//     var currentLang = AJAX_ANTOURS.language || 'en';

//     var currentDate = new Date();
//     var currentTime = new Date();
    
//     // reset the time for current date
//     currentDate.resetHours();
//     // Add 2 more hours for current time
//     currentTime.addHours(2)

//     var timePickerOptions = {
//         'minTime': "00:00",
//         'disableTimeRanges': [["00:00", currentTime]],
//         'timeFormat': 'H:i',
//         'step': 10,
//         'forceRoundTime': true
//     };

//     var dateConfig = {
//         "pt": {
//             startDate: currentDate,
//             format: 'dd/mm/yyyy',
//             days: ["Domingo", "Segunda-feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"],
//             daysShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
//             daysMin: ['D','S','T','Q','Q','S','S'],
//             monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Sep", "Out", "Nov", "Dez"]
//         },
//         "es": {
//             startDate: currentDate,
//             format: 'dd/mm/yyyy',
//             days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
//             daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
//             daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
//             monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
//         },
//         "en": {
//             startDate: currentDate,
//             format: 'dd/mm/yyyy',
//         }
//     }

//     var currentConfig = dateConfig[currentLang];
//     var dateStartPicker = dateStart.datepicker(currentConfig);
//     var timeStartPicker = timeStart.timepicker(timePickerOptions);
//     var dateEndPicker = dateEnd.datepicker(currentConfig);
//     var timeEndPicker = timeEnd.timepicker({ 'timeFormat': 'H:i' });

//     dateStartPicker.on('pick.datepicker', function(event){
//         // let's hide the picker calendar
//         dateStartPicker.datepicker("hide");

//         var dateStartName = dateStartPicker.attr('name');
//         var timeStartName = timeStartPicker.attr('name');
//         var datePicked = event.date;

//         // update the date_start value into global object
//         Reservation.notifyValueChange(dateStartName, datePicked, 'secondStep');

//         // reset time_start
//         Reservation.notifyValueChange(timeStartName, null, 'secondStep');

//         var nextTimeRange = datePicked.getTime() > currentDate.getTime() ? new Date() : [["00:00", currentTime]];

//         timePickerOptions.disableTimeRanges = nextTimeRange;

//         timeStartPicker.timepicker("option", timePickerOptions);

//         if (dateEndPicker && $.trim(dateEndPicker.val()).length > 0) {
//             var dateEndPicked = dateEndPicker.datepicker('getDate');
//             if (dateEndPicked.getTime() < datePicked.getTime()) {
//                 dateEndPicker.datepicker('reset');
//                 var dateEndPickedName = dateEndPicker.attr('name');
//                 Reservation.notifyValueChange(dateEndPickedName, null, 'secondStep');
//             }
//         }

//         // set current date for return date
//         dateEndPicker.datepicker('setDate', event.date, true);
//         dateEndPicker.datepicker('setStartDate', event.date);
//     });

//     dateEndPicker.on('pick.datepicker', function(event){
//         dateEndPicker.datepicker("hide");
//         var dateEndName = dateEndPicker.attr('name');
//         var dateEndValue = event.date;
//         Reservation.notifyValueChange(dateEndName, dateEndValue, 'secondStep');

//         // if both dateStart and dateEnd are filled
//         if (dateStartPicker.val().length > 0) {
//             var dateStartValue = dateStartPicker.datepicker('getDate');
//             if (dateEndValue.getTime() === dateStartValue.getTime()) {
//                 if (timeStartPicker.val().length > 0 && timeEndPicker.val().length > 0) {
//                     var timeStartValue = timeStartPicker.timepicker('getTime');
//                     var timeEndValue = timeEndPicker.timepicker('getTime');
//                     if (timeEndValue < timeStartValue) {
//                         var timeEndName = timeEndPicker.attr('name');
//                         timeEndPicker.val('');
//                         Reservation.notifyValueChange(timeEndName, null, 'secondStep');
//                     }
//                 }
//             }
//         }
//     });

//     timeStartPicker.on('changeTime', function(event){
//         var timeStartName = timeStartPicker.attr('name');
//         var timeStartValue = timeStartPicker.timepicker('getTime');
//         Reservation.notifyValueChange(timeStartName, timeStartValue, 'secondStep');
//     });

//     timeEndPicker.on('changeTime', function(event){
//         var timeEndName = timeEndPicker.attr('name');
//         var timeEndValue = timeEndPicker.timepicker('getTime');
//         Reservation.notifyValueChange(timeEndName, timeEndValue, 'secondStep');
//     });

//     function notEvent(e) {
//         return false;
//     }
// })(window, jQuery);
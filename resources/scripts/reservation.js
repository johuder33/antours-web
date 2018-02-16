var MSStepForm = (function($){
    var state = {};
    var steps = [];
    var currentStep = 0;
    var form = null;
    var options = {};
    var errors = [];
    var errorTemplates = {
      _error: '%fn is required, please check the field'
    };
    var fieldTypes = {
      text: 'text',
      select: 'select-one',
      textarea: 'textarea',
      radio: 'radio',
      checkbox: 'checkbox',
      number: 'number',
      email: 'email'
    };
    var defaults = {
      initialState: {},
      currentStep: currentStep,
      steps: [],
      formKey: '.msForm',
      stepKey: '.msStep',
      fieldKey: '.msField',
      currentStepKey: '.current',
      nextButtonKey: '.next',
      prevButtonKey: '.prev'
    };
  
    function cleanErrors() {
      errors = [];
    }
  
    function addError(error) {
      errors.push(error);
    }
  
    function MSOnSubmit(e) {
      _onSubmit(event, state);
    }
    
    function _onSubmit(event, state) {
      console.log("Your state", state);
    }
  
    function getValue(field) {
      return field.val() || getAttrFromField(field, 'value');
    }
  
    function getValueFromField(field) {
      var type = getAttrFromField(field, 'type');
      var value = getValue(field);
      var willTrim = getAttrFromField(field, 'trim');
  
      if (type === fieldTypes.checkbox || type === fieldTypes.radio) {
        value = getAttrFromField(field, 'checked');
      }
  
      if (willTrim) {
        value = $.trim(willTrim);
      }
  
      return value;
    }
  
    function normalizePropName(propName) {
      return this.prop(propName) && typeof this.prop(propName) === 'string' && this.prop(propName).toLowerCase || false;
    }
  
    function getAttrFromField(field, attrName) {
      return field.attr(attrName) || field.data(attrName) || normalizePropName.call(field, attrName);
    }
  
    function getMetadataFromField(field) {
      var required = getAttrFromField(field, 'required');
      var type = getAttrFromField(field, 'type');
      var tagName = getAttrFromField(field, 'tagName');
      var name = getAttrFromField(field, 'name') || type || tagName;
      var value = getValueFromField(field) || null;
      
      return {
        required: required,
        type: type,
        name: name,
        value: value,
        field: field
      };
    }
  
    function willValidate() {
      var fields = form.find(options.currentStepKey + ' ' + options.fieldKey);
  
      if (fields.length > 0) {
        fields.each(function(){
          var field = $(this);
          var metadata = getMetadataFromField(field);
          fillState(metadata);
          if (metadata.required) {
            validate(metadata);
          }
        });
      }
    }
  
    function validate(metadata) {
      var value = metadata.value;
      var name = metadata.name;

      if (!value || value.length === 0) {
          var msg = name + ' is required';
          addError(msg);
      }
    }

    function fillState(metadata) {
        var value = metadata.value;
        var name = metadata.name;

        state[name] = value;
    }
  
    function navToNextStep(nextStep) {
      var current = currentStep;
      var _steps = steps;
      var nextIndex = current + nextStep;

      cleanErrors();
      if (nextIndex >= 0 && nextIndex < _steps.length) {
        willValidate();
        if (!hasErrors()) {
          goTo(nextIndex);
        }
      }

      if (nextIndex === _steps.length) {
        willValidate();
        if (!hasErrors()) {
          form.submit();
        }
      }
    }
  
    function goTo(index) {
      currentStep = index;
  
      form.find(options.stepKey).removeClass(cleanKey(options.currentStepKey)).eq(currentStep).addClass(cleanKey(options.currentStepKey));
    }
  
    function hasErrors() {
      return errors.length > 0;
    }
  
    function setupSteps() {
      var Steps = form.find(options.stepKey);
  
      if (Steps.length > 0) {
        Steps.eq(options.currentStep).addClass(cleanKey(options.currentStepKey));
        steps = Steps;
      }
    }
  
    function setupListeners() {
      $(options.formKey).on('click', options.nextButtonKey, function(event){
          event.preventDefault();
          var nextStep = +1;
          navToNextStep(nextStep);
          console.log("next",state);
      });

      $(options.formKey).on('click', options.prevButtonKey, function(event) {
        event.preventDefault();
        var prevStep = -1;
        navToNextStep(prevStep);
        console.log("prev",state);
      });
    }
  
    function cleanKey(key) {
      return key.replace(/\.|\#/, '');
    }
  
    function MSStepForm(_options) {
      options = _options || {};
      options = $.extend({}, defaults, options);
  
      var formKey = options.formKey;
      form = $(formKey).first();
  
      if (form.length === 0) {
        throw new Error('A form element is needed your ' + formKey + ' is not assigned to an HTML element.');
      }
  
      setupSteps();
      setupListeners();
    }
  
    return MSStepForm;
  })(jQuery);

  new MSStepForm({
      currentStepKey: '.active',
      stepKey: '.mystep',
      formKey: '.myform',
      fieldKey: '.myfield'
  });
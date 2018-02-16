<?php

global $translation;

/**
 * Helper function to basic fields on each ajax endpoint request
 */
function checkFields($fields, $required) {
    foreach($fields as $fieldName => $value) {
        if (in_array($fieldName, $required)) {
            if(!isset($value)) {
                // ERROR: AJAX_ERROR_FIELD_NOT_DEFINED
                throw new Exception($translation['AJAX_ERROR_FIELD_NOT_DEFINED'] || "{$fieldName} field is missing");
            }

            $val = is_string($value) ? trim($value) : $value;

            if (empty($val) || $val === '') {
                // ERROR: AJAX_ERROR_FIELD_NOT_DEFINED
                throw new Exception($translation['AJAX_ERROR_FIELD_NOT_DEFINED'] || "{$fieldName} field cannot be empty");
            }
        }
    }
}

/**
 * Check if current value if the specified type
 */
function checkType($value, $type) {
    return filter_var($value, $type);
}

/**
 * Check for each field be the specified type
 */
function checkTypeFields($fields, $rules) {
    foreach($fields as $fieldName => $value) {
        if (isset($rules[$fieldName])) {
            $isFunction = $rules[$fieldName]['is_function'];
            $validator = $rules[$fieldName]['validator'];
            $validation = null;

            if ($isFunction) {
                $validation = call_user_func_array($validator, $value);
            } else {
                $validation = checkType($value, $validator);
            }

            if(!$validation) {
                throw new Exception("{$fieldName} field is invalid.");
            }
        }
    }
}

/**
 * Helper function to create common attributes for mailing
 */
function makeCommonAttributes() {
    global $translation;

    $telephones = AntoursContactPage::getTelephones();

    $telephones = implode('<br>', $telephones);

    $attributes = array(
        'slogan' => $translation['SLOGAN_MAIL_CONTACT'],
        'logo_url' => get_stylesheet_directory_uri() . 'resources/images/antours-logo.png',
        'phones' => $telephones,
        'year' => date('Y')
    );

    return $attributes;
}

/**
 * Helper function to create attributes for admin mailing
 */
function makeAdminAttributes() {
    global $translation;

    $attributes = makeCommonAttributes();

    return $attributes;
}

/**
 * Helper function to create attributes for customer mailing
 */
function makeCustomerAttributes() {
    global $translation;

    $commons = makeCommonAttributes();
    $attributes = array(
        'twitter_url' => AntoursContactPage::getOptionOf(AntoursContactPage::$twitterFieldName),
        'instagram_url' => AntoursContactPage::getOptionOf(AntoursContactPage::$instagramFieldName),
        'facebook_url' => AntoursContactPage::getOptionOf(AntoursContactPage::$fbFieldName),
    );

    $attributes = array_merge($commons, $attributes);

    return $attributes;
}

/**
 * Make translation with params, this for get and parse every translation text
 */
function makeTranslationWithParams($key, $params = array()) {
    global $translation;
    $stringToTranslate = $translation[$key];
    $toReplace = array_keys($params);
    $values = array_values($params);

    if (!empty($stringToTranslate) && !is_null($stringToTranslate)) {
        $word = str_replace($toReplace, $values, $stringToTranslate);
        return $word;
    }

    return $key;
}
<?php

global $domain, $translation;

function ___($label, $domain) {
    return $label;
}

$translation = array(
    // TAXI BOOKING FORM
    'TAXI_BOOKING_CHOOSE_CITY' => __('Taxi_booking_choose_city_label', $domain),
    'TAXI_BOOKING_CHOOSE_COMMUNE' => __('Taxi_booking_choose_commune_label', $domain),
    'TAXI_BOOKING_ORIGIN' => __('Taxi_booking_origin_label', $domain),
    'TAXI_BOOKING_PICK_CITY' => __('Taxi_booking_pick_city_label', $domain),
    'TAXI_BOOKING_START_FROM' => __('Taxi_booking_start_from_label', $domain),
    'TAXI_BOOKING_TRIP_TWO_WAY' => __('Taxi_booking_trip_two_way_label', $domain),
    'TAXI_BOOKING_TRIP_ONE_WAY' => __('Taxi_booking_trip_one_way_label', $domain),
    'TAXI_BOOKING_DESTINY' => __('Taxi_booking_destiny_label', $domain),
    'TAXI_BOOKING_SERVICE_LABEL' => __('Taxi_booking_service_label', $domain),
    'TAXI_BOOKING_SERVICE_NAME' => __('Taxi_booking_service_name_label', $domain),
    'TAXI_BOOKING_SERVICE_DESC' => __('Taxi_booking_service_desc_label', $domain),
    'TAXI_BOOKING_PASSENGERS' => __('Taxi_booking_passengers_label', $domain),
    'TAXI_BOOKING_PRICE' => __('Taxi_booking_price_label', $domain),
    'TAXI_BOOKING_GO' => __('Taxi_booking_go_label', $domain),
    'TAXI_BOOKING_RETURN' => __('Taxi_booking_return_label', $domain),
    'TAXI_BOOKING_DATE_START' => __('Taxi_booking_date_go_label', $domain),
    'TAXI_BOOKING_DATE_RETURN' => __('Taxi_booking_date_return_label', $domain),
    'TAXI_BOOKING_TIME_GO' => __('Taxi_booking_time_go_label', $domain),
    'TAXI_BOOKING_TIME_RETURN' => __('Taxi_booking_time_return_label', $domain),
    'TAXI_BOOKING_AIRPORT' => __('Taxi_booking_airport_label', $domain),
    'TAXI_BOOKING_HOME' => __('Taxi_booking_home_label', $domain),
    'TAXI_BOOKING_STREET' => __('Taxi_booking_street_label', $domain),
    'TAXI_BOOKING_BUILDING' => __('Taxi_booking_building_label', $domain),
    'TAXI_BOOKING_DEPTO' => __('Taxi_booking_depto_label', $domain),
    'TAXI_BOOKING_REFERENCE' => __('Taxi_booking_reference_label', $domain),
    'TAXI_BOOKING_PASSENGER_PHONE' => __('Taxi_booking_passenger_phone_label', $domain),
    'TAXI_BOOKING_PASSENGER_EMAIL' => __('Taxi_booking_passenger_email_label', $domain),
    'TAXI_BOOKING_PASSENGER_FULLNAME' => __('Taxi_booking_passenger_fullname_label', $domain),
    'TAXI_BOOKING_PASSENGER_RUT' => __('Taxi_booking_passenger_rut_label', $domain),
    'TAXI_BOOKING_PASSENGER_PASSPORT' => __('Taxi_booking_passenger_passport_label', $domain),
    'TAXI_BOOKING_NEXT_BUTTON' => __('Taxi_booking_next_button_label', $domain),
    'TAXI_BOOKING_PREV_BUTTON' => __('Taxi_booking_prev_button_label', $domain),
    'TAXI_BOOKING_SUBMIT_BUTTON' => __('Taxi_booking_submit_button_label', $domain),
    // COMMENTS
    'COMMENT_BTN_LOADING' => __('Comment_btn_loading_label', $domain),
    'COMMENT_BTN_LOAD' => __('Comment_btn_load_label', $domain),
    // CONTACT FORM
    'CONTACT_BTN_LOADING' => __('Contact_btn_loading_label', $domain),
    'CONTACT_BTN_LOAD' => __('Contact_btn_load_label', $domain),
    'CONTACT_FORM_FIELD_NAME' => __('Contact_form_field_name', $domain),
    'CONTACT_FORM_FIELD_LASTNAME' => __('Contact_form_field_lastname', $domain),
    'CONTACT_FORM_FIELD_EMAIL' => __('Contact_form_field_email', $domain),
    'CONTACT_FORM_FIELD_SUBJECT' => __('Contact_form_field_subject', $domain),
    'CONTACT_FORM_FIELD_MESSAGE' => __('Contact_form_field_message', $domain),
    'CONTACT_BTN_SENT' => __('Contact_btn_sent', $domain),
    'CONTACT_BTN_NOT_SENT' => __('Contact_btn_not_sent', $domain),
    'CONTACT_FORM_FIELD_NAME_ERROR' => __('Contact_form_field_name_error', $domain),
    'CONTACT_FORM_FIELD_LASTNAME_ERROR' => __('Contact_form_field_lastname_error', $domain),
    'CONTACT_FORM_FIELD_EMAIL_ERROR' => __('Contact_form_field_email_error', $domain),
    'CONTACT_FORM_FIELD_SUBJECT_ERROR' => __('Contact_form_field_subject_error', $domain),
    'CONTACT_FORM_FIELD_MESSAGE_ERROR' => __('Contact_form_field_message_error', $domain),
    // Quick fields
    'QUICK_FIELD_FULLNAME_PLACEHOLDER' => __('Quickfield_input_fullname', $domain),
    'QUICK_FIELD_FULLNAME_ERROR_MESSAGE' => __('Quickfield_input_fullname_error', $domain),
    'QUICK_FIELD_ID_NUMBER_PLACEHOLDER' => __('Quickfield_input_id_number', $domain),
    'QUICK_FIELD_ID_NUMBER_ERROR_MESSAGE' => __('Quickfield_input_id_number_error', $domain),
    'QUICK_FIELD_PHONE_PLACEHOLDER' => __('Quickfield_input_phone', $domain),
    'QUICK_FIELD_PHONE_ERROR_MESSAGE' => __('Quickfield_input_phone_error', $domain),
    'QUICK_FIELD_EMAIL_PLACEHOLDER' => __('Quickfield_input_email', $domain),
    'QUICK_FIELD_EMAIL_ERROR_MESSAGE' => __('Quickfield_input_email_error', $domain),
    'QUICK_FIELD_PASSENGERS_PLACEHOLDER' => __('Quickfield_input_passengers', $domain),
    'QUICK_FIELD_PASSENGERS_ERROR_MESSAGE' => __('Quickfield_input_passengers_error', $domain),
    'QUICK_FIELD_HOTEL_ADDRESS_PLACEHOLDER' => __('Quickfield_input_hotel_address', $domain),
    'QUICK_FIELD_HOTEL_ADDRESS_ERROR_MESSAGE' => __('Quickfield_input_hotel_address_error', $domain),
    // Custom Post Types
    // Services
    'CPT_SERVICE_NAME_MENU_LABEL' => __('Cpt_service_menu_label', $domain),
    'CPT_SERVICE_SINGULAR_MENU_LABEL' => __('Cpt_service_singular_menu_label', $domain),
    'CPT_SERVICE_ADD_NEW_MENU_LABEL' => __('Cpt_service_add_new_menu_label', $domain),
    'CPT_SERVICE_NOT_FOUND_MENU_LABEL' => __('Cpt_service_not_found_menu_label', $domain),
    'CPT_SERVICE_ALL_ITEMS_MENU_LABEL' => __('Cpt_service_all_items_menu_label', $domain),
    'CPT_SERVICE_NEW_ITEM_MENU_LABEL' => __('Cpt_service_new_item_menu_label', $domain),
    'CPT_SERVICE_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_service_featured_image_menu_label', $domain),
    'CPT_SERVICE_SET_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_service_set_featured_image_menu_label', $domain),
    'CPT_SERVICE_DESCRIPTION' => __('Cpt_service_description', $domain),
    // Packages
    'CPT_PACKAGE_NAME_MENU_LABEL' => __('Cpt_package_menu_label', $domain),
    'CPT_PACKAGE_SINGULAR_MENU_LABEL' => __('Cpt_package_singular_menu_label', $domain),
    'CPT_PACKAGE_ADD_NEW_MENU_LABEL' => __('Cpt_package_add_new_menu_label', $domain),
    'CPT_PACKAGE_NOT_FOUND_MENU_LABEL' => __('Cpt_package_not_found_menu_label', $domain),
    'CPT_PACKAGE_ALL_ITEMS_MENU_LABEL' => __('Cpt_package_all_items_menu_label', $domain),
    'CPT_PACKAGE_NEW_ITEM_MENU_LABEL' => __('Cpt_package_new_item_menu_label', $domain),
    'CPT_PACKAGE_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_package_featured_image_menu_label', $domain),
    'CPT_PACKAGE_SET_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_package_set_featured_image_menu_label', $domain),
    'CPT_PACKAGE_DESCRIPTION' => __('Cpt_package_description', $domain),
    'CPT_PACKAGE_GALLERY_TITLE' => __('Cpt_package_gallery_title', $domain),
    // About
    'CPT_ABOUT_NAME_MENU_LABEL' => __('Cpt_about_menu_label', $domain),
    'CPT_ABOUT_SINGULAR_MENU_LABEL' => __('Cpt_about_singular_menu_label', $domain),
    'CPT_ABOUT_ADD_NEW_MENU_LABEL' => __('Cpt_about_add_new_menu_label', $domain),
    'CPT_ABOUT_NOT_FOUND_MENU_LABEL' => __('Cpt_about_not_found_menu_label', $domain),
    'CPT_ABOUT_ALL_ITEMS_MENU_LABEL' => __('Cpt_about_all_items_menu_label', $domain),
    'CPT_ABOUT_NEW_ITEM_MENU_LABEL' => __('Cpt_about_new_item_menu_label', $domain),
    'CPT_ABOUT_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_about_featured_image_menu_label', $domain),
    'CPT_ABOUT_SET_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_about_set_featured_image_menu_label', $domain),
    'CPT_ABOUT_DESCRIPTION' => __('Cpt_about_description', $domain),
    // Home
    'CPT_HOME_NAME_MENU_LABEL' => __('Cpt_home_menu_label', $domain),
    'CPT_HOME_SINGULAR_MENU_LABEL' => __('Cpt_home_singular_menu_label', $domain),
    'CPT_HOME_ADD_NEW_MENU_LABEL' => __('Cpt_home_add_new_menu_label', $domain),
    'CPT_HOME_NOT_FOUND_MENU_LABEL' => __('Cpt_home_not_found_menu_label', $domain),
    'CPT_HOME_ALL_ITEMS_MENU_LABEL' => __('Cpt_home_all_items_menu_label', $domain),
    'CPT_HOME_NEW_ITEM_MENU_LABEL' => __('Cpt_home_new_item_menu_label', $domain),
    'CPT_HOME_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_home_featured_image_menu_label', $domain),
    'CPT_HOME_SET_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_home_set_featured_image_menu_label', $domain),
    'CPT_HOME_DESCRIPTION' => __('Cpt_home_description', $domain),
    // Service Content
    'CPT_SERVICE_CONTENT_NAME_MENU_LABEL' => __('Cpt_service_content_menu_label', $domain),
    'CPT_SERVICE_CONTENT_SINGULAR_MENU_LABEL' => __('Cpt_service_content_singular_menu_label', $domain),
    'CPT_SERVICE_CONTENT_ADD_NEW_MENU_LABEL' => __('Cpt_service_content_add_new_menu_label', $domain),
    'CPT_SERVICE_CONTENT_NOT_FOUND_MENU_LABEL' => __('Cpt_service_content_not_found_menu_label', $domain),
    'CPT_SERVICE_CONTENT_ALL_ITEMS_MENU_LABEL' => __('Cpt_service_content_all_items_menu_label', $domain),
    'CPT_SERVICE_CONTENT_NEW_ITEM_MENU_LABEL' => __('Cpt_service_content_new_item_menu_label', $domain),
    'CPT_SERVICE_CONTENT_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_service_content_featured_image_menu_label', $domain),
    'CPT_SERVICE_CONTENT_SET_FEATURED_IMAGE_MENU_LABEL' => __('Cpt_service_content_set_featured_image_menu_label', $domain),
    'CPT_SERVICE_CONTENT_DESCRIPTION' => __('Cpt_service_content_description', $domain),
    // Custom Categories
    'CUSTOM_CATEGORY_NAME' => __('Category_name', $domain),
    // Banners Custom Post Types
    // For Service
    'BANNER_SERVICE_NAME_MENU_LABEL' => __('Banner_service_menu_label', $domain),
    'BANNER_SERVICE_SINGULAR_MENU_LABEL' => __('Banner_service_singular_menu_label', $domain),
    'BANNER_SERVICE_ADD_NEW_MENU_LABEL' => __('Banner_service_add_new_menu_label', $domain),
    'BANNER_SERVICE_NOT_FOUND_MENU_LABEL' => __('Banner_service_not_found_menu_label', $domain),
    'BANNER_SERVICE_ALL_ITEMS_MENU_LABEL' => __('Banner_service_all_items_menu_label', $domain),
    'BANNER_SERVICE_NEW_ITEM_MENU_LABEL' => __('Banner_service_new_item_menu_label', $domain),
    'BANNER_SERVICE_FEATURED_IMAGE_MENU_LABEL' => __('Banner_service_featured_image_menu_label', $domain),
    'BANNER_SERVICE_SET_FEATURED_IMAGE_MENU_LABEL' => __('Banner_service_set_featured_image_menu_label', $domain),
    'BANNER_SERVICE_DESCRIPTION' => __('Banner_service_description', $domain),
    // For About
    'BANNER_ABOUT_NAME_MENU_LABEL' => __('Banner_about_menu_label', $domain),
    'BANNER_ABOUT_SINGULAR_MENU_LABEL' => __('Banner_about_singular_menu_label', $domain),
    'BANNER_ABOUT_ADD_NEW_MENU_LABEL' => __('Banner_about_add_new_menu_label', $domain),
    'BANNER_ABOUT_NOT_FOUND_MENU_LABEL' => __('Banner_about_not_found_menu_label', $domain),
    'BANNER_ABOUT_ALL_ITEMS_MENU_LABEL' => __('Banner_about_all_items_menu_label', $domain),
    'BANNER_ABOUT_NEW_ITEM_MENU_LABEL' => __('Banner_about_new_item_menu_label', $domain),
    'BANNER_ABOUT_FEATURED_IMAGE_MENU_LABEL' => __('Banner_about_featured_image_menu_label', $domain),
    'BANNER_ABOUT_SET_FEATURED_IMAGE_MENU_LABEL' => __('Banner_about_set_featured_image_menu_label', $domain),
    'BANNER_ABOUT_DESCRIPTION' => __('Banner_about_description', $domain),
    // For Home
    'BANNER_HOME_NAME_MENU_LABEL' => __('Banner_home_menu_label', $domain),
    'BANNER_HOME_SINGULAR_MENU_LABEL' => __('Banner_home_singular_menu_label', $domain),
    'BANNER_HOME_ADD_NEW_MENU_LABEL' => __('Banner_home_add_new_menu_label', $domain),
    'BANNER_HOME_NOT_FOUND_MENU_LABEL' => __('Banner_home_not_found_menu_label', $domain),
    'BANNER_HOME_ALL_ITEMS_MENU_LABEL' => __('Banner_home_all_items_menu_label', $domain),
    'BANNER_HOME_NEW_ITEM_MENU_LABEL' => __('Banner_home_new_item_menu_label', $domain),
    'BANNER_HOME_FEATURED_IMAGE_MENU_LABEL' => __('Banner_home_featured_image_menu_label', $domain),
    'BANNER_HOME_SET_FEATURED_IMAGE_MENU_LABEL' => __('Banner_home_set_featured_image_menu_label', $domain),
    'BANNER_HOME_DESCRIPTION' => __('Banner_home_description', $domain),
    // Metaboxes
    'METABOX_TRIP_PRICE_TITLE' => __('Metabox_trip_price_title', $domain),
    'METABOX_TRIP_PRICE' => __('Metabox_trip_price', $domain),
    'METABOX_SCHEDULE_TRIP' => __('Metabox_schedule_trip', $domain),
    'METABOX_TIME_DEPARTURE' => __('Metabox_time_departure', $domain),
    'METABOX_TIME_RETURN' => __('Metabox_time_return', $domain),
    'METABOX_DEPARTURE_PLACE_TITLE' => __('Metabox_departure_place_title', $domain),
    'METABOX_DEPARTURE_PLACE' => __('Metabox_departure_place', $domain),
    'METABOX_DEPARTURE_PLACE_DESCRIPTION' => __('Metabox_departure_place_description', $domain),
    'METABOX_DEPARTURE_PLACE_CLONE_BTN' => __('Metabox_departure_place_clone_btn', $domain),
    'METABOX_TRIP_MAP_TITLE' => __('Metabox_trip_map_title', $domain),
    'METABOX_TRIP_MAP_ROUTE_NAME' => __('Metabox_trip_map_route_name', $domain),
    'METABOX_TRIP_MAP_ENABLED' => __('Metabox_trip_map_enabled', $domain),
    'METABOX_TRIP_MAP' => __('Metabox_trip_map', $domain),
    'METABOX_TRIP_GALLERY_TITLE' => __('Metabox_trip_gallery_title', $domain),
    'METABOX_TRIP_GALLERY_VIDEO_TITLE' => __('Metabox_trip_gallery_video_title', $domain),
    'METABOX_TRIP_GALLERY_VIDEO_URL' => __('Metabox_trip_gallery_video_url', $domain),
    'METABOX_TRIP_GALLERY' => __('Metabox_trip_gallery', $domain),
    // Validations Images Sizes
    'CHECKER_IMAGE_SIZE_ERROR_MESSAGE' => __( 'Checker_image_size_error_message', $domain ), // variables: %width%, %height%, %currentWidth%, %currentHeight%
    'EMAIL_SENDING_ERROR_MESSAGE' => __('Checker_sending_email_error_message', $domain),
    // Page menu
    'CAR_BOOKING_LIST_TITLE' => __('Page_menu_car_booking_page_title', $domain),
    'CAR_BOOKING_LIST_MENU_NAME' => __('Page_menu_car_booking_name', $domain),
    // Reservation
    'CLASS_RESERVATION_UNDEFINED_ERROR_MESSAGE' => __('Class_reservation_undefined_error_message', $domain),
    'RESERVATION_NONCE_UNDEFINED_ERROR_MESSAGE' => __('Reservation_nonce_undefined_error_message', $domain),
    'RESERVATION_NONCE_INCORRECT_ERROR_MESSAGE' => __('Reservation_nonce_incorrect_error_message', $domain),
    'RESERVATION_SOME_FIELDS_MISSING_ERROR_MESSAGE' => __('Reservation_some_fields_missing_error_message', $domain),
    'RESERVATION_CUSTOMER_ID_ERROR_MESSAGE' => __('Reservation_customer_id_error_message', $domain),
    'RESERVATION_PASSENGERS_ERROR_MESSAGE' => __('Reservation_passengers_error_message', $domain),
    'RESERVATION_CUSTOMER_EMAIL_ERROR_MESSAGE' => __('Reservation_customer_email_error_message', $domain),
    'RESERVATION_PACKAGE_ID_ERROR_MESSAGE' => __('Reservation_package_id_error_message', $domain),
    'RESERVATION_PACKAGE_NOT_FOUND_ERROR_MESSAGE' => __('Reservation_package_not_found_error_message', $domain),
    'RESERVATION_FAILS_ERROR_MESSAGE' => __('Reservation_fails_error_message', $domain),
    'RESERVATION_SUBJECT_EMAIL_ADMIN' => __('Reservation_subject_email_admin', $domain),
    'RESERVATION_SUBJECT_EMAIL_CUSTOMER' => __('Reservation_subject_email_customer', $domain),
    'RESERVATION_PACKAGE_TITLE' => __('Reservation_package_title', $domain),
    'RESERVATION_PACKAGE_ADDRESS' => __('Reservation_package_address', $domain),
    'RESERVATION_PACKAGE_DOC_TYPE' => __('Reservation_package_doc_type', $domain),
    'RESERVATION_PACKAGE_ID_NUMBER' => __('Reservation_package_id_number', $domain),
    'RESERVATION_PACKAGE_PRICE' => __('Reservation_package_price', $domain),
    'RESERVATION_PACKAGE_CUSTOMER_MESSAGE' => __('Reservation_package_customer_message', $domain),
    'RESERVATION_CUSTOMER_FULLNAME' => __('Reservation_customer_fullname', $domain),
    'RESERVATION_SLOGAN_MAIL' => __('Reservation_slogan_mail', $domain),
    'RESERVATION_ID' => __('Reservation_id', $domain),
    'RESERVATION_PACKAGE_SUCCESS_TITLE' => __('Reservation_package_success_title', $domain),
    'RESERVATION_PACKAGE_ERROR_TITLE' => __('Reservation_package_error_title', $domain),
    'RESERVATION_PACKAGE_SUCCESS_MESSAGE' => __('Reservation_package_success_message', $domain),
    // Menu items
    'MENU_ITEM_ABOUT_US' => __('Menu_item_about_us', $domain),
    'MENU_ITEM_TOURS' => __('Menu_item_tours', $domain),
    'MENU_ITEM_SERVICES' => __('Menu_item_services', $domain),
    'MENU_ITEM_CONTACT' => __('Menu_item_contact', $domain),
    // Custom Categories Creation
    // English
    'EN_CUSTOM_CATEGORY_TOURS_DESC' => __('Custom_category_english_tours_description', $domain),
    'EN_CUSTOM_CATEGORY_PEOPLE_DESC' => __('Custom_category_english_people_description', $domain),
    'EN_CUSTOM_CATEGORY_COMPANIES_DESC' => __('Custom_category_english_companies_description', $domain),
    'EN_CUSTOM_CATEGORY_PRIVATES_DESC' => __('Custom_category_english_privates_description', $domain),
    'EN_CUSTOM_CATEGORY_TRANSFERS_DESC' => __('Custom_category_english_transfers_description', $domain),
    // Spanish
    'ES_CUSTOM_CATEGORY_PAQUETES_DESC' => __('Custom_category_spanish_paquetes_description', $domain),
    'ES_CUSTOM_CATEGORY_PERSONAS_DESC' => __('Custom_category_spanish_personas_description', $domain),
    'ES_CUSTOM_CATEGORY_COMPANIAS_DESC' => __('Custom_category_spanish_companias_description', $domain),
    'ES_CUSTOM_CATEGORY_PRIVADOS_DESC' => __('Custom_category_spanish_privados_description', $domain),
    'ES_CUSTOM_CATEGORY_TRASLADOS_DESC' => __('Custom_category_spanish_traslados_description', $domain),
    // Portuguese
    'PT_CUSTOM_CATEGORY_PASSEIOS_DESC' => __('Custom_category_portuguese_passeios_description', $domain),
    'PT_CUSTOM_CATEGORY_PESSOAS_DESC' => __('Custom_category_portuguese_pessoas_description', $domain),
    'PT_CUSTOM_CATEGORY_EMPRESAS_DESC' => __('Custom_category_portuguese_empresas_description', $domain),
    'PT_CUSTOM_CATEGORY_EXCLUSIVO_DESC' => __('Custom_category_portuguese_exclusivo_description', $domain),
    'PT_CUSTOM_CATEGORY_TRANSFERENCIAS_DESC' => __('Custom_category_portuguese_transferencias_description', $domain),

    // Mailing data
    'ADMIN_MAIL_SUBJECT_CONTACT' => __('Admin_mail_subject_contact', $domain),
    'CUSTOMER_MAIL_SUBJECT_CONTACT' => __('Customer_mail_subject_contact', $domain),
    'CUSTOMER_MAIL_MESSAGE_CONTACT' => __('Customer_mail_message_contact', $domain),
    'SLOGAN_MAIL_CONTACT' => __('Slogan', $domain),
);

// create POT file with translations

function create_pot_file() {
    global $translation;

    $file = fopen(__DIR__."/antours.pot", "wb");

    foreach($translation as $key => $text) {
        $line = "# {$key}\r\n";
        $line .= "msgid \"{$text}\"\r\n";
        $line .= "msgstr \"\"\r\n\n";
        fwrite($file, $line);
    }

    fclose($file);
}

create_pot_file();
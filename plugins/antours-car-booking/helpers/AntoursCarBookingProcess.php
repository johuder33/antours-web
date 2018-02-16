<?php

add_action( 'admin_post_car_booking_region', 'change_status_region' );

function change_status_region() {
    global $wpdb;

    if (class_exists("Antours_Booking_Manager")) {
        $instance = new Antours_Booking_Manager($wpdb, "domain");
    }

    $referer = $_SERVER['HTTP_REFERER'];

    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( __("You not able to removeRegion", "car-booking") );
    }

    check_admin_referer("car_booking_checker");

    $id_region = $_POST['region'];
    $actived = $_POST['active'];

    $instance->updateRegion($actived, $id_region);

    wp_redirect($referer);
    exit;
}

add_action( 'admin_post_car_booking_province', 'change_status_province');

function change_status_province() {
    global $wpdb;
    $provinceId = $_POST['province'];
    $actived = $_POST['active'];
    $referer = $_SERVER['HTTP_REFERER'];

    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( __("You not able to removeRegion", "car-booking") );
    }

    if (class_exists("Antours_Booking_Manager")) {
        $instance = new Antours_Booking_Manager($wpdb, "domain");
    }

    check_admin_referer("car_booking_checker");

    $instance->updateProvince($actived, $provinceId);

    wp_redirect($referer);
    exit;
}

add_action( 'admin_post_car_booking_commune', 'change_status_commune');

function change_status_commune() {
    global $wpdb;
    $communeId = $_POST['commune'];
    $actived = $_POST['active'];
    $referer = $_SERVER['HTTP_REFERER'];

    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( __("You not able to removeRegion", "car-booking") );
    }

    if (class_exists("Antours_Booking_Manager")) {
        $instance = new Antours_Booking_Manager($wpdb, "domain");
    }

    check_admin_referer("car_booking_checker");

    $instance->updateCommune($actived, $communeId);

    wp_redirect($referer);
    exit;
}

add_action('admin_post_handle_price', 'handle_price');

function handle_price() {
    global $wpdb;
    $priceManager = new Antours_Price_Manager($wpdb);

    $price = $_POST['price'];
    $status = $_POST['status'] ? 1 : 0;
    $error = false;

    if (!isset($price)||empty($price)||!is_numeric($price)){
        $error = true;
    }

    if (!$error) {
        $result = $priceManager->createPrice($price, $status);
    }

    wp_redirect($_SERVER["HTTP_REFERER"]);
}

add_action('admin_post_handle_service', 'handle_service');

function handle_service() {
    global $wpdb;
    $ServiceManager = new Antours_Service_Manager($wpdb);

    $serviceName = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'] ? 1 : 0;
    $error = false;

    if (!isset($serviceName)||empty($serviceName)){
        $error = true;
    }

    if (!$error) {
        $result = $ServiceManager->createService($serviceName, $description, $status);
    }

    wp_redirect($_SERVER["HTTP_REFERER"]);
}

add_action('admin_post_change_status_price', 'change_status_price');

function change_status_price() {
    global $wpdb;
    $PriceManager = new Antours_Price_Manager($wpdb);

    $id_price = $_POST['id_price'] ? intval($_POST['id_price']) : $_POST['id_price'];
    $status = $_POST['status'] ? 1 : 0;

    $result = $PriceManager->updatePrice($id_price, array("actived" => $status));

    wp_redirect($_SERVER["HTTP_REFERER"]);
}

add_action('admin_post_change_status_service', 'change_status_service');

function change_status_service() {
    global $wpdb;
    $ServiceManager = new Antours_Service_Manager($wpdb);

    $id_price = $_POST['id_service'] ? intval($_POST['id_service']) : $_POST['id_service'];
    $status = $_POST['status'] ? 1 : 0;

    $result = $ServiceManager->updateService($id_price, array("actived" => $status));

    wp_redirect($_SERVER["HTTP_REFERER"]);
}

add_action('admin_post_save_car_booking_service', 'save_car_booking_service');

function save_car_booking_service() {
    global $wpdb;
    $region = $_POST['region'];
    $province = $_POST['province'];
    $commune = $_POST['commune'];
    $idService = $_POST['id_service'];
    $idPrice = $_POST['id_price'];

    $carBooking = new Antours_CarBooking_Manager($wpdb);

    $data = array(
        "id_commune" => $commune,
        "id_service" => $idService,
        "id_price" => $idPrice
    );

    $carBooking->createCarService($data);

    wp_redirect($_SERVER["HTTP_REFERER"]);
}

$getProvincesAJAX = "provinces_by_ajax";
$getCommunesAJAX = "commune_by_ajax";

function add_scripts() {
    global $getProvincesAJAX, $getCommunesAJAX;
    wp_enqueue_script('admin_js_bootstrap_hack', plugins_url('/antours-car-booking/sources/js/bootstrap-hack.js'), false, 1.0, false);

    wp_localize_script( 'admin_js_bootstrap_hack', 'car_booking_config', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'actionProvince' => $getProvincesAJAX,
        'actionCommune' => $getCommunesAJAX
    ));
}

add_action( 'wp_ajax_' . $getProvincesAJAX, $getProvincesAJAX );
function provinces_by_ajax() {
    global $wpdb;
    $id = is_numeric($_POST['id']) ? intval($_POST['id']) : false;
    $regions = new Antours_Booking_Manager($wpdb, "domain");
    $province = $regions->getProvincesByRegionID($id, 1);
    wp_send_json_success($province);
    wp_die();
}

add_action( 'wp_ajax_' . $getCommunesAJAX, $getCommunesAJAX );
function commune_by_ajax() {
    global $wpdb;
    $id = is_numeric($_POST['id']) ? intval($_POST['id']) : false;
    $provinces = new Antours_Booking_Manager($wpdb, "domain");
    $communes = $provinces->getCommunesByProvinceID($id, 1);
    wp_send_json_success($communes);
    wp_die();
}
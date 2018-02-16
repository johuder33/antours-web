<?php


function renderCarBookingPage() {
    echo "table translation";
}

function renderRegionsForm() {
    global $wpdb, $regions;
    if (class_exists("Antours_Booking_Manager")) {
        $instance = new Antours_Booking_Manager($wpdb, "domain");
    }
    
    $regions = $instance->getRegions();
    $regionsView = load_template(__DIR__ . "/../views/Regions/RegionForm.php");
}

function renderProvincesForm() {
    global $wpdb, $provinces, $region, $regions;
    $region = $_GET['region'];

    if (class_exists("Antours_Booking_Manager")) {
        $instance = new Antours_Booking_Manager($wpdb, "domain");
    }

    if (!isset($region)) {
        $regions = $instance->getRegions(1);
        $region = $regions[0];
    } else {
        $region = intval($region);
        $regions = $instance->getRegions(1);
        $region = $instance->getRegionById($region);
    }
    
    $provinces = $instance->getProvincesByRegionID(intval($region->id_region));

    if (is_wp_error($provinces)) {
        wp_die("Error");
    }

    $regionsView = load_template(__DIR__ . "/../views/Provinces/ProvinceForm.php");
}

function renderCommunesForm() {
    global $wpdb, $communes, $regions, $provinces;
    $region = $_GET['region'];
    $province = $_GET['province'];


    if (class_exists("Antours_Booking_Manager")) {
        $instance = new Antours_Booking_Manager($wpdb, "domain");
    }

    if (!isset($region)) {
        $regions = $instance->getRegions(1);
        $region = $regions[0];
    } else {
        $region = intval($region);
        $regions = $instance->getRegions(1);
        $region = $instance->getRegionById($region);
    }

    if (!isset($province)) {
        $provinces = $instance->getProvincesByRegionID(intval($region->id_region), 1);
        $province = $provinces[0];
    } else {
        $province = intval($province);
        $provinces = $instance->getProvincesByRegionID(intval($region->id_region), 1);
        $province = $instance->getProvinceById($province);
    }
    
    $communes = $instance->getCommunesByProvinceID(intval($province->id_province));

    if (is_wp_error($communes)) {
        wp_die("Error");
    }

    $regionsView = load_template(__DIR__ . "/../views/Commune/CommuneForm.php");
}

function renderPricesForm() {
    global $wpdb, $prices;
    $pricesInstance = new Antours_Price_Manager($wpdb);

    $prices = $pricesInstance->getPrices();

    $priceView = load_template(__DIR__ . "/../views/Prices/index.php");
}

function renderServicesForm() {
    global $wpdb, $services;
    $serviceInstance = new Antours_Service_Manager($wpdb);

    $services = $serviceInstance->getServices();

    $serviceView = load_template(__DIR__ . "/../views/Service/index.php");
}

function renderCarServicesForm() {
    global $wpdb, $services, $prices, $regions, $car_services;
    $serviceInstance = new Antours_Service_Manager($wpdb);
    $pricesInstance = new Antours_Price_Manager($wpdb);
    $regionsInstance = new Antours_Booking_Manager($wpdb, "domain");
    $carBookingInstance = new Antours_CarBooking_Manager($wpdb);

    $prices = $pricesInstance->getPrices(1);
    $services = $serviceInstance->getServices(1);
    $regions = $regionsInstance->getRegions(1);
    $car_services = $carBookingInstance->getCarServices();



    $carServiceView = load_template(__DIR__ . "/../views/CarService/index.php");
}
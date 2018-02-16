<?php

function addMenuCarBooking() {
    add_menu_page(
        __("Car Booking Page", "antours"),
        __("Car Booking Menu", "antours"),
        'manage_options',
        'car-booking',
        'renderCarBookingPage',
        'dashicons-tickets-alt',
        30
    );

    add_submenu_page(
        "car-booking",
        __("Car Booking Regions", "antours"),
        __("Car Booking Regions Page", "antours"),
        "manage_options",
        "region_view",
        "renderRegionsForm"
    );

    add_submenu_page(
        "car-booking",
        __("Car Booking Provinces", "antours"),
        __("Car Booking Provinces Page", "antours"),
        "manage_options",
        "province_view",
        "renderProvincesForm"
    );

    add_submenu_page(
        "car-booking",
        __("Car Booking Communes", "antours"),
        __("Car Booking Communes Page", "antours"),
        "manage_options",
        "communes_view",
        "renderCommunesForm"
    );

    add_submenu_page(
        "car-booking",
        __("Car Booking Prices", "antours"),
        __("Car Booking Prices Page", "antours"),
        "manage_options",
        "prices_view",
        "renderPricesForm"
    );

    add_submenu_page(
        "car-booking",
        __("Car Booking Services", "antours"),
        __("Car Booking Services Page", "antours"),
        "manage_options",
        "services_view",
        "renderServicesForm"
    );

    add_submenu_page(
        "car-booking",
        __("Car Booking Car Services", "antours"),
        __("Car Booking Car Services Page", "antours"),
        "manage_options",
        "car_services_view",
        "renderCarServicesForm"
    );
}
<?php

function add_menu_reservation() {
    add_menu_page(
        __("Reservation Page", "antours"),
        __("Reservation", "antours"),
        "manage_options",
        "reservation",
        "renderReservationPage",
        "dashicons-calendar-alt",
        35
    );

    add_submenu_page(
        null,
        __("Reservation Edit Page Item", "antours"),
        __("Reservation Edit Page Item single", "antours"),
        "manage_options",
        "reservation_view",
        "renderReservationEdit"
    );
}
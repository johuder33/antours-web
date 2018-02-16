<?php

function renderReservationPage($data) {
    global $wpdb;
    $title = __("Reservation_title_table", "domain");
    if (class_exists("Reservation_Booking")) {
        $instance = new Reservation_Booking($wpdb);
    }
    $tableList = new Reservation_List_Table($instance, $title);
    $tableList->prepare_items();
    $tableList->renderTable();
}

function renderReservationEdit() {
    global $wpdb, $reservation, $package;
    if (class_exists("Reservation_Booking")) {
        $instance = new Reservation_Booking($wpdb);
    }

    $id = $_GET['reservation'];

    if (!isset($id)) {
        wp_die("Error");
    }

    $reservation = $instance->getByReservationId($id);

    if (!$reservation) {
        return;
    }

    $package = get_post($reservation->id_package);

    $reservation_view_detail = load_template(__DIR__ . "/../views/reservation_view_detail.php");
}
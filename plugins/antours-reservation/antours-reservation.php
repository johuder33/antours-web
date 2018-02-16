<?php
/**
 * The antours plugin for admin pages
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also defines a function that starts the plugin.
 *
 * @link              http://code.tutsplus.com/tutorials/creating-custom-admin-pages-in-wordpress-1
 * @since             1.0.0
 * @package           Antours_admin
 *
 * @wordpress-plugin
 * Plugin Name:       Antours Reservation
 * Plugin URI:        https://github.com/johuder33/antours.git
 * Description:       This plugin will handle the reservation for packaging.
 * Version:           1.0.0
 * Author:            Juorder Gonzalez
 * Author URI:        https://github.com/johuder33/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

 class ReservationBookingSchemas {
    private $db = null;
    private $prefix = "antours_";

    function __construct($DBManager) {
        $this->db = $DBManager;
    }

    public function install() {
        $db = $this->db;
        $prefix = $db->prefix;
        $charset_collate = $db->collate;

        //import dbDelta
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        // reservation schema
        require_once(__DIR__ . '/schema/reservation_schema.php');
        $reservationSQL = create_reservation_schema($prefix, $this->prefix, $charset_collate, 'reservation');
        $reservationSchema = $reservationSQL['schema'];

        // create region schema
        dbDelta($reservationSchema);
    }
}

global $wpdb, $instance;

$ReservationBooking = new ReservationBookingSchemas($wpdb);
require_once(__DIR__ . '/class/Reservation_Booking.php');
require_once(__DIR__ . '/helpers/MenuAdmin.inc.php');
require_once(__DIR__ . '/helpers/RenderAdminView.inc.php');
require_once(__DIR__ . '/class/Reservation_List_Table.php');

add_action("admin_menu", "add_menu_reservation");

register_activation_hook(__FILE__, array($ReservationBooking, 'install'));
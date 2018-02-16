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
 * Plugin Name:       Antours Car Booking
 * Plugin URI:        https://github.com/johuder33/antours.git
 * Description:       This plugin will handle the car booking process.
 * Version:           1.0.0
 * Author:            Juorder Gonzalez
 * Author URI:        https://github.com/johuder33/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

class CarBookingSchemas {
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

        // import region schema
        require_once(__DIR__ . '/schema/regions_schema.php');
        $regionSQL = create_region_schema($prefix, $this->prefix, $charset_collate, 'region');
        $regionSchema = $regionSQL['schema'];
        $regionDataArray = $regionSQL['data'];
        $regionTableName = $regionSQL['tablename'];

        // create region schema
        dbDelta($regionSchema);
        // fill data into region table
        foreach($regionDataArray as $row) {
            $db->insert($regionTableName, $row);
        }

        // import province schema
        require_once(__DIR__ . '/schema/province_schema.php');
        $provinceSQL = create_province_schema($prefix, $this->prefix, $charset_collate, 'province');
        $provinceSchema = $provinceSQL['schema'];
        $provinceDataArray = $provinceSQL['data'];
        $provinceTableName = $provinceSQL['tablename'];

        // create province schema
        dbDelta($provinceSchema);
        // fill data into privince table
        foreach($provinceDataArray as $row) {
            $db->insert($provinceTableName, $row);
        }

        // import commune schema
        require_once(__DIR__ . '/schema/commune_schema.php');
        $communeSQL = create_commune_schema($prefix, $this->prefix, $charset_collate, 'commune');
        $communeSchema = $communeSQL['schema'];
        $communeDataArray = $communeSQL['data'];
        $communeTableName = $communeSQL['tablename'];

        // create commune schema
        dbDelta($communeSchema);
        // fill data into commune table
        foreach($communeDataArray as $row) {
            $db->insert($communeTableName, $row);
        }

        //import schemas for service, service by commune, price and orders
        require_once(__DIR__ . '/schema/car_service_schema.php');
        require_once(__DIR__ . '/schema/service_per_commune_schema.php');
        require_once(__DIR__ . '/schema/price_schema.php');
        require_once(__DIR__ . '/schema/order_service_schema.php');

        // service schema
        $serviceSchema = create_car_service_schema($prefix, $this->prefix, $charset_collate, 'services');
        $serviceSchema = $serviceSchema['sql'];

        // create service schema
        dbDelta($serviceSchema);

        // service by commune schema
        $serviceByCommuneSchema = create_service_per_commune_schema($prefix, $this->prefix, $charset_collate, 'service_by_commune');
        $serviceByCommuneSchema = $serviceByCommuneSchema['sql'];

        // create service by commune schema
        dbDelta($serviceByCommuneSchema);

        // price services schema
        $priceSchema = create_price_schema($prefix, $this->prefix, $charset_collate, 'price');
        $priceSchema = $priceSchema['sql'];

        // create price schema
        dbDelta($priceSchema);

        // orders schema
        $orderSchema = create_order_service_schema($prefix, $this->prefix, $charset_collate, 'order');
        $orderSchema = $orderSchema['sql'];

        // create order schema
        dbDelta($orderSchema);
    }
}

global $wpdb;

$CarBooking = new CarBookingSchemas($wpdb);

require_once(__DIR__ . "/classes/Antours_List_Table.php");
require_once(__DIR__ . "/classes/Antours_Booking_Manager.php");
require_once(__DIR__ . "/classes/Antours_Service_Manager.php");
require_once(__DIR__ . "/classes/Antours_Price_Manager.php");
require_once(__DIR__ . "/classes/Antours_CarBooking_Manager.php");
require_once(__DIR__ . "/classes/Antours_CarBooking_API.php");
require_once(__DIR__ . "/helpers/AntoursCarBookingRenderers.php");
require_once(__DIR__ . "/helpers/AntoursCarBookingMenu.php");
require_once(__DIR__ . "/helpers/AntoursCarBookingProcess.php");


add_action("admin_enqueue_scripts", "add_scripts");

add_action("admin_menu", "addMenuCarBooking");

register_activation_hook(__FILE__, array($CarBooking, 'install'));
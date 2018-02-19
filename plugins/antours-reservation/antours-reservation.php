<?php
/*
Plugin Name: Antours Reservation Packages
Plugin URI: https://github.com/johuder33/antours-web
Description: Plugin for handle reservation 
Version: 1.0
Author: Juorder Gonzalez
Author URI: https://github.com/johuder33
Text Domain: antours-reservation
License: MIT
*/

$classes = [
    'Configuration.php',
    'Reservation.php',
    'Reservation_TableList.php',
    'Antours_Reservation.php'
];

foreach($classes as $className) {
    require_once(__DIR__ . '/classes/' . $className);
}

/**
 * $package_reservation_version
 * defines version for the plugin
 */
global $package_reservation_version;
$package_reservation_version = '1.0';

class Installer {
    static public function setup() {
        global $package_reservation_version;
        // load lib for creating tables into the DB
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = self::sql();
        dbDelta($sql);
        // let's save our current plugin version
        add_option( 'package_reservation_version', $package_reservation_version );
    }

    static public function update() {
        global $package_reservation_version;

        // if the current version is not the same defined at the top, so let's update it.
        if (get_site_option('package_reservation_version') != $package_reservation_version) {
            self::setup();
        }
    }

    static public function sql() {
        $sql = Configuration::schema();

        return $sql;
    }
}

// this hook will execute when plugin is installed
register_activation_hook(__FILE__, array('Installer', 'setup'));

// this action will execute when plugin is updated
add_action( 'plugins_loaded', array('Installer', 'update') );

// this another hooked action will initialize the Reservation List Page into wordpress admin dashboard
// if you have any doubt please, see at https://codex.wordpress.org/Plugin_API/Action_Reference/plugins_loaded
add_action( 'plugins_loaded', function () {
	Antours_Reservation::get_instance();
});

// let's add our languages file to translate our plugin
add_action( 'plugins_loaded', ['Configuration', 'load_translations']);

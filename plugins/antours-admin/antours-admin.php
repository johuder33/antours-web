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
 * Plugin Name:       Antours admin plugin
 * Plugin URI:        https://github.com/johuder33/antours.git
 * Description:       This plugin will handle all admin process related to antours system.
 * Version:           1.0.0
 * Author:            Juorder Gonzalez
 * Author URI:        https://github.com/johuder33/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('WPINC')) {
    die;
}

add_action( 'plugins_loaded', 'antours_admin_initializer' );

$paths = glob(plugin_dir_path(__FILE__) . "admin/classes/*.php");

foreach($paths as $file) {
    include_once $file;
}

// include shared classes
include_once(plugin_dir_path(__FILE__) . "shared/class-deserializer.php");
// include public classes
include_once(plugin_dir_path(__FILE__) . "public/class-content.php");

function antours_admin_initializer() {
    $serializer = new Serializer();
    $serializer->init();

    $deserializer = new Deserializer();

    $public = new Content($deserializer);
    $public->init();

    $submenuPage = new Submenu_Page($deserializer);
    $submenu = new Submenu($submenuPage);

    $submenu->init();
}
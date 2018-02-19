<?php

class Antours_Reservation {
    static $instance;
    public $customers_obj;

    public function __construct() {
        add_filter('set-screen-option', [__CLASS__, 'set_screen'], 10, 3);
        add_action('admin_menu', [$this, 'plugin_menu']);
    }

    public static function set_screen($status, $option, $value) {
        return $value;
    }

    public function plugin_menu() {
        $hook = add_menu_page(
            Configuration::getTranslation('reservation_title_page'),
            Configuration::getTranslation('reservation_title_menu'),
            'manage_options',
            'antours_reservation_list',
            [$this, 'plugin_settings_page'],
            'dashicons-editor-ul',
            30
        );

        add_action("load-$hook", [$this, 'screen_option']);
    }

    public function plugin_settings_page() {
        ?>
            <div class="wrap">
                <h2>Antours Reservation Table List Example</h2>

                <div id="poststuff">
                    <?php $this->customers_obj->prepare_items(); ?>
                    <?php $this->customers_obj->display(); ?>
                </div>
            </div>
        <?php
    }

    public function screen_option() {
        $option = 'per_page';
        $args = [
            'label' => 'Reservation',
            'default' => 5,
            'option' => 'reservation_per_page'
        ];

        add_screen_option($option, $args);
        $this->customers_obj = new Reservation_List();
    }

    public static function get_instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
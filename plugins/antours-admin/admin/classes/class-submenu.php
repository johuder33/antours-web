<?php

/*
* Creates the submenu item for the plugin
*/

class Submenu {
    private $submenu_page;

    public function __construct($submenu_page_instance) {
        $this->submenu_page = $submenu_page_instance;
    }

    // this function will init the plugin
    public function init() {
        // in admin_menu hook, will call add_options_page method of the current class
        // so this: array($this, 'add_options_page') do that
        add_action('admin_menu', array($this, 'add_menu_page'));
    }

    public function add_menu_page() {
        add_menu_page(
            __("Antours Nosotros", "antours_about_title"),
            __("Antours Nosotros", "antours_about_menu"),
            'manage_options',
            'antours-about',
            array($this->submenu_page, 'render'),
            'dashicons-groups',
            30
        );
    }
}
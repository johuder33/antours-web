<?php

class Submenu_Page {
    private $deserializer;

    public function __construct($deserializer) {
        $this->deserializer = $deserializer;
    }

    public function render() {
        $template =  plugin_dir_path(__FILE__) . '../views/about.php';
        include_once($template);
    }
}
<?php

class Content {
    private $deserializer;

    public function __construct($deserializer) {
        $this->deserializer = $deserializer;
    }

    public function init() {
        add_filter('the_content', array($this, 'display'));
    }
}
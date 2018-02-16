<?php

class Deserializer {
    public function get_value($option_key) {
        return get_option($option_key);
    }
}
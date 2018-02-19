<?php

class Configuration {
    public static $tablename = 'package_reservation';
    public static $prefix = 'antours';
    public static $translationDomain = 'antours-reservation';

    public static function getTableName() {
        global $wpdb;
        return $wpdb->prefix . self::$prefix . '_' . self::$tablename;
    }

    public static function getTranslation($label) {
        return __($label, self::$translationDomain);
    }

    public static function printTranslation($label) {
        _e($label, self::$translationDomain);
    }

    public static function schema() {
        global $wpdb;
        $tablename = self::getTableName();
        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tablename (
            id integer NOT NULL AUTO_INCREMENT,
            package_id integer NOT NULL,
            customer_fullname tinytext NOT NULL,
            customer_doc tinytext NOT NULL,
            customer_id tinytext NOT NULL,
            customer_phone varchar(20) NOT NULL,
            customer_email tinytext NULL DEFAULT NULL,
            customer_address varchar(1000) NULL DEFAULT NULL,
            amount_passengers tinyint NOT NULL DEFAULT 1,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset;";

        return $sql;
    }

    public static function load_translations() {
        load_plugin_textdomain(self::$translationDomain, false, dirname( plugin_basename( __DIR__ ) ) . '/languages/');
    }
}
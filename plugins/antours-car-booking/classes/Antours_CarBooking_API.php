<?php

global $wpdb;

class Antours_CarBooking_API {
    static public $prefix = "antours_";
    static public $province_table = "province";
    static public $commune_table = "commune";
    static public $service_table = "service_by_commune";
    static public $order_table = "order";

    /* FUNCTIONS HELPERS */
    static public function getTableName($table) {
        global $wpdb;
        $prefix = $wpdb->prefix . self::$prefix;
        $tablename = $prefix . $table;

        return $tablename;
    }

    static public function hasResults($results) {
        if ($results && is_array($results) && count($results) > 0) {
            return true;
        }

        return false;
    }
    /* FUNCTIONS HELPERS */

    static public function getCities() {
        global $wpdb;
        $tablename = self::getTableName(self::$province_table);
        $results = $wpdb->get_results("SELECT * FROM {$tablename} WHERE actived = 1");

        if (self::hasResults($results)) {
            return $results;
        }

        return array();
    }

    static public function getCityById($cityId) {
        if (is_null($cityId) || !is_numeric($cityId)) {
            return false;
        }

        global $wpdb;
        $tablename = self::getTableName(self::$province_table);
        $results = $wpdb->get_results("SELECT name FROM {$tablename} WHERE id_province = {$cityId}");

        if (self::hasResults($results)) {
            return $results;
        }

        return array();
    }

    static public function getCommuneById($communeId) {
        if (is_null($communeId) || !is_numeric($communeId)) {
            return false;
        }

        global $wpdb;
        $tablename = self::getTableName(self::$commune_table);

        $results = $wpdb->get_results("SELECT name FROM {$tablename} WHERE id_commune = {$communeId}");

        if (self::hasResults($results)) {
            return $results;
        }

        return array();
    }

    static public function getCommuneByCityId($cityId) {
        if (is_null($cityId) || !is_numeric($cityId)) {
            return false;
        }

        global $wpdb;
        $tablename = self::getTableName(self::$commune_table);
        $results = $wpdb->get_results("SELECT * FROM {$tablename} WHERE actived = 1 AND id_province = $cityId;");

        if (self::hasResults($results)) {
            return $results;
        }

        return false;
    }

    static public function getServicesByCommuneId($communeId) {
        global $wpdb;
        $prefix = self::$prefix;
        $tablename = self::$service_table;
        $prefix = $wpdb->prefix . $prefix;
        $tableName = $prefix . $tablename;

        $result = $wpdb->get_results("SELECT t1.id_single_service, t2.service_name, t2.desc_service, t3.price, t4.name FROM wp_antours_service_by_commune t1 INNER JOIN wp_antours_services t2 USING (id_service) INNER JOIN wp_antours_price t3 USING (id_price) INNER JOIN wp_antours_commune t4 USING (id_commune) WHERE id_commune = $communeId;");

        if (is_array($result) && count($result)) {
            return $result;
        }

        return false;
    }

    static public function setReservation($dataArray) {
        global $wpdb;
        $prefix = self::$prefix;
        $tablename = self::$order_table;
        $prefix = $wpdb->prefix . $prefix;
        $tableName = $prefix . $tablename;

        $result = $wpdb->insert($tableName, $dataArray);

        if ($result) {
            $result = array('order_id' => $wpdb->insert_id);
        }

        return $result;
    }
}
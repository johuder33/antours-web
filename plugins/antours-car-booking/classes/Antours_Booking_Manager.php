<?php

class Antours_Booking_Manager {
    private $db = null;
    private $domain_translation = null;
    private $prefix = "antours_";
    private $tableRegion = "region";
    private $tableProvince = "province";
    private $tableCommune = "commune";
    private $tableServices = "services";
    private $tableServiceByCommune = "service_by_commune";
    private $tablePrice = "price";
    private $tableOrder = "order";

    function __construct($databaseManager, $domain) {
        $this->db = $databaseManager;
        $this->prefix = $this->db->prefix.$this->prefix;
        $this->domain_translation = $domain;
    }

    public function getRegions($actived = null) {
        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableRegion;
        $query = array();

        if (isset($actived)) {
            array_push($query, "WHERE actived = {$actived}");
        }

        $query = implode("", $query);

        $results = $db->get_results("SELECT * FROM {$table} {$query};");

        if (count($results) === 0) {
            return false;
        }

        return $results;
    }

    public function getRegionById($id, $actived = 1) {
        if (!isset($id)) {
            return false;
        }

        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableRegion;

        $results = $db->get_results("SELECT * FROM {$table} WHERE id_region = {$id} AND actived = {$actived};");

        if (count($results) === 0) {
            return false;
        }

        $results = $results[0];

        return $results;
    }

    public function getProvincesByRegionID($id_region, $actived = null) {
        if (!isset($id_region) || empty($id_region)) {
            return new WP_Error(400, __('Missing region id', $this->domain_translation));
        }

        if (!is_int($id_region)) {
            return new WP_Error(400, __('Is not int region id', $this->domain_translation));
        }

        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableProvince;
        $query = "";

        if (isset($actived)) {
            $query = " AND actived = {$actived}";   
        }
        
        $results = $db->get_results("SELECT * FROM {$table} WHERE id_region = {$id_region}{$query};");

        if (count($results) === 0) {
            return false;
        }

        return $results;
    }

    public function getProvinceById($id, $actived = 1) {
        if (!isset($id)) {
            return false;
        }

        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableProvince;

        $results = $db->get_results("SELECT * FROM {$table} WHERE id_province = {$id} AND actived = {$actived}");

        if (count($results) === 0) {
            return false;
        }

        $results = $results[0];

        return $results;
    }

    public function getCommunesByProvinceID($id_province, $actived = null) {
        if (!isset($id_province) || empty($id_province)) {
            return new WP_Error(400, __('Missing province id', $this->domain_translation));
        }

        if (!is_int($id_province)) {
            return new WP_Error(400, __('Is not int province id', $this->domain_translation));
        }

        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableCommune;
        $query = "";

        if (isset($actived)) {
            $query = " AND actived = {$actived}";
        }
        
        $results = $db->get_results("SELECT * FROM {$table} WHERE id_province = {$id_province}{$query};");

        if (count($results) === 0) {
            return false;
        }

        return $results;
    }

    public function getCommuneById($id, $actived = 1) {
        if (!isset($id)) {
            return false;
        }

        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableCommune;

        $results = $db->get_results("SELECT * FROM {$table} WHERE id_province = {$id} AND actived = {$actived}");

        if (count($results) === 0) {
            return false;
        }

        $results = $results[0];

        return $results;
    }

    public function updateRegion($actived = 1, $id_region) {
        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableRegion;

        $results = $db->update(
            $table,
            array("actived" => $actived),
            array("id_region" => $id_region)
        );

        return $results;
    }

    public function updateProvince($actived = 1, $id_province) {
        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableProvince;

        $results = $db->update(
            $table,
            array("actived" => $actived),
            array("id_province" => $id_province)
        );

        return $results;
    }

    public function updateCommune($actived = 1, $id_commune) {
        $db = $this->db;
        $prefix = $this->prefix;
        $table = $prefix.$this->tableCommune;

        $results = $db->update(
            $table,
            array("actived" => $actived),
            array("id_commune" => $id_commune)
        );

        return $results;
    }
}
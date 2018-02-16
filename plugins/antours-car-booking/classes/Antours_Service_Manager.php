<?php

class Antours_Service_Manager {
    private $db = null;
    private $tablename = "antours_services";

    function __construct($DBManager) {
        $this->db = $DBManager;
    }

    public function getServices($actived = null, $attributes = array("*")) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $attrs = implode($attributes, ",");

        $queryActived = "";

        if (is_integer($actived)) {
            $queryActived = "WHERE actived = $actived";
        }

        $results = $db->get_results("SELECT $attrs FROM $tablename $queryActived;");

        if (count($results) === 0) {
            return false;
        }

        return $results;
    }

    public function getServiceByID($id_service, $actived = 1) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $result = $db->get_row("SELECT * FROM $tablename WHERE id_service = $id_service AND actived = $actived;");

        return $results;
    }

    public function createService($service, $description, $actived = 1) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $results = $db->insert(
            $tablename,
            array(
                "service_name" => $service,
                "desc_service" => $description,
                "actived" => $actived
            ),
            array( 
                '%s',
                '%s',
                '%b'
            )
        );

        return $results;
    }

    public function updateService($id_service, $data = array()) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $result = $db->update(
            $tablename,
            $data,
            array(
                'id_service' => $id_service
            )
        );

        return $result;
    }

    public function deleteService($id_service) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $result = $db->delete(
            $tablename,
            array(
                'id_service' => $id_service
            ),
            array(
                '%d'
            )
        );

        return $result;
    }
}
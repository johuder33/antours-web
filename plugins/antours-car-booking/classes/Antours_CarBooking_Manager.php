<?php

class Antours_CarBooking_Manager {
    private $db = null;
    private $tablename = "antours_service_by_commune";

    function __construct($DBManager) {
        $this->db = $DBManager;
    }

    public function createCarService($data) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tableName = $prefix.$this->tablename;

        $result = $db->insert(
            $tableName,
            $data
        );

        return $result;
    }

    public function getCarServiceById($id) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tableName = $prefix.$this->tablename;

        $result = $db->get_results("SELECT t1.id_single_service, t2.service_name, t2.desc_service, t3.price, t4.name FROM wp_antours_service_by_commune t1 INNER JOIN wp_antours_services t2 USING (id_service) INNER JOIN wp_antours_price t3 USING (id_price) INNER JOIN wp_antours_commune t4 USING (id_commune) WHERE id_single_service = $id;");

        if (count($result) === 0) {
            return false;
        }

        return $result;
    }

    public function getCarServices() {
        $db = $this->db;
        $prefix = $db->prefix;
        $tableName = $prefix.$this->tablename;

        $result = $db->get_results("SELECT t1.id_single_service, t1.actived, t2.service_name, t2.desc_service, t3.price, t4.name FROM wp_antours_service_by_commune t1 INNER JOIN wp_antours_services t2 USING (id_service) INNER JOIN wp_antours_price t3 USING (id_price) INNER JOIN wp_antours_commune t4 USING (id_commune);");

        if (count($result) === 0) {
            return false;
        }

        return $result;
    }

    public function getCarServiceByCommuneId($idCommune) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tableName = $prefix.$this->tablename;

        $result = $db->get_results("SELECT t1.id_single_service, t2.service_name, t2.desc_service, t3.price, t4.name FROM wp_antours_service_by_commune t1 INNER JOIN wp_antours_services t2 USING (id_service) INNER JOIN wp_antours_price t3 USING (id_price) INNER JOIN wp_antours_commune t4 USING (id_commune) WHERE id_commune = $idCommune;");

        if (count($result) === 0) {
            return false;
        }

        return $result;
    }
}
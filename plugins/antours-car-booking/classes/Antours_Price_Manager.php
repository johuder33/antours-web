<?php

class Antours_Price_Manager {
    private $db = null;
    private $tablename = "antours_price";

    function __construct($DBManager) {
        $this->db = $DBManager;
    }

    public function getPrices($actived = null, $attributes = array("*")) {
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

    public function getPriceByID($id_price, $actived = 1) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $result = $db->get_row("SELECT * FROM $tablename WHERE id_price = $id_price AND actived = $actived;");

        return $results;
    }

    public function createPrice($price, $actived = 1) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $results = $db->insert(
            $tablename,
            array(
                "price" => $price,
                "actived" => $actived
            ),
            array( 
                '%f', 
                '%b'
            )
        );

        return $results;
    }

    public function updatePrice($id_price, $data = array()) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $result = $db->update(
            $tablename,
            $data,
            array(
                'id_price' => $id_price
            )
        );

        return $result;
    }

    public function deletePrice($id_price) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->tablename;

        $result = $db->delete(
            $tablename,
            array(
                'id_price' => $id_price
            ),
            array(
                '%d'
            )
        );

        return $result;
    }
}
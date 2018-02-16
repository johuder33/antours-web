<?php

class Reservation_Booking {
    private $db = null;
    private $table = "antours_reservation";

    function __construct($DBManager) {
        $this->db = $DBManager;
    }

    public function save($params) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->table;

        $db->insert(
            $tablename,
            $params
        );

        $result_id = $db->insert_id;

        return $result_id;
    }

    public function remove($id_reservation) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->table;

        /*$reservationExists = $db->get_var("SELECT COUNT(*) FROM {$tablename} WHERE id_reservation={$id_reservation}");

        if ($reservationExists <= 0) {
            var_dump("NO HAY NADA");
            return;
            // should throw error
        }

        var_dump($id_reservation);*/

        var_dump($id_reservation);

        $result = $db->update(
            $tablename,
            array('actived' => 0),
            array('id_reservation' => $id_reservation),
            array( '%d' )
        );

        return $result;
    }

    public function getCountItems() {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->table;

        $count = $db->get_var( "SELECT COUNT(*) FROM {$tablename} WHERE actived = 1" );

        return $count;
    }

    public function get($limit = null, $offset = null, $output_type = OBJECT) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->table;
        $limitation = array();

        if (isset($limit) && is_numeric($limit)) {
            array_push($limitation, "LIMIT {$limit}");
        }

        if (isset($offset) && is_numeric($offset)) {
            array_push($limitation, "OFFSET {$offset}");
        }

        $limitation = implode(" ", $limitation);
        $query = "SELECT * FROM {$tablename} WHERE actived = 1 {$limitation}";

        $results = $db->get_results($query, $output_type);

        return $results;
    }

    public function getByPackageId($id_package) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->table;

        $result = $db->get_results("SELECT * FROM {$tablename} WHERE id_package = {$id_package}");

        return $result;
    }

    public function getByReservationId($id_reservation) {
        $db = $this->db;
        $prefix = $db->prefix;
        $tablename = $prefix.$this->table;

        $result = $db->get_results("SELECT * FROM {$tablename} WHERE id_reservation = {$id_reservation}");

        if (count($result) <= 0) {
            $result = false;
        }

        return array_pop($result);
    }
}
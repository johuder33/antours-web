<?php

function create_reservation_schema($prefix, $dbprefix, $collate, $tablename) {
    $tableName = $prefix.$dbprefix.$tablename;

    $sql = "CREATE TABLE IF NOT EXISTS {$tableName} (
        id_reservation INT(11) NOT NULL AUTO_INCREMENT,
        id_package INT(11) NOT NULL,
        customer_fullname varchar(100) NOT NULL,
        customer_rut INT(20) NOT NULL,
        customer_phone INT(15) NULL,
        customer_email VARCHAR(255) NOT NULL,
        amount_passenger INT(2) NOT NULL,
        hotel_address VARCHAR(255) NULL,
        status INT(2) NOT NULL DEFAULT 1,
        actived TINYINT(1) DEFAULT 1,
        PRIMARY KEY (id_reservation)
    ) COLLATE {$collate}";

    return array(
        'schema' => $sql
    );
}
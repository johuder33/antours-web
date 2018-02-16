<?php

function create_car_service_schema($prefix, $dbprefix, $collate, $tablename) {
    $tableName = $prefix.$dbprefix.$tablename;

    $sql = "CREATE TABLE IF NOT EXISTS {$tableName} (
        id_service INT(11) NOT NULL AUTO_INCREMENT,
        service_name varchar(100) NOT NULL,
        desc_service varchar(255) NULL,
        actived TINYINT(1) DEFAULT 1,
        PRIMARY KEY (id_service)
    ) COLLATE {$collate}";

    return array(
        'sql' => $sql
    );
}
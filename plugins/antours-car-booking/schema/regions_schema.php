<?php

function create_region_schema($prefix, $dbprefix, $collate, $tablename) {
    $tableName = $prefix.$dbprefix.$tablename;
    $sql = "CREATE TABLE IF NOT EXISTS {$tableName} (
        id_region int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        ordinal_name varchar(4) NOT NULL,
        actived TINYINT(1) DEFAULT 1,
        PRIMARY KEY (id_region)
    ) COLLATE {$collate}";

    return array(
        'schema' => $sql,
        'data' => populate_region_schema(),
        'tablename' => $tableName
    );
}

function populate_region_schema() {
    $sql = array(
        array('name' => 'Arica y Parinacota', 'ordinal_name' => 'XV'),
        array('name' => 'Tarapacá', 'ordinal_name' => 'I'),
        array('name' => 'Antofagasta', 'ordinal_name' => 'II'),
        array('name' => 'Atacama', 'ordinal_name' => 'III'),
        array('name' => 'Coquimbo', 'ordinal_name' => 'IV'),
        array('name' => 'Valparaiso', 'ordinal_name' => 'V'),
        array('name' => 'Metropolitana de Santiago', 'ordinal_name' => 'RM'),
        array('name' => 'Libertador General Bernardo O\'Higgins', 'ordinal_name' => 'VI'),
        array('name' => 'Maule', 'ordinal_name' => 'VII'),
        array('name' => 'Biobío', 'ordinal_name' => 'VIII'),
        array('name' => 'La Araucanía', 'ordinal_name' => 'IX'),
        array('name' => 'Los Ríos', 'ordinal_name' => 'XIV'),
        array('name' => 'Los Lagos', 'ordinal_name' => 'X'),
        array('name' => 'Aisén del General Carlos Ibáñez del Campo', 'ordinal_name' => 'XI'),
        array('name' => 'Magallanes y de la Antártica Chilena', 'ordinal_name' => 'XII')
    );

    return $sql;
}
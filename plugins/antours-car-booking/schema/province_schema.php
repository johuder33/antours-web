<?php

function create_province_schema($prefix, $dbprefix, $collate, $tablename) {
    $tableName = $prefix.$dbprefix.$tablename;

    $sql = "CREATE TABLE IF NOT EXISTS {$tableName} (
        id_province int(11) NOT NULL AUTO_INCREMENT,
        id_region int(11) NOT NULL,
        name varchar(100) NOT NULL,
        actived TINYINT(1) DEFAULT 1,
        PRIMARY KEY (id_province)
    ) COLLATE $collate";

    return array(
        'schema' => $sql,
        'data' => populate_province_schema(),
        'tablename' => $tableName
    );
}

function populate_province_schema() {
    $sql = array(
        array('name' => 'Arica', 'id_region' => 1),
        array('name' => 'Parinacota', 'id_region' => 1),
        array('name' => 'Iquique', 'id_region' => 2),
        array('name' => 'El Tamarugal', 'id_region' => 2),
        array('name' => 'Antofagasta', 'id_region' => 3),
        array('name' => 'El Loa', 'id_region' => 3),
        array('name' => 'Tocopilla', 'id_region' => 3),
        array('name' => 'Chañaral', 'id_region' => 4),
        array('name' => 'Copiapó', 'id_region' => 4),
        array('name' => 'Huasco', 'id_region' => 4),
        array('name' => 'Choapa', 'id_region' => 5),
        array('name' => 'Elqui', 'id_region' => 5),
        array('name' => 'Limarí', 'id_region' => 5),
        array('name' => 'Isla de Pascua', 'id_region' => 6),
        array('name' => 'Los Andes', 'id_region' => 6),
        array('name' => 'Petorca', 'id_region' => 6),
        array('name' => 'Quillota', 'id_region' => 6),
        array('name' => 'San Antonio', 'id_region' => 6),
        array('name' => 'San Felipe de Aconcagua', 'id_region' => 6),
        array('name' => 'Valparaiso', 'id_region' => 6),
        array('name' => 'Chacabuco', 'id_region' => 7),
        array('name' => 'Cordillera', 'id_region' => 7),
        array('name' => 'Maipo', 'id_region' => 7),
        array('name' => 'Melipilla', 'id_region' => 7),
        array('name' => 'Santiago', 'id_region' => 7),
        array('name' => 'Talagante', 'id_region' => 7),
        array('name' => 'Cachapoal', 'id_region' => 8),
        array('name' => 'Cardenal Caro', 'id_region' => 8),
        array('name' => 'Colchagua', 'id_region' => 8),
        array('name' => 'Cauquenes', 'id_region' => 9),
        array('name' => 'Curicó', 'id_region' => 9),
        array('name' => 'Linares', 'id_region' => 9),
        array('name' => 'Talca', 'id_region' => 9),
        array('name' => 'Arauco', 'id_region' => 10),
        array('name' => 'Bio Bío', 'id_region' => 10),
        array('name' => 'Concepción', 'id_region' => 10),
        array('name' => 'Ñuble', 'id_region' => 10),
        array('name' => 'Cautín', 'id_region' => 11),
        array('name' => 'Malleco', 'id_region' => 11),
        array('name' => 'Valdivia', 'id_region' => 12),
        array('name' => 'Ranco', 'id_region' => 12),
        array('name' => 'Chiloé', 'id_region' => 13),
        array('name' => 'Llanquihue', 'id_region' => 13),
        array('name' => 'Osorno', 'id_region' => 13),
        array('name' => 'Palena', 'id_region' => 13),
        array('name' => 'Aisén', 'id_region' => 14),
        array('name' => 'Capitán Prat', 'id_region' => 14),
        array('name' => 'Coihaique', 'id_region' => 14),
        array('name' => 'General Carrera', 'id_region' => 14),
        array('name' => 'Antártica Chilena', 'id_region' => 15),
        array('name' => 'Magallanes', 'id_region' => 15),
        array('name' => 'Tierra del Fuego', 'id_region' => 15),
        array('name' => 'Última Esperanza', 'id_region' => 15)
    );

    return $sql;
}
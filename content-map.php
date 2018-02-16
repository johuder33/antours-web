<?php
    
    global $metabox_prefix;

    $args = array(
        'type'         => 'map',
        'height'       => '300px',
        'js_options'   => array(
            'mapTypeId'   => 'ROADMAP',
            'zoomControl' => true
        )
    );

    $map = rwmb_meta($metabox_prefix.'trip_map', $args);
    $isMapEnabled = rwmb_meta($metabox_prefix.'is_map_enabled');

    if (!$isMapEnabled) {
        return;
    }
?>

<div class="map-container col-12 vertical-separator">
    <div class="map-wrapper row">
        <div class="col-12">
            <h1 class="page-header page-header-package">
                Mapa
            </h1>
            <?php
                echo $map;
            ?>
        </div>
    </div>
</div>
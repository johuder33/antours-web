<?php

global $regions;

if(!$regions) {
    return;
}

?>
<div class="bootstrap-wrapper">
    <div class="wrap">
        <div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Regiones del servicio de traslados</h4>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <?php echo __("Region col name", "car-booking"); ?>
                            </th>

                            <th>
                                <?php echo __("Region col status", "car-booking"); ?>
                            </th>

                            <th>
                                <?php echo __("Actions", "car-booking"); ?>
                            </th>
                        </tr>
                    </thead>

                    <?php
                        $tr = array();
                        foreach($regions as $region) {
                            $className = $region->actived ? "label-success" : "label-default";
                            $status = $region->actived ? __("Active", "car-booking") : __("Desactived", "car-booking");
                            $buttonName = $region->actived ? __("Desactivate", "car-booking") : __("Activate", "car-booking");
                            $activedValue = $region->actived ? 0 : 1;
                            $classBtn = $region->actived ? "btn-danger" : "btn-success";

                            $currentTR = "<tr> <td> <label>{$region->name}</label> </td> <td> <span class='label {$className}'>{$status}</span> </td> <td> <form method='post' action='admin-post.php'> " . wp_nonce_field( 'car_booking_checker' ) . " <input type='hidden' name='action' value='car_booking_region' /> <input type='hidden' name='active' value='{$activedValue}' /> <input type='hidden' name='region' value='{$region->id_region}' /> <input type='submit' class='btn {$classBtn}' value='" . $buttonName . "' /> </form> </td> </tr>";
                            array_push($tr, $currentTR);
                        }
                        $tr = implode("", $tr);

                        echo $tr;
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
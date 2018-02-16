<?php

global $provinces, $regions, $communes;

if(!$communes) {
    return;
}

?>
<div class="bootstrap-wrapper">
    <div class="wrap">
        <div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-body">
                        <h4>Provincias del servicio de traslados</h4>
                        <form>
                            <input type="hidden" value="<?php echo $_GET['page']; ?>" name="page" />
                            <div class="input-group">
                                <select class="form-control" name="region">
                                    <?php
                                        foreach($regions as $region) {
                                            $currentRegion = $_GET['region'];
                                            $selected = $currentRegion === $region->id_region ? "selected" : "";
                                            echo "<option {$selected} value='{$region->id_region}'>{$region->name}</option>";
                                        }
                                    ?>
                                </select>

                                <select class="form-control" name="province">
                                    <?php
                                        foreach($provinces as $province) {
                                            $currentRegion = $_GET['province'];
                                            $selected = $currentRegion === $province->id_province ? "selected" : "";
                                            echo "<option {$selected} value='{$province->id_province}'>{$province->name}</option>";
                                        }
                                    ?>
                                </select>
                                <span class="input-group-btn">
                                    <input type="submit" value="Filtrar" class="btn btn-success" />
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <?php echo __("Province col name", "car-booking"); ?>
                            </th>

                            <th>
                                <?php echo __("Province col status", "car-booking"); ?>
                            </th>

                            <th>
                                <?php echo __("Actions", "car-booking"); ?>
                            </th>
                        </tr>
                    </thead>

                    <?php
                        $tr = array();
                        foreach($communes as $commune) {
                            $className = $commune->actived ? "label-success" : "label-default";
                            $status = $commune->actived ? __("Active", "car-booking") : __("Desactived", "car-booking");
                            $buttonName = $commune->actived ? __("Desactivate", "car-booking") : __("Activate", "car-booking");
                            $activedValue = $commune->actived ? 0 : 1;
                            $classBtn = $commune->actived ? "btn-danger" : "btn-success";

                            $currentTR = "<tr> <td> <label>{$commune->name}</label> </td> <td> <span class='label {$className}'>{$status}</span> </td> <td> <form method='post' action='admin-post.php'> " . wp_nonce_field( 'car_booking_checker' ) . " <input type='hidden' name='action' value='car_booking_commune' /> <input type='hidden' name='active' value='{$activedValue}' /> <input type='hidden' name='commune' value='{$commune->id_commune}' /> <input type='submit' class='btn {$classBtn}' value='" . $buttonName . "' /> </form> </td> </tr>";
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
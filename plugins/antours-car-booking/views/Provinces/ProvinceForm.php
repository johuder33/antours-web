<?php

global $provinces, $regions;

if(!$provinces) {
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
                        foreach($provinces as $province) {
                            $className = $province->actived ? "label-success" : "label-default";
                            $status = $province->actived ? __("Active", "car-booking") : __("Desactived", "car-booking");
                            $buttonName = $province->actived ? __("Desactivate", "car-booking") : __("Activate", "car-booking");
                            $activedValue = $province->actived ? 0 : 1;
                            $classBtn = $province->actived ? "btn-danger" : "btn-success";

                            $currentTR = "<tr> <td> <label>{$province->name}</label> </td> <td> <span class='label {$className}'>{$status}</span> </td> <td> <form method='post' action='admin-post.php'> " . wp_nonce_field( 'car_booking_checker' ) . " <input type='hidden' name='action' value='car_booking_province' /> <input type='hidden' name='active' value='{$activedValue}' /> <input type='hidden' name='province' value='{$province->id_province}' /> <input type='submit' class='btn {$classBtn}' value='" . $buttonName . "' /> </form> </td> </tr>";
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
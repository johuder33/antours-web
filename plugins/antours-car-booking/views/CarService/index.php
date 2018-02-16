<?php

global $services, $prices, $regions, $car_services;

?>

<div class="bootstrap-wrapper wrap">
    <form class="form" action="admin-post.php" method="POST">
        <input type="hidden" name="action" value="save_car_booking_service" />
        <div id="selectors-wrapper">
            <select class="form-control" id="region" name="region">
                <?php
                    if($regions) {
                        foreach($regions as $index => $region) {
                            echo "<option value='$region->id_region'>$region->name</option>";
                        }
                    }
                ?>
            </select>

            <div id="container-province">
            </div>

            <div id="container-commune">
            </div>
        </div>
        <select class="form-control" name="id_service">
            <?php
                if($services) {
                    foreach($services as $index => $service) {
                        echo "<option value='$service->id_service'>$service->service_name</option>";
                    }
                }
            ?>
        </select>
        <select class="form-control" name="id_price">
            <?php
                if($prices) {
                    foreach($prices as $index => $price) {
                        echo "<option value='$price->id_price'>$price->price</option>";
                    }
                }
            ?>
        </select>
        <button class="btn btn-primary" type="submit">
            Save
        </button>
    </form>

    <div class="row">
        <?php
            if($car_services) {
                foreach($car_services as $index => $carService) {
                    $item = $carService;
                    $status = $item->actived ? 'Active' : 'Inactive';
                    $statusButton = !$item->actived ? 'Active' : 'Inactive';
                    $statusButtonCss = !$item->actived ? 'success' : 'danger';
                    $commune = $item->name;
                    $price = $item->price;
                    $description = $item->desc_service;
                    $service = $item->service_name;
                    $statusCss = $item->actived ? 'success' : 'danger';
                    ?>
                        <div class="col-xs-3">
                            <form>
                                <div style="border: 1px solid blue; padding: 5px;">
                                    <div>
                                        Name: <?php echo $service; ?>
                                    </div>
                                    <div>
                                        Description: <?php echo $description; ?>
                                    </div>
                                    <div>
                                        Comuna: <?php echo $commune; ?>
                                    </div>
                                    <div>
                                        Precio: <?php echo $item->price; ?>
                                    </div>
                                    <div>
                                        Status: <label class="label label-<?php echo $statusCss; ?>"><?php echo $status; ?></label>
                                    </div>

                                    <div>
                                        <br>
                                        <button class="btn btn-<?php echo $statusButtonCss; ?>">
                                            <?php echo $statusButton; ?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php
                }
            }
        ?>
    </div>
</div>

<script>
    (function($){
        var region = $("#region");
        var actions = {
            province: window.car_booking_config.actionProvince,
            commune: window.car_booking_config.actionCommune
        }

        region.on("change", function(){
            var self = $(this);
            var id = self.val();
            $("#container-province").html("");
            $("#container-commune").html("");
            // window.car_booking_config.actionCommune
            getData(id, self, actions.province, function(data) {
                buildSelect(data, "Seleccione provincia", "province");
            });
        });

        function getData(id, ref, action, cb) {
            var data = {
                action,
                id
            }

            $.ajax({
                type: "POST",
                url: window.car_booking_config.ajax_url,
                data,
                dataType: "json",
                success: function(data) {
                    if (cb) { 
                        console.log(data);
                        cb(data);
                    }
                },
                error: function() {
                    console.log("Error");
                }
            });
        }

        $("#container-province").on("change", ".province", function(){
            var self = $(this);
            var id = self.val();

            console.log(id);

            getData(id, self, actions.commune, function(data) {
                buildSelect(data, "Seleccione comuna", "commune");
            });
        })

        function buildSelect(response, defaults, name) {
            var data = response.data;
            var select = $("<select class='form-control " + name + "'>");
            var container = "container-" + name;
            var idField = "id_" + name;

            if (name) {
                select.attr("name", name);
            }

            select.append("<option>" + defaults + "</option>");

            for(var i = 0; i < data.length; i++) {
                var item = data[i];
                var option = $("<option>");
                option.val(item[idField]);
                option.html(item.name);
                select.append(option);
            }

            $("#" + container).html(select);
        }

    })(jQuery);
</script>
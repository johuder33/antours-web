<?php

global $metabox_prefix, $postId;
$price = rwmb_meta($metabox_prefix.'trip_price_package');
$time_to_departure = rwmb_meta($metabox_prefix.'time_departure');
$time_to_return = rwmb_meta($metabox_prefix.'time_return');
$departure_places = rwmb_meta($metabox_prefix.'departure_place');

$postId = $post->ID;

?>

<div class="row product-information">
    <div class="price-wrapper col-12">
        <div class="row">
            <div class="col-12">
                <ul class="list-unstyled options-list meta-data-package">
                    <?php
                        if(isset($price)) {
                            ?>
                    <li>
                        <div class="info-block">
                            <span class="icon">
                                <i class="fa fa-money" aria-hidden="true"></i>
                            </span>
                            
                            <span>
                                <span class="tag-value">
                                    <strong class="icon-label icon-label-space">
                                        <?php echo $price; ?>
                                    </strong>
                                </span>
                            </span>
                        </div>
                    </li>
                            <?php
                        }
                    ?>

                    <?php
                        if(isset($time_to_departure) || isset($time_to_return)) {
                            ?>
                    <li>
                        <div class="info-block">
                            <div class="options-block">
                                <?php
                                    if($time_to_departure) {
                                        ?>
                                <span class="option">
                                    <i class="fa fa-hourglass" aria-hidden="true"></i>
                                    <span class="icon-label">
                                        Salida :
                                    </span>
                                    <span>
                                        <?php echo $time_to_departure; ?>
                                    </span>
                                </span>
                                        <?php
                                    }
                                ?>

                                <?php
                                    if($time_to_departure) {
                                        ?>
                                <span class="option">
                                    <i class="fa fa-hourglass-end" aria-hidden="true"></i>
                                    <span class="icon-label">
                                        Regreso :
                                    </span>
                                    <span>
                                        <?php echo $time_to_return; ?>
                                    </span>
                                </span>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </li>
                            <?php
                        }
                    ?>

                    <?php
                        if(is_array($departure_places) && sizeof($departure_places) > 0) {
                            ?>
                    <li>
                        <div class="info-block">
                            <div>
                                <i class="fa fa-users" aria-hidden="true"></i>
                                Puntos de salidas
                            </div>

                            <?php
                                foreach($departure_places as $place) {
                                    ?>
                                    <div class="option">
                                        <span class="icon">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        </span>
                                        
                                        <span>
                                            <span class="tag-value">
                                                <strong class="icon-label icon-label-space">
                                                    <?php echo $place; ?>
                                                </strong>
                                            </span>
                                        </span>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        </div>

        <div class="product-form-quick">
            <?php get_template_part("content", "product-form"); ?>

            <div class="row">
                <div class="col-12">
                    <div class="btn-request-package">
                        <button class="btn btn-default btn-package center-block" data-id="<?php echo $postId; ?>">
                            Lo quiero!
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

global $reservation, $package, $metabox_prefix;

$thumbnail = get_the_post_thumbnail_url($package->ID, "thumbnail");
$price = rwmb_meta($metabox_prefix.'trip_price_package', array(), $package->ID);

?>

<div class="wrap">
    <div class="package-wrap">
        <div>
            <a href="?page=reservation" class="primary">
                Ver todos las reservaciones
            </a>
        </div>

        <h1 class="page-header"><i>Detalles del paquete</i></h1>

        <div>
            <h1 class="page-header"><strong><?php echo $package->post_title; ?></strong></h1>
        </div>

        <br/>
        <?php
            if($thumbnail) {
                ?>
                    <div>
                        <img src="<?php echo $thumbnail; ?>" />
                    </div>
                <?php
            }
        ?>

        <?php
            if (isset($price)) {
                ?>
                <div>
                    <label>
                        <strong>
                            Precio: 
                        </strong>

                        <?php echo $price; ?>
                    </label>
                </div>
                <?php
            }
        ?>
    </div>

    <div class="customer-wrap">
        <h1 class="page-header"><i>Detalles del cliente</i></h1>

        <div>
            <label>
                <h4>
                    Nombre del cliente:
                    <h3><i><?php echo $reservation->customer_fullname; ?></i></h3>
                </h4>
            </label>
        </div>

        <div>
            <label>
                <h4>
                    RUT del cliente:
                    <h3><i><?php echo $reservation->customer_rut; ?></i></h3>
                </h4>
            </label>
        </div>

        <div>
            <label>
                <h4>
                    Email del cliente:
                    <h3><i><?php echo $reservation->customer_email; ?></i></h3>
                </h4>
            </label>
        </div>

        <?php
            if(isset($reservation->customer_phone)) {
                ?>
                    <div>
                        <label>
                            <h4>
                                Teléfono del cliente:
                                <h3><i><?php echo $reservation->customer_phone; ?></i></h3>
                            </h4>
                        </label>
                    </div>
                <?php
            }
        ?>

        <div>
            <label>
                <h4>
                    Cantidad de pasajeros:
                    <h3><i><?php echo $reservation->amount_passenger; ?> </i></h3>
                </h4>
            </label>
        </div>

        <?php
            if(isset($reservation->hotel_address)) {
                ?>
                    <div>
                        <label>
                            <h4>
                                Dirección del hotel:
                                <h3><i><?php echo $reservation->hotel_address; ?></i></h3>
                            </h4>
                        </label>
                    </div>
                <?php
            }
        ?>
    </div>
</div>
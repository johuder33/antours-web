<?php

global $prices;

?>

<div class="bootstrap-wrapper wrap">
    <?php settings_errors(); ?>
    <form class="form" action="admin-post.php" method="POST">
        <input type="hidden" name="action" value="handle_price" />
        <input type="text" class="form-control" name="price" placeholder="Price Service" />
        <input type="checkbox" name="status" checked />
        <button class="btn btn-primary" type="submit">
            Save
        </button>
    </form>

    <div class="row">
        <?php
            if ($prices) {
                foreach($prices as $index => $price) {
                    $status = $price->actived ? __("Active", "domain") : __("Inactive","domain");
                    $statusButton = !$price->actived ? __("Active", "domain") : __("Inactive","domain");
                    $statusClassCss = $price->actived ? 'label-success' : 'label-danger';
                    $statusButtonCss = $price->actived ? 'btn-danger' : 'btn-success';
                    ?>
                    <div class="col-xs-3" style="border:1px solid blue;">
                        <div>
                            <strong>
                                Precio: 
                                <label>
                                    <?php echo $price->price ?>
                                </label>
                            </strong>
                        </div>

                        <div>
                            <strong>
                            Status : 
                            <span class="label <?php echo $statusClassCss; ?>">
                                <?php echo $status ?>
                            </span>
                            </strong>
                        </div>

                        <div>
                            <form action="admin-post.php" method="POST">
                                <input type="hidden" name="action" value="change_status_price" />
                                <input type="hidden" name="id_price" value="<?php echo $price->id_price; ?>" />
                                <input type="hidden" name="status" value="<?php echo !$price->actived; ?>" />
                                <button type="submit" class="btn <?php echo $statusButtonCss; ?>"><?php echo $statusButton; ?></button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>
    </div>
</div>
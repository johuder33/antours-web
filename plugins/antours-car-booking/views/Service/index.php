<?php

global $services;

?>

<div class="bootstrap-wrapper wrap">
    <form class="form" action="admin-post.php" method="POST">
        <input type="hidden" name="action" value="handle_service" />
        <input class="form-control" name="name" placeholder="Service Name" />
        <textarea name="description" class="form-control" placeholder="Service Description"></textarea>
        <input type="checkbox" checked name="status" />
        <button class="btn btn-primary" type="submit">
            Save
        </button>
    </form>

    <div class="row">
        <?php
            if ($services) {
                foreach($services as $index => $service) {
                    $item = $service;
                    $status = $item->actived ? __("Active", "domain") : __("Inactive","domain");
                    $statusButton = !$item->actived ? __("Active", "domain") : __("Inactive","domain");
                    $statusClassCss = $item->actived ? 'label-success' : 'label-danger';
                    $statusButtonCss = $item->actived ? 'btn-danger' : 'btn-success';
                    ?>
                    <div class="col-xs-3" style="border:1px solid blue;">
                        <div>
                            <strong>
                                Servicio: 
                                <label>
                                    <?php echo $item->service_name ?>
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
                            <div>
                                <strong>
                                    Description
                                </strong>
                                <p>
                                    <?php echo $item->desc_service; ?>
                                </p>
                            </div>
                        </div>

                        <div>
                            <form action="admin-post.php" method="POST">
                                <input type="hidden" name="action" value="change_status_service" />
                                <input type="hidden" name="id_service" value="<?php echo $item->id_service; ?>" />
                                <input type="hidden" name="status" value="<?php echo !$item->actived; ?>" />
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
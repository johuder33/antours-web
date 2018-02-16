<?php

// custom id for UI
$postID = "package-".$post->ID;
// post title
$post_title = $post->post_title;

?>

<div class="quick-form" id="<?php echo $postID; ?>">
    <div class="quick-container d-flex flex-column">
        <div class="quick-form-container">
            <div class="layout-loader" id="loader-<?php echo $post->ID; ?>">
                <div class="wrapper-loader">
                    <i class="fa fa-spinner fa-spin fa-5x"></i>
                </div>
            </div>
            <!-- <form class="form">
                <?php
                    echo $fields;
                ?>
            </form> -->
        </div>

        <div class="quick-control">
            <div class="detail-note row no-gutters align-items-center">
                <div class="title btn-close-quick-form col" data-id="<?php echo $postID; ?>">
                    <button type="button" class="close icon-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span>
                        <?php echo $post_title; ?>
                    </span>
                </div>

                <div class="action col-auto">
                    <button type="button" data-id="<?php echo $postID; ?>" class="btn btn-default text-uppercase btn-makeReserve">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>
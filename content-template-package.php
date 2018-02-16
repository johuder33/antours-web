<?php

global $packageFeaturedImage, $post;

// custom id for UI
$postID = "package-".$post->ID;
// post title
$post_title = $post->post_title;
// link
$permalink = get_the_permalink($post);
//thumbnail url
$image_url = has_post_thumbnail() ? get_the_post_thumbnail_url($post->ID, $packageFeaturedImage) : "http://www.visituganda.com/uploads/noimage.png";

?>

<div class="package-detail col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
    <div class="wrapper-package">
        <picture class="picture d-block text-center">
            <a href="<?php echo $permalink; ?>">
                <img src="<?php echo $image_url; ?>" class="img-fluid" />
                </a>
        </picture>
        <div class="detail-container">
            <div class="detail-note row no-gutters align-items-center">
                <div class="title col">
                    <span>
                        <?php echo $post_title; ?>
                    </span>
                </div>

                <div class="action col-auto">
                    <button data-id="<?php echo $postID; ?>" type="button" class="btn btn-default text-uppercase btn-reserve">Reservar</button>
                </div>
            </div>
        </div>
        <?php
            get_template_part('content', 'quick-form');
        ?>
    </div>
</div>
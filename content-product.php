<?php

global $packageFeaturedImage, $post, $postId;

$postId = $post->ID;
// post title
$post_title = $post->post_title;
// link
$permalink = get_the_permalink($post);
//thumbnail url
$hasThumbnail = has_post_thumbnail();
$image_url = $hasThumbnail ? get_the_post_thumbnail_url($post->ID, $packageFeaturedImage) : "http://www.visituganda.com/uploads/noimage.png";
$classEmpty = !$hasThumbnail ? 'non-img' : '';

?>

<div>
    <div class="product-image <?php echo $classEmpty; ?>" id="product-<?php echo $postId; ?>">
        <a href="<?php echo $permalink; ?>">
            <img class="img-fluid" src="<?php echo $image_url; ?>"/>
        </a>

        <div class="product-form">
            <?php get_template_part("content", "product-form"); ?>
        </div>
    </div>

    <div class="row no-gutters control-block">
        <div class="col product-title">
            <span>
                <i class="closeIcon fa fa-times" data-form-id="<?php echo $postId; ?>" aria-hidden="true"></i>
                <?php echo $post_title; ?>
            </span>
        </div>

        <div class="col-auto product-control">
            <button class="form-control-submit sender-<?php echo $postId; ?>" data-title="Reservar" data-active-title="Enviar" data-form-id="<?php echo $postId; ?>">
            </button>
        </div>
    </div>
</div>
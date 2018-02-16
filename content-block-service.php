<?php
global $serviceImageLabel;
$attachment = get_the_post_thumbnail_url($post, $serviceImageLabel);
$content = get_the_content();
$thumbnailID = get_post_thumbnail_id();

?>

<div class="overlay-border text-center">
    <div class="d-flex flex-column overlay-flex">
        <?php
            if ($attachment) {
                ?>
                    <img src="<?php echo $attachment; ?>" class="center-block img-fluid img-service" />
                <?php
            }
        ?>
        <a class="flex-overlay-container d-flex flex-column justify-content-center" href="<?php the_permalink();?>">
            <h1 class="overlay-title">
                <?php
                    echo $post->post_title;
                ?>
            </h1>
        </a>
    </div>

    <div class="content-service text-justify">
        <?php echo $content; ?>
    </div>
</div>
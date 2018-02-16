<?php

    global $about;

    $posts_per_page = get_option( 'posts_per_page' );

    $arguments = array(
        'post_type' => $about,
        'post_status' => 'publish',
        'posts_per_page' => 1
    );

    $query = new WP_Query( $arguments );

    


if ($query->have_posts()) {
    while($query->have_posts()) {
        $query->the_post();
        
        $content = get_the_content();
        $content = wpautop($content);
        $title = get_the_title();
?>

<div class="container margin-v-separator">
    <div class="row">
        <?php 
            $content_ = t("antours", "Service Content", "Service Content");

            if ($title && $content_) {
                renderTitle($title, $content_, array("big-title", "openSans", "fontLight"));
            }
        ?>

        <div class="home-container text-justify">
            <?php echo $content; ?>
        </div>

        <?php 
            $_title = t("antours", "Package Title", "Package Title");
            $_content = t("antours", "Package Content", "Package Content");

            if ($_title && $_content) {
                renderTitle($_title, $_content, array("normal-title", "openSans", "fontLight"));
            }
        ?>
    </div>
</div>

<?php

    }
}

?>
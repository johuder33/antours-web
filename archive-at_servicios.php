<?php
    get_header();

    global $services;

    $posts_per_page = get_option( 'posts_per_page' );

    $arguments = array(
        'post_type' => $services,
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page
    );

    $query = new WP_Query( $arguments );
?>

    <?php get_template_part("content", "menu"); ?>

    <div class="container-fluid">
        <?php get_template_part("content", "banners"); ?>
        <?php //get_template_part("content", "reservation"); ?>
        <?php get_template_part("content", "service"); ?>
        <?php //get_template_part("content", "packages"); ?>
    </div>

<?php get_footer(); ?>
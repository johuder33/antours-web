<?php get_header(); ?>

    <?php get_template_part("content", "menu"); ?>

    <div class="container-fluid">
        <?php get_template_part("content", "banners"); ?>
    </div>

    <div class="container">
        <?php //get_template_part("content", "reservation"); ?>
        <?php get_template_part("content", "packages-grid"); ?>
    </div>

<?php get_footer(); ?>
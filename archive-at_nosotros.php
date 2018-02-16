<?php get_header(); ?>

    <?php get_template_part("content", "menu"); ?>
    <div class="container-fluid">
        <?php get_template_part("content", "banners"); ?>
        <?php get_template_part("content", "about"); ?>
        <?php get_template_part("content", "packages"); ?>
    </div>

<?php get_footer(); ?>
<?php get_header(); ?>

    <?php get_template_part("content", "menu"); ?>

    <div class="container-fluid">
        <?php get_template_part("content", "banners"); ?>
        <?php //get_template_part("content", "reservation"); ?>
        <?php get_template_part("content", "home"); ?>
        <div class="container">
            <div class="row" style="margin: 30px 0;">
                <?php echo renderTitle("Paquetes destacados", "Conoce los destinos preferidos en Chile", array("normal-title", "openSans", "fontLight")); ?>
            </div>
        </div>
        <?php get_template_part("content", "packages"); ?>
    </div>

<?php get_footer(); ?>
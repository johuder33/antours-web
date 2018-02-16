<?php get_header(); ?>

    <?php get_template_part("content", "menu"); ?>

    <div class="container-fluid">
        <?php get_template_part("content", "banners"); ?>
        <?php get_template_part("content", "reservation"); ?>
        <?php get_template_part("content", "home"); ?>
        <div class="container">
            <?php 
                $title = t("antours", "Package Title", "Package Title");
                $content = t("antours", "Package Content", "Package Content");
                if ($title && $content) {
                    ?>
                    <div class="row margin-v-separator">
                        <?php
                            renderTitle($title, $content, array("normal-title", "openSans", "fontLight"));
                        ?>
                    </div>
                    <?php
                }
            ?>
        </div>
        <?php get_template_part("content", "features"); ?>
    </div>

<?php get_footer(); ?>
<?php

global $query, $serviceContent;

?>

<div class="container service-container margin-v-separator">

    <?php 
        $title = t("antours", "Service Title", "Service Title");
        $content = t("antours", "Service Content", "Service Content");
        if ($title && $content) {
            ?>
            <div class="row">
            <?php
                renderTitle($title, $content, array("normal-title", "openSans", "fontLight"));
            ?>
            </div>
            <?php
        }
    ?>

    <?php
        $queryServiceContent = new WP_Query( array("post_type" => $serviceContent, "posts_per_page" => 1) );
        if ($queryServiceContent->have_posts()) {
            ?>
            <div class="row">
                <div class="service-content text-justify">
                    <?php
                    while($queryServiceContent->have_posts()) {
                        $queryServiceContent->the_post();
                        $content = get_the_content();
                        $content = wpautop($content);
                        echo $content;
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    ?>

    <div class="row">
        <div class="service-content">
            <?php
                if ($query->have_posts()){
                    while($query->have_posts()){
                        $query->the_post();
                        // render the block-service template
                        get_template_part("content", "block-service");
                    }
                }
            ?>
        </div>
    </div>
    
    <?php 
        $title = t("antours", "Package Title", "Package Title");
        $content = t("antours", "Package Content", "Package Content");
        if ($title && $content) {
            ?>
            <div class="row">
            <?php
                renderTitle($title, $content, array("normal-title", "openSans", "fontLight"));
            ?>
            </div>
            <?php
        }
    ?>

</div>
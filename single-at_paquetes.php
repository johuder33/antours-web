<?php
    get_header();

    the_post();

    $content = wpautop(get_the_content());
?>

<?php get_template_part("content", "menu"); ?>
    
<div class="container-fluid">
    <?php get_template_part("content", "reservation"); ?>

    <div class="container">
        <div class="container-single-product row clearfix">
            <div class="product-content col-9">
                <div class="rows">
                    <h1 class="page-header page-header-package">
                        <?php the_title(); ?>
                    </h1>

                    <div class="text-justify content">
                        <?php echo $content; ?>
                    </div>

                    <?php get_template_part('content', 'gallery'); ?>
                </div>
            </div>

            <div class="product-information-container col-3">
                <?php get_template_part('content', 'information'); ?>
            </div>

            <?php
                get_template_part('content', 'map');
            ?>

            <?php
                // show comments if exists or can post one
                if( comments_open() || get_comments_number()) {
                    comments_template();
                }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
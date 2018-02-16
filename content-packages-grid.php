<?php

global $domain, $wp_query;
$paged = get_query_var('page') ? get_query_var('page') : 1 ;
// build select tag
$selectTagFilter = buildFilter(array("filter-by-category", "form-control"), null, __('Filter by category', $domain));

$productsPerRow = 3;
// $productsPerRow = get_option('posts_per_page');

?>

<!--<section class="col justify-content-md-end">
    <form class="form-horizontal row justify-content-end" id="filter-form">
        <div class="container-filter-form row">
            <div class="col">
            
            <div class="form-group">
            <?php echo $selectTagFilter; ?> 
            </div>

            </div>

            <div class="col-auto">
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-filter">
                        <?php _e("Apply filter", $domain); ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>-->

<?php
    $index = 1;
    while(have_posts()) {
        the_post();

        // open row div when it's the first item or it's divisible between 3
        if (($index % $productsPerRow) === 1) {                
            ?>
                <div class="row products-widgets">
            <?php
        }
        ?>

        <div class="product-widget col col-12 col-sm-6 col-md-4 col-lg-4">
            <?php
                get_template_part("content", "product");
            ?>
        </div>

        <?php
        // close row div when it's third element or the last element into loop
        if (($index % $productsPerRow) === 0 || (($index - 1) === $wp_query->post_count)) {
            ?>
                </div>
                <div class="w-100 divider"></div>
            <?php
        }

        $index++;
    }
?>

<div class="row">
    <?php show_wp_paginate($paged, $wp_query->max_num_pages); ?>
</div>
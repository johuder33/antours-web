<?php

get_header();

global $packages;
$category = get_the_terms($post->ID, 'antours-category');
$productsPerRow = 3;

?>

<div class="container-fluid">
    <?php get_template_part("content", "menu"); ?>

    <div class="container">
    <?php

            if (count($category) > 0) {
                $category = array_shift($category);
                //var_dump($wp_query->query['page']);
                // pagination
                $paged = get_query_var('page') ? get_query_var('page') : 1 ;
                // make query
                $args = array('tax_query' => array( 
                        array( 
                            'taxonomy' => 'antours-category',
                            'field' => 'id', 
                            'terms' => array($category->term_id) 
                        )),
                        'post_type' =>  $packages,
                        'post_status' => 'publish',
                        'paged' => $paged,
                        );

                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    $index = 1;
                    while($query->have_posts()) {
                        $query->the_post();

                        // open row div when it's the first item or it's divisible between 3
                        if (($index % $productsPerRow) === 1) {                
                            ?>
                                <div class="row products-widgets justify-content-center">
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
                        if (($index % $productsPerRow) === 0 || (($index - 1) === $query->post_count)) {
                            ?>
                                </div>
                                <div class="w-100 divider"></div>
                            <?php
                        }

                        $index++;
                    }

                    // show pagination
                    ?>
                    <div class="col-12">
                        <?php
                            show_wp_paginate($paged, $query->max_num_pages);
                        ?>
                    </div>
                    <?php
                } else {
                    get_template_part("content", "not_found");
                }
            } else {
                get_template_part("content", "not_found");
            }
        ?>
    </div>
</div>

<?php get_footer(); ?>
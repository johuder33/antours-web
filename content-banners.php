<?php
    global $about, $services, $home;
    $namespace = null;
    $banners = array();

    if (is_post_type_archive($about)) {
        $namespace = $about;
    }

    if (is_post_type_archive($services)) {
        $namespace = $services;
    }

    if (is_home()) {
        $namespace = $home;
    }

    if (!$namespace) {
        return;
    }

    if (!empty($namespace)) {
        $namespace = $namespace."_banner";
    }

    $args = array(
        'post_type' => $namespace,
        'posts_per_page' => -1
    );

    $query = query_posts($args);

    if (!have_posts()) {
        return;
    }

    if (have_posts()) {
        $container = new BannerManager();
        while(have_posts()) {
            the_post();
            if (has_post_thumbnail()) {
                $banner = new Banner($post, true, true, true); // getSourcesForBannersSizes($post);
                $container->addBanner($banner);
            }
        }
    }
    
    wp_reset_query();
?>

<!--<div class="row">
    <img
        src="http://via.placeholder.com/700x150"
        srcset="http://via.placeholder.com/380x150 380w, http://via.placeholder.com/580x150 580w, http://via.placeholder.com/850x150 850w" class="w-100"
        sizes="(min-width: 1200px) 1000px, (max-width: 1000px) 800px"
    />
</div>-->

<div class="row">
    <?php
        $container->render();
    ?>
</div>
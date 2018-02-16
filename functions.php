<?php
session_start();
date_default_timezone_set('America/Santiago');

$prefix = "antours";
$domain = $prefix;

// Antours page options class
require(get_template_directory() . "/system/AntoursContactPage.php");

// import custom Error classes
require(get_template_directory() . "/system/Mail.php");
require(get_template_directory() . "/system/fields.php");
require(get_template_directory() . "/system/AntoursBanners.php");
require(get_template_directory() . "/system/translation.php");
require(get_template_directory() . "/system/ajax_action_names.php");
require(get_template_directory() . "/system/ajax_request.php");

$metabox_prefix = $prefix."_mtx_";

$services = "at_servicios";
$packages = "at_paquetes";
$about = "at_nosotros";
$banners = "at_container_banner";
$home = "at_home";
$serviceContent = "at_services_content";
// namespace category antours
$categoryNamespace = "antours-category";

$serviceImageLabel = "antours_service_background";
$packageFeaturedImage = "package_featured_image";
$bannerPostTypeSize = "banner_post_type_size";
$bannerPostTypeForTablets = "banner_post_type_tablets";
$bannerPostTypeForSmartPhones = "banner_post_type_smartphones";
$bannerForDesktop = "banner_post_type_desktop";
$currentLanguage = function_exists("pll_current_language") ? pll_current_language() : '';

$categories = array(
    'EN' => array(
        'Tours' => array(
            'description' => $translation['EN_CUSTOM_CATEGORY_TOURS_DESC'],
            'slug' => 'tours'
        ),
        'People' => array(
            'description' => $translation['EN_CUSTOM_CATEGORY_PEOPLE_DESC'],
            'slug' => 'people'
        ),
        'Companies' => array(
            'description' => $translation['EN_CUSTOM_CATEGORY_COMPANIES_DESC'],
            'slug' => 'companies'
        ),
        'Privates' => array(
            'description' => $translation['EN_CUSTOM_CATEGORY_PRIVATES_DESC'],
            'slug' => 'privates'
        ),
        'Transfers' => array(
            'description' => $translation['EN_CUSTOM_CATEGORY_TRANSFERS_DESC'],
            'slug' => 'transfers'
        ),
        'Promotions' => array(
            'description' => $translation['EN_CUSTOM_CATEGORY_PROMOTIONS_DESC'],
            'slug' => 'promotions',
            'is_feature' => true
        ),
        'Best Sellers' => array(
            'description' => $translation['EN_CUSTOM_CATEGORY_BEST_SELLERS_DESC'],
            'slug' => 'best-sellers',
            'is_feature' => true
        ),
        'Most Luxurious' => array(
            'description' => $translation['EN_CUSTOM_CATEGORY_MOST_LUXURIOUS_DESC'],
            'slug' => 'most-luxurious',
            'is_feature' => true
        )
    ),
    'ES' => array(
        'Paquetes' => array(
            'description' => $translation['ES_CUSTOM_CATEGORY_PAQUETES_DESC'],
            'slug' => 'tours'
        ),
        'Personas' => array(
            'description' => $translation['ES_CUSTOM_CATEGORY_PERSONAS_DESC'],
            'slug' => 'personas'
        ),
        'Compañias' => array(
            'description' => $translation['ES_CUSTOM_CATEGORY_COMPANIAS_DESC'],
            'slug' => 'compania'
        ),
        'Privados' => array(
            'description' => $translation['ES_CUSTOM_CATEGORY_PRIVADOS_DESC'],
            'slug' => 'privados'
        ),
        'Traslados' => array(
            'description' => $translation['ES_CUSTOM_CATEGORY_TRASLADOS_DESC'],
            'slug' => 'traslados'
        ),
        'Promociones' => array(
            'description' => $translation['ES_CUSTOM_CATEGORY_PROMOTIONS_DESC'],
            'slug' => 'promociones',
            'is_feature' => true
        ),
        'Los más vendidos' => array(
            'description' => $translation['ES_CUSTOM_CATEGORY_BEST_SELLERS_DESC'],
            'slug' => 'los-mas-vendidos',
            'is_feature' => true
        ),
        'Los más lujosos' => array(
            'description' => $translation['ES_CUSTOM_CATEGORY_MOST_LUXURIOUS_DESC'],
            'slug' => 'los-mas-lujosos',
            'is_feature' => true
        )
    ),
    'PT' => array(
        'Passeios' => array(
            'description' => $translation['PT_CUSTOM_CATEGORY_PASSEIOS_DESC'],
            'slug' => 'passeios'
        ),
        'Pessoas' => array(
            'description' => $translation['PT_CUSTOM_CATEGORY_PESSOAS_DESC'],
            'slug' => 'pessoas'
        ),
        'Empresas' => array(
            'description' => $translation['PT_CUSTOM_CATEGORY_EMPRESAS_DESC'],
            'slug' => 'empresas'
        ),
        'Exclusivo' => array(
            'description' => $translation['PT_CUSTOM_CATEGORY_EXCLUSIVO_DESC'],
            'slug' => 'exclusivo'
        ),
        'Transferências' => array(
            'description' => $translation['PT_CUSTOM_CATEGORY_TRANSFERENCIAS_DESC'],
            'slug' => 'transferencias'
        ),
        'Promoções' => array(
            'description' => $translation['PT_CUSTOM_CATEGORY_PROMOTIONS_DESC'],
            'slug' => 'Promocoes',
            'is_feature' => true
        ),
        'O Mais Vendido' => array(
            'description' => $translation['PT_CUSTOM_CATEGORY_BEST_SELLERS_DESC'],
            'slug' => 'o-mais-vendido',
            'is_feature' => true
        ),
        'O Mais Luxuoso' => array(
            'description' => $translation['PT_CUSTOM_CATEGORY_MOST_LUXURIOUS_DESC'],
            'slug' => 'o-mais-luxuoso',
            'is_feature' => true
        )
    )
);

// add support for post thumbnail
add_theme_support( 'post-thumbnails' ); 

/*
* load_JS_ResourcesAtFrondEnd function will load
* all scripts files only in front end and finally
* we need to push it into the hook wordpress
*
* add_action function it is allowed 3 parameters
* 1: hook name (WP), 2: function name, 3: priority
*/
function load_JS_ResourcesAtFrondEnd() {
    global $post, $translation, $nonceRequest, $reservationActionName, $currentLanguage, $featuredPackagesActionName, $packages, $contactActionName, $serviceActionName, $communeActionName, $servicesByCommuneActionName, $packageReservationActionName, $commentsActionName, $translation;

    wp_enqueue_script("jquery", "https://code.jquery.com/jquery-3.2.1.slim.min.js", array(), false, true);
    wp_enqueue_script("popper", "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js", array("jquery"), null, true);
    wp_enqueue_script("bootstrap-antours-js", "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js", array("jquery"), null, true);
    wp_enqueue_script("jquery-datepicker", loadAssetFromResourceDirectory("scripts/datepicker", "datepicker.min.js"), array(), null, true);
    wp_enqueue_script("jquery-timepicker", "https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js", array(), null, true);
    wp_enqueue_script("antours-validators", loadAssetFromResourceDirectory("scripts", "validator.js"), array(), 1.0, true);
    wp_enqueue_script("antours-pubsub", loadAssetFromResourceDirectory("scripts", "pubsub.js"), array(), 1.0, true);
    wp_enqueue_script("antours-contact", loadAssetFromResourceDirectory("scripts", "contact.js"), array("antours-pubsub"), 1.0, true);
    wp_enqueue_script("antours-scripts", loadAssetFromResourceDirectory("scripts", "antours.js"), array("antours-contact", "antours-validators"), 1.3, true);
    wp_enqueue_script("antours-reservation", loadAssetFromResourceDirectory("scripts", "reservation.js"), array("antours-scripts"), 1, true);
    wp_enqueue_script("google-maps", "https://maps.google.com/maps/api/js?key=AIzaSyA9otsw6Uersa3aTB9IMV0gxyeyytOHBtw", array(), null, true);
    wp_enqueue_script("map-frontend", loadAssetFromResourceDirectory("scripts", "map.js"), array(), 1.0, true);
    wp_enqueue_script("moment", "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment-with-locales.min.js", array(), 1.0, true);
    wp_enqueue_script("jquery-validator", "https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js", array(), 1.0, true);
    wp_enqueue_script("multistepform", loadAssetFromResourceDirectory("scripts", "multistepform.js"), array("jquery", "jquery-validator"), 1.0, true);

    if (get_post_type() === $packages) {
        wp_enqueue_script('lightbox-js');
        wp_enqueue_script('toast-js', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js');
    }

    if (is_post_type_archive($packages) || is_front_page() || is_singular($packages)) {
        wp_enqueue_script("antours-products", loadAssetFromResourceDirectory("scripts", "products.js"), array('antours-scripts'), 1.0, true);
    }

    if (is_front_page()) {
        wp_enqueue_script("antours-front", loadAssetFromResourceDirectory("scripts", "front-page.js"), array('antours-scripts'), 1.0, true);
    }

    // expose ajax data to be able to send ajax request
    wp_localize_script( 'antours-scripts', 'AJAX_ANTOURS', array(
        'server_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce($nonceRequest),
        'postId' => $post->ID,
        'contact' => array(
            'action' => $contactActionName
        ),
        'services' => array(
            'action' => $serviceActionName
        ),
        'package_reservation' => array(
            'action' => $packageReservationActionName
        ),
        'transbooking' => array(
            'communes' => array(
                'action' => $communeActionName
            ),
            'services' => array(
                'action' => $servicesByCommuneActionName
            ),
            'reservation' => array(
                'action' => $reservationActionName
            )
        ),
        'comments' => array(
            'action' => $commentsActionName
        ),
        'featured' => array(
            'action' => $featuredPackagesActionName
        ),
        'language' => $currentLanguage,
        'translation' => array(
            'RESERVATION_PACKAGE_SUCCESS_TITLE' => $translation['RESERVATION_PACKAGE_SUCCESS_TITLE'],
            'RESERVATION_PACKAGE_ERROR_TITLE' => $translation['RESERVATION_PACKAGE_ERROR_TITLE'],
            'RESERVATION_PACKAGE_SUCCESS_MESSAGE' => $translation['RESERVATION_PACKAGE_SUCCESS_MESSAGE'],
            'TAXI_BOOKING_SERVICE_LABEL' => $translation['TAXI_BOOKING_SERVICE_LABEL'],
            'TAXI_BOOKING_SERVICE_NAME' => $translation['TAXI_BOOKING_SERVICE_NAME'],
            'TAXI_BOOKING_SERVICE_DESC' => $translation['TAXI_BOOKING_SERVICE_DESC'],
            'TAXI_BOOKING_PRICE' => $translation['TAXI_BOOKING_PRICE'],
            'TAXI_BOOKING_AIRPORT' => $translation['TAXI_BOOKING_AIRPORT'],
            'TAXI_BOOKING_ORIGIN' => $translation['TAXI_BOOKING_ORIGIN'],
            'TAXI_BOOKING_DESTINY' => $translation['TAXI_BOOKING_DESTINY'],
            'TAXI_BOOKING_TIME_GO' => $translation['TAXI_BOOKING_TIME_GO'],
            'TAXI_BOOKING_PASSENGERS' => $translation['TAXI_BOOKING_PASSENGERS'],
            'TAXI_BOOKING_TIME_RETURN' => $translation['TAXI_BOOKING_TIME_RETURN'],
            'TAXI_BOOKING_GO' => $translation['TAXI_BOOKING_GO'],
            'TAXI_BOOKING_RETURN' => $translation['TAXI_BOOKING_RETURN'],
            'TAXI_BOOKING_DATE_START' => $translation['TAXI_BOOKING_DATE_START'],
            'TAXI_BOOKING_DATE_RETURN' => $translation['TAXI_BOOKING_DATE_RETURN']
        )
    ));

    // wp_localize_script( 'antours-scripts', 'translations', array(
    //     'labels' => array(
    //         'origin' => $translation['TAXI_BOOKING_ORIGIN'],
    //         'destiny' => $translation['TAXI_BOOKING_DESTINY'],
    //         'price' => $translation['TAXI_BOOKING_PRICE'],
    //         'go' => $translation['TAXI_BOOKING_GO'],
    //         'return' => $translation['TAXI_BOOKING_RETURN'],
    //         'time_start' => $translation['TAXI_BOOKING_TIME_GO'],
    //         'time_return' => $translation['TAXI_BOOKING_TIME_RETURN'],
    //         'service' => $translation['TAXI_BOOKING_SERVICE_NAME'],
    //         'service_desc' => $translation['TAXI_BOOKING_SERVICE_DESC'],
    //         'passengers' => $translation['TAXI_BOOKING_PASSENGERS'],
    //         'airport' => $translation['TAXI_BOOKING_AIRPORT']
    //     )
    // ));
}

add_action("wp_enqueue_scripts", "load_JS_ResourcesAtFrondEnd");

/*
* load_CSS_ResourcesAtFrondEnd function will load
* all scripts files only in front end and finally
* we need to push it into the hook wordpress
*
* add_action function it is allowed 3 parameters
* 1: hook name (WP), 2: function name, 3: priority
*/
function load_CSS_ResourcesAtFrondEnd() {
    global $post, $packages;

    wp_enqueue_style("bootstrap-antours", "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css", array(), 1.1, false);
    wp_enqueue_style("jquery-datepicker", loadAssetFromResourceDirectory("scripts/datepicker", "datepicker.min.css"));
    wp_enqueue_style("jquery-timepicker", "https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css");
    wp_enqueue_style("open-sans-font", "https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800");
    wp_enqueue_style("antours-style", get_stylesheet_uri(), array(), 1.2);
    wp_enqueue_style('font-awesome');

    if ($post->post_type === $packages) {
        wp_enqueue_style('lightbox-css');
        wp_enqueue_style('toast-css', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
    }
}

add_action("wp_enqueue_scripts", "load_CSS_ResourcesAtFrondEnd");

/*
* loadAssetFromResourceDirectory function will return the base url
* and the context (directory name) contact with filename
* @return String
*/

function loadAssetFromResourceDirectory($context, $filename) {
    $base_url = get_template_directory_uri();

    if (empty($context) || empty($filename) || gettype($context) !== "string" || gettype($filename) !== "string") {
        return $base_url;
    }

    $base_url .= "/resources/$context/$filename";
    

    return $base_url;
}

/**
 * Loas scripts for logged admin users
 */
function load_scripts_for_admins($page) {
    global $post, $packages;

    // load custom css admin panel
    wp_enqueue_style("custom-admin-css", loadAssetFromResourceDirectory("css", "admin-panel.css"));
    // load custom js admin panel
    wp_enqueue_script("custom-admin-js", loadAssetFromResourceDirectory("scripts", "admin.js"), array(), 1.0, true);

    // check if is inside new post or edit post
    if (in_array($page, array('post.php', 'post-new.php'))) {
        if ($post->post_type === $packages) {
            wp_enqueue_script("manager-map-admin");
        }
    }
}

add_action('admin_enqueue_scripts', 'load_scripts_for_admins');


/**
 * Register scripts only for logged admin users
 */
function register_admin_scripts() {
    wp_register_script('numeric-js', loadAssetFromResourceDirectory("scripts", "autonumeric-price.js"));
    wp_register_script('manager-map-admin', loadAssetFromResourceDirectory("scripts", "manager-map.js"), array('numeric-js'));
    registerSocialNetworkFields();
}

function my_section_options_callback() { // Section Callback
    echo '<p>Ingrese la URL de sus redes sociales</p>';
}

function my_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    $help = $args[1];

    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
    if ($help) {
        echo "<br><span>{$help}</span>";
    }
}

function longtext_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    $help = $args[1];

    echo '<textarea id="'. $args[0] .'" name="'. $args[0] .'">'. $option .'</textarea>';
    if ($help) {
        echo "<br><span>{$help}</span>";
    }
}

function registerSocialNetworkFields() {
    add_settings_section(  
        'antours_options_section', // Section ID 
        'Redes Sociales de Antours', // Section Title
        'my_section_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'facebook_field', // Option ID
        'Facebook', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'antours_options_section', // Name of our section
        array( // The $args
            'facebook_field' // Should match Option ID
        )  
    );

    add_settings_field( // Option 1
        'twitter_field', // Option ID
        'Twitter', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'antours_options_section', // Name of our section
        array( // The $args
            'twitter_field' // Should match Option ID
        )  
    );

    add_settings_field( // Option 1
        'instagram_field', // Option ID
        'Instagram', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'antours_options_section', // Name of our section
        array( // The $args
            'twitter_field' // Should match Option ID
        )  
    );

    add_settings_field( // Option 1
        'email_receivers_field', // Option ID
        'Email Receivers', // Label
        'longtext_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'antours_options_section', // Name of our section
        array( // The $args
            'email_receivers_field', // Should match Option ID
            'Escribe los correos separados por (,) coma, que recibiran las solicitudes desde la página web'
        )  
    );

    register_setting('general','facebook_field', 'esc_attr');
    register_setting('general','twitter_field', 'esc_attr');
    register_setting('general','instagram_field', 'esc_attr');
    register_setting('general','email_receivers_field', 'esc_attr');
}

add_action('admin_init', 'register_admin_scripts');

/* ========================================================= */

/**
 * Register new custom sizes for each image
 */

// sizes allowed
$sizeBannerName = 'banner_size';

$sizes = array(
    $sizeBannerName => array(1400, 600),
    $serviceImageLabel => array(1024, 200)
);

$customImageSizes = array(
    $serviceImageLabel => array(
        1024,
        200,
        true
    ),
    $packageFeaturedImage => array(
        512,
        512,
        true
    ),
    $bannerPostTypeSize => array(
        1600,
        700,
        true,
        1101 // this is only for min-width porpuse
    ),
    $bannerPostTypeForTablets => array(
        1100,
        500,
        true,
        801 // this is only for min-width porpuse
    ),
    $bannerPostTypeForSmartPhones => array(
        800,
        500,
        true,
        1 // this is only for min-width porpuse
    ),
    $bannerForDesktop => array(
        1300,
        500,
        true,
        1
    )
);

function registerNewSizes() {
    global $customImageSizes;
    foreach($customImageSizes as $namespace => $args) {
        list($width, $height, $cut) = $args;
        add_image_size($namespace, $width, $height, $cut);
    }
}

function register_post_types_banner() {
    global $services, $about, $home, $translation;
    $postTypes = array(
        'SERVICE' => $services,
        'ABOUT' => $about,
        'HOME' => $home
    );

    foreach($postTypes as $key => $namespace) {
        $CommonPostTypeArgs = array(
            'labels' => array(
                'name' => $translation["BANNER_{$key}_NAME_MENU_LABEL"],
                'singular_name' => $translation["BANNER_{$key}_SINGULAR_MENU_LABEL"],
                'add_new' => $translation["BANNER_{$key}_ADD_NEW_MENU_LABEL"],
                'not_found' => $translation["BANNER_{$key}_NOT_FOUND_MENU_LABEL"],
                'all_items' => $translation["BANNER_{$key}_ALL_ITEMS_MENU_LABEL"],
                'add_new_item' => $translation["BANNER_{$key}_NEW_ITEM_MENU_LABEL"],
                'featured_image' => $translation["BANNER_{$key}_FEATURED_IMAGE_MENU_LABEL"],
                'set_featured_image' => $translation["BANNER_{$key}_SET_FEATURED_IMAGE_MENU_LABEL"],
            ),
            'public' => true,
            'description' => $translation["BANNER_{$key}_DESCRIPTION"],
            'has_archive' => false,
            'show_ui' => true,
            'show_in_menu' => 'edit.php?post_type='.$home,
            'supports' => array(
                'title',
                'thumbnail'
            )
        );
        
        register_post_type($namespace.'_banner', $CommonPostTypeArgs);
    }
}

function registerPostTypes() {
    // register post type roots
    global $services, $serviceContent, $packages, $about, $banners, $home, $domain, $categoryNamespace, $translation;
    // Create custom size
    registerNewSizes();

    $servicePostTypeArgs = array(
        'labels' => array(
            'name' => $translation['CPT_SERVICE_NAME_MENU_LABEL'],
            'singular_name' => $translation['CPT_SERVICE_SINGULAR_MENU_LABEL'],
            'add_new' => $translation['CPT_SERVICE_ADD_NEW_MENU_LABEL'],
            'not_found' => $translation['CPT_SERVICE_NOT_FOUND_MENU_LABEL'],
            'all_items' => $translation['CPT_SERVICE_ALL_ITEMS_MENU_LABEL'],
            'add_new_item' => $translation['CPT_SERVICE_NEW_ITEM_MENU_LABEL'],
            'featured_image' => $translation['CPT_SERVICE_FEATURED_IMAGE_MENU_LABEL'],
            'set_featured_image' => $translation['CPT_SERVICE_SET_FEATURED_IMAGE_MENU_LABEL'],
        ),
        'public' => true,
        'description' => $translation['CPT_SERVICE_DESCRIPTION'],
        'has_archive' => true,
        'show_ui' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        ),
        'menu_icon' => 'dashicons-products',
        'taxonomies' => array($categoryNamespace),
    );

    $packagePostTypeArgs = array(
        'labels' => array(
            'name' => $translation['CPT_PACKAGE_NAME_MENU_LABEL'],
            'singular_name' => $translation['CPT_PACKAGE_SINGULAR_MENU_LABEL'],
            'add_new' => $translation['CPT_PACKAGE_ADD_NEW_MENU_LABEL'],
            'not_found' => $translation['CPT_PACKAGE_NOT_FOUND_MENU_LABEL'],
            'all_items' => $translation['CPT_PACKAGE_ALL_ITEMS_MENU_LABEL'],
            'add_new_item' => $translation['CPT_PACKAGE_NEW_ITEM_MENU_LABEL'],
            'featured_image' => $translation['CPT_PACKAGE_FEATURED_IMAGE_MENU_LABEL'],
            'set_featured_image' => $translation['CPT_PACKAGE_SET_FEATURED_IMAGE_MENU_LABEL'],
        ),
        'public' => true,
        'description' => $translation['CPT_PACKAGE_DESCRIPTION'],
        'has_archive' => true,
        'show_ui' => true,
        'supports' => array(
            'title',
            'editor',
            'comments',
            'thumbnail'
        ),
        'taxonomies' => array($categoryNamespace),
    );

    $aboutPostTypeArgs = array(
        'labels' => array(
            'name' => $translation['CPT_ABOUT_NAME_MENU_LABEL'],
            'singular_name' => $translation['CPT_ABOUT_SINGULAR_MENU_LABEL'],
            'add_new' => $translation['CPT_ABOUT_ADD_NEW_MENU_LABEL'],
            'not_found' => $translation['CPT_ABOUT_NOT_FOUND_MENU_LABEL'],
            'all_items' => $translation['CPT_ABOUT_ALL_ITEMS_MENU_LABEL'],
            'add_new_item' => $translation['CPT_ABOUT_NEW_ITEM_MENU_LABEL'],
            'featured_image' => $translation['CPT_ABOUT_FEATURED_IMAGE_MENU_LABEL'],
            'set_featured_image' => $translation['CPT_ABOUT_SET_FEATURED_IMAGE_MENU_LABEL'],
        ),
        'public' => true,
        'description' => $translation['CPT_ABOUT_DESCRIPTION'],
        'has_archive' => true,
        'show_ui' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        )
    );

    $homePostTypeArgs = array(
        'labels' => array(
            'name' => $translation['CPT_HOME_NAME_MENU_LABEL'],
            'singular_name' => $translation['CPT_HOME_SINGULAR_MENU_LABEL'],
            'add_new' => $translation['CPT_HOME_ADD_NEW_MENU_LABEL'],
            'not_found' => $translation['CPT_HOME_NOT_FOUND_MENU_LABEL'],
            'all_items' => $translation['CPT_HOME_ALL_ITEMS_MENU_LABEL'],
            'add_new_item' => $translation['CPT_HOME_NEW_ITEM_MENU_LABEL'],
            'featured_image' => $translation['CPT_HOME_FEATURED_IMAGE_MENU_LABEL'],
            'set_featured_image' => $translation['CPT_HOME_SET_FEATURED_IMAGE_MENU_LABEL'],
        ),
        'public' => true,
        'description' => $translation['CPT_HOME_DESCRIPTION'],
        'has_archive' => false,
        'show_ui' => true,
        'supports' => array(
            'title',
            'editor'
        )
    );

    $serviceContentTypeArgs = array(
        'labels' => array(
            'name' => $translation['CPT_SERVICE_CONTENT_NAME_MENU_LABEL'],
            'singular_name' => $translation['CPT_SERVICE_CONTENT_SINGULAR_MENU_LABEL'],
            'add_new' => $translation['CPT_SERVICE_CONTENT_ADD_NEW_MENU_LABEL'],
            'not_found' => $translation['CPT_SERVICE_CONTENT_NOT_FOUND_MENU_LABEL'],
            'all_items' => $translation['CPT_SERVICE_CONTENT_ALL_ITEMS_MENU_LABEL'],
            'add_new_item' => $translation['CPT_SERVICE_CONTENT_NEW_ITEM_MENU_LABEL'],
            'featured_image' => $translation['CPT_SERVICE_CONTENT_FEATURED_IMAGE_MENU_LABEL'],
            'set_featured_image' => $translation['CPT_SERVICE_CONTENT_SET_FEATURED_IMAGE_MENU_LABEL'],
        ),
        'public' => true,
        'description' => $translation['CPT_SERVICE_CONTENT_DESCRIPTION'],
        'has_archive' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=' . $services,
        'supports' => array(
            'title',
            'editor'
        )
    );

    register_post_type($services, $servicePostTypeArgs);
    register_post_type($packages, $packagePostTypeArgs);
    register_post_type($about, $aboutPostTypeArgs);
    register_post_type($home, $homePostTypeArgs);
    register_post_type($serviceContent, $serviceContentTypeArgs);
    register_post_types_banner();

    register_taxonomy(
        $categoryNamespace,
        array($services, $packages),
        array(
            'label' => $translation['CUSTOM_CATEGORY_NAME'],
            'rewrite' => array( 'slug' => 'category' ),
            'hierarchical' => true,
        )
    );

    // register lightbox to be accesible for package single page
    wp_register_script('lightbox-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js');
    wp_register_style('lightbox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css');
    // register lightbox to be accesible for package single page

    // register fontwesome only to be used in post type packages
    wp_register_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
}

add_action('init', 'registerPostTypes');



/**
 * Register custom MetaBox for packages post type
 */
function RegisterMetaboxesInPackage($meta_boxes) {
    global $prefix, $domain, $services, $packages, $home, $about, $metabox_prefix, $translation;
    $pre = $metabox_prefix;

    $meta_boxes[] = array(
        'id' => $pre . 'trip_price',
		'title'  => $translation['METABOX_TRIP_PRICE_TITLE'],
        'post_types' => array( $packages ),
        'context'    => 'side',
        'priority'   => 'low',
		'fields' => array(
			array(
				'id'   => $pre . 'trip_price_package',
				'name' => $translation['METABOX_TRIP_PRICE'],
				'type' => 'text',
				'class' => array('numeric-price-antours')
			)
		),
	);

    $meta_boxes[] = array(
        'id'         => $pre . 'schedule',
        'title'      => $translation['METABOX_SCHEDULE_TRIP'],
        'post_types' => array( $packages ),
        'context'    => 'side',
        'priority'   => 'low',
        'fields' => array(
            array(
                'name'  => $translation['METABOX_TIME_DEPARTURE'],
                'id'    => $pre . 'time_departure',
                'type'  => 'time',
                'class' => 'time_go'
            ),
            array(
                'name'  => $translation['METABOX_TIME_RETURN'],
                'id'    => $pre . 'time_return',
                'type'  => 'time',
                'class' => 'time_return'
            ),
        )
    );

    $meta_boxes[] = array(
        'id'         => $pre . 'departure',
        'title'      => $translation['METABOX_DEPARTURE_PLACE_TITLE'],
        'post_types' => array( $packages ),
        'context'    => 'side',
        'priority'   => 'low',
        'fields' => array(
            array(
                'name'  => $translation['METABOX_DEPARTURE_PLACE'],
                'desc'  => $translation['METABOX_DEPARTURE_PLACE_DESCRIPTION'],
                'id'    => $pre . 'departure_place',
                'type'  => 'textarea',
                'class' => 'meeting_place',
                'attributes' => array(
                    'maxlength' => 255,
                    'rows' => 5
                ),
                'clone' => true,
                'add_button' => $translation['METABOX_DEPARTURE_PLACE_CLONE_BTN']
            )
        )
    );

    $key_map_address = $pre . 'trip_map_address';

    $meta_boxes[] = array(
		'title'  => $translation['METABOX_TRIP_MAP_TITLE'],
        'post_types' => array( $packages ),
        'context'    => 'normal',
        'priority'   => 'low',
		'fields' => array(
			array(
				'id'   => $key_map_address,
				'name' => $translation['METABOX_TRIP_MAP_ROUTE_NAME'],
				'type' => 'text'
            ),
            array(
				'id'   => $pre . 'is_map_enabled',
				'name' => $translation['METABOX_TRIP_MAP_ENABLED'],
                'type' => 'checkbox',
                'std' => 'checked'
			),
			array(
				'id' => $pre . 'trip_map',
				'name' => $translation['METABOX_TRIP_MAP'],
				'type' => 'map',
				// Default location: 'latitude,longitude[,zoom]' (zoom is optional)
				'std' => '-33.4394037,-70.7108879,10',
				'address_field' => $key_map_address,
				'api_key' => 'AIzaSyA9otsw6Uersa3aTB9IMV0gxyeyytOHBtw',
			),
		),
	);

    $meta_boxes[] = array(
        'id' => $pre . 'trip_gallery',
		'title'  => $translation['METABOX_TRIP_GALLERY_TITLE'],
        'post_types' => array( $packages ),
        'context'    => 'normal',
        'priority'   => 'low',
		'fields' => array(
			array(
				'id'   => $pre . 'trip_gallery_group',
				'name' => $translation['METABOX_TRIP_GALLERY'],
				'type' => 'image_advanced'
			)
		),
    );
    
    $meta_boxes[] = array(
        'id' => $pre . 'trip_video',
		'title'  => $translation['METABOX_TRIP_GALLERY_VIDEO_TITLE'],
        'post_types' => array( $packages ),
        'context'    => 'normal',
        'priority'   => 'low',
		'fields' => array(
			array(
				'id'   => $pre . 'trip_video_group',
				'name' => $translation['METABOX_TRIP_GALLERY_VIDEO_URL'],
                'type' => 'oembed',
                'clone' => true,
                'sort_clone' => true
			)
		),
	);
    
    return $meta_boxes;
}

/**
 * Check if url belong to youtube site
 */
function isYoutubeVideo($url) {
    $youtubePattern = '/^https?:\/\/(w{3}\.)?youtube.*$/';
    $urlParsed = parse_url($url);
    $host = $urlParsed['host'];
    $hostAllowed = array('www.youtube.com', 'youtube.com');

    return preg_match($youtubePattern, $url) && in_array($host, $hostAllowed);
}

/**
 * Get the youtube video ID
 */
function getYoutubeVideoId($url) {
    $urlParsed = parse_url($url);
    $queryString = $urlParsed['query'];
    
    if (!is_null($queryString)) {
        parse_str($queryString, $output);
        if (isset($output['v'])) {
            return $output['v'];
        }
    }

    $urlParts = explode('/', $url);
    $videoId = end($urlParts);

    if (isset($videoId)) {
        return $videoId;
    }

    return false;
}

/**
 * Check if url belong to vimeo site
 */
function isVimeoVideo($url) {
    $vimeoPattern = '/^https?:\/\/(w{3}\.)?vimeo.*$/';
    $urlParsed = parse_url($url);
    $host = $urlParsed['host'];

    return preg_match($vimeoPattern, $url) && $host === 'vimeo.com';
}

/**
 * Get the vimeo video id
 */
function getVimeoVideoId($url) {
    $urlParts = explode('/', $url);
    $videoId = end($urlParts);

    if (isset($videoId)) {
        return $videoId;
    }

    return false;
}

/**
 * Get the thumbnail youtube video
 */
function getYoutubeThumbnailFromURL($videId) {
    $urlPattern = 'https://img.youtube.com/vi/<ID>/0.jpg';
    $thumbnailURL = str_replace('<ID>', $videId, $urlPattern);

    return $thumbnailURL;
}

/**
 * Get the thumbnail vimeo video
 */
function getVimeoThumbnailFromURL($videId) {
    $urlPattern = 'http://vimeo.com/api/v2/video/<ID>.json';
    $defaultURL = 'https://img.youtube.com/vi/NOT_FOUND/default.jpg';
    $thumbnailURL = str_replace('<ID>', $videId, $urlPattern);
    $response = @file_get_contents($thumbnailURL);

    if ($response) {
        $jsonResponse = json_decode($response);
        $vimeoResponse = end($jsonResponse);
        $thumbnailURL = $vimeoResponse->thumbnail_large;
        return stripslashes($thumbnailURL);
    }

    return $defaultURL;
}

/**
 * Get the video thumbnail from the video ID
 */
function getThumbnailURL($url) {
    $videoId = getVideoIdFromURL($url);

    if (isYoutubeVideo($url)) {
        return getYoutubeThumbnailFromURL($videoId);
    }

    if (isVimeoVideo($url)) {
        return getVimeoThumbnailFromURL($videoId);
    }

    return $videoId;
}

/**
 * Get the video id from the URL
 */
function getVideoIdFromURL($url) {
    if (is_null($url)) {
        return false;
    }

    if (isYoutubeVideo($url)) {
        return getYoutubeVideoId($url);
    }

    if (isVimeoVideo($url)) {
        return getVimeoVideoId($url);
    }

    return false;
}

add_filter('rwmb_meta_boxes', 'RegisterMetaboxesInPackage');

function getFeatureCategories() {
    global $categories, $currentLanguage;
    $categoryFeatures = array();

    if ($currentLanguage) {
        $categoriesByLang = $categories[strtoupper($currentLanguage)];
        
        foreach($categoriesByLang as $categoryName => $category) {
            if (isset($category['is_feature'])) {
                $categoryFeatures[$categoryName] = $category['slug'];
            }
        }
    }

    return $categoryFeatures;
}

function renderFeaturesButtons() {
    $categories = getFeatureCategories();
    $counter = 0;

    if (count($categories) === 0) {
        return '';
    }

    foreach($categories as $categoryName => $slug) {
        $checked = $counter === 0 ? 'checked' : '';
        $actived = $counter === 0 ? 'active' : '';
        echo "<label class='btn btn-primary {$actived}'><input type='radio' name='category' class='category-radio' {$checked} value='{$slug}'>{$categoryName}</label>";
        $counter++;
    }    
}

function renderFeaturesProducts() {
    $categories = getFeatureCategories();

    if (is_null($categories) || empty($categories)) {
        return;
    }

    $categoriesValues = array_values($categories);
    $category = array_shift($categoriesValues);

    $posts = loadProductsFromCategory($category);

    foreach($posts as $post) {
        echo $post;
    }
}

/**
 * Generate custom categories for Spanish, English and portuguese categories
 */
function createCustomCategories() {
    global $categoryNamespace, $categories, $translation, $services, $packages;

    // register taxonomy category
    register_taxonomy(
        $categoryNamespace,
        array($services, $packages),
        array(
            'label' => $translation['CUSTOM_CATEGORY_NAME'],
            'rewrite' => array( 'slug' => 'category' ),
            'hierarchical' => true,
        )
    );

    foreach($categories as $lang => $category) {
        $langToLower = strtolower($lang);
        foreach($category as $category_name => $attributes) {
            $term = wp_insert_term($category_name, $categoryNamespace, array(
                'description' => $attributes['description'],
                'slug' => $attributes['slug']
            ));
            
            if (isset($term['term_id'])) {
                $category_id = $term['term_id'];

                if(function_exists('pll_set_term_language')) {
                    // with this function we can register a term id to specific lang
                    pll_set_term_language($category_id, $langToLower);
                }
            }
        }
    }
}

function registerDefaultsConfigTheme() {
    global $domain;
    // translate available into custom theme
    load_theme_textdomain( $domain );
    createCustomCategories();
    // register strings to be translated
    registerStringsToTranslate();
}

add_action('after_switch_theme', 'registerDefaultsConfigTheme');

/**
 * Render custom title for front end page
 */
function renderTitle($title, $slogan, $classes = array()) {
    $classesJoined = join(" ", $classes);

    include (get_template_directory() . "/content-title.php");
}

/**
 * Change footer for wordpress admin panel
 */
function alter_footer_admin() {
    add_filter( 'admin_footer_text', 'custom_machinesoft_footer', 11 );
}

function custom_machinesoft_footer($content) {
    // Here we can chang the footer once logged into wordpress panel
    return $content;
}

add_action( 'admin_init', 'alter_footer_admin' );

/**
 * Add new image size name for options in Library Media Image into wordpress admin panel
 */
function set_new_image_size( $sizes ) {
    global $serviceImageLabel;
    $custom_sizes = array(
        $serviceImageLabel => 'Service Image Category'
    );

    return array_merge( $sizes, $custom_sizes );
}

add_filter( 'image_size_names_choose', 'set_new_image_size' );


/**
 * Checker before upload the image on banners and services post type
 */
function checkImageSize(&$file, $minWidth, $minHeight, $errorMessage) {
    if (isset($file)) {
        $type = $file['type'];
        $tmp = $file['tmp_name'];
        if (strpos($type, 'image') !== false) {
            $imageSize = getimagesize($tmp);
            list($width, $height) = $imageSize;

            if ($width < $minWidth || $height < $minHeight) {
                $message = str_replace(array('$width', '$height', '$currentWidth', '$currentHeight'), array($width, $height, $minWidth, $minHeight), $errorMessage);
                $file['error'] = $message;
            }
        }
    }
}

function checker_image_size( $file ) {
    global $sizes, $sizeBannerName, $translation, $services, $home;
    $message = $translation['CHECKER_IMAGE_SIZE_ERROR_MESSAGE'];
    $currentPostId = $_REQUEST['post_id'];

    if (get_post_type($currentPostId) === $home."_banner") {
        list($minWidth, $minHeight) = $sizes[$sizeBannerName];
        checkImageSize($file, $minWidth, $minHeight, $message);
    }

    if (get_post_type($currentPostId) === $services) {
        list($minWidth, $minHeight) = $sizes[$serviceImageLabel];
        checkImageSize($file, $minWidth, $minHeight, $message);
    }

    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'checker_image_size' );

// add_action( 'wp_ajax_nopriv_' . $serviceActionName, 'load_service_posts' );
// add_action( 'wp_ajax_' . $serviceActionName, 'load_service_posts' );

// function load_service_posts() {
//     global $packages, $wp_query, $categoryNamespace;
//     $page = $_POST['page'];
//     $taxId = $_POST['taxID'];
//     $postsPerPage = get_option('posts_per_page');

//     $args = array('tax_query' => array( 
//             array( 
//                 'taxonomy' => $categoryNamespace,
//                 'field' => 'id', 
//                 'terms' => array($taxId) 
//             )),
//             'post_type' =>  $packages,
//             'post_status' => 'publish',
//             'paged' => $page
//             );

//     $posts = query_posts($args);

//     $total = $wp_query->found_posts;

//     $haveMore = ($page + 1) < ceil($total / $postsPerPage) ? true : false;

//     if (have_posts()) {
//         $result = array();

//         while(have_posts()) {
//             the_post();
//             $grid = load_template_part($post, 'content-template-package.php');
//             array_push($result, $grid);
//         }
//     }

//     $response = array(
//         'packages' => $result,
//         'more' => $haveMore
//     );

//     wp_send_json_success($response);

//     die();
// }

function load_template_part($comment, $templateName) {
    ob_start();
        include($templateName);
    $template = ob_get_contents();
    ob_end_clean();
    return $template;
}

/**
 * Load product from category name
 */
function loadProductsFromCategory($category, $limit = 5) {
    global $packages;
    $html = array();

    $args = array(
        'post_type' => $packages,
        'antours-category' => $category,
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'orderby' => 'date'
    );

    $posts = new WP_Query($args);

    if ($posts->have_posts()) {
        while($posts->have_posts()) {
            $posts->the_post();
            ob_start();
                $currentHTML = makeProductWidget();
            ob_end_clean();
            array_push($html, $currentHTML);
        }
    } else {
        ob_start();
            $currentHTML = renderEmptySearch();
        ob_end_clean();
        array_push($html, $currentHTML);
    }

    return $html;
}

/**
 * Show nav pagination for paginate posts
 */
function show_wp_paginate($paged, $max_num_pages) {
    $links = paginate_links(array(
        'base' => str_replace('%_%', 1 == $paged ? '' : "?page=%#%", "?page=%#%"),
        'format' => '?page=%#%',
        'total' => $max_num_pages,
        'current' => intval($paged),
        'type' => 'list',
        'mid_size' => 3,
        'show_all' => false,
        'next_text' => '<i class="fa fa-chevron-right"></i>',
        'prev_text' => '<i class="fa fa-chevron-left"></i>'
    ));

    $wrapper = "<div class='wrapper-paginate text-right'>{$links}</div>";

    echo $wrapper;
}

/* HERE TO APPLY FILTER FROM THEME */
function filter_by_antours_category(&$query){
    global $packages, $categoryNamespace;
    if (is_post_type_archive($packages)) {
        $categoryName = $_GET['category'];
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if (isset($categoryName) && !empty($categoryName)) {
            $query->set( 'tax_query', array(
                array(
                    'taxonomy' => $categoryNamespace,
                    'field' => 'slug',
                    'terms' => $categoryName
                )
            ) );
        }
        $query->set('paged', $page);
    }
}
add_action( 'pre_get_posts', 'filter_by_antours_category' ); 

/* SELECT CATEGORY FILTER BUILDER */
function buildFilter($selectCssClasses = array(), $optionCssClasses = array(), $default = "choose an option") {
    global $categoryNamespace;
    $selectNameField = "category";
    $selected = null;

    if (isset($_GET[$selectNameField])) {
        $selected = $_GET[$selectNameField];
    }

    if (is_array($selectCssClasses) && isset($selectCssClasses)) {
        $selectCssClasses = implode(" ", $selectCssClasses);
    }

    if (is_array($optionCssClasses) && isset($optionCssClasses)) {
        $optionCssClasses = implode(" ", $optionCssClasses);
    }

    $categories = get_terms( $categoryNamespace, 'orderby=name&hide_empty=0' );
    $select = array("<select id='filter' name='{$selectNameField}' class='{$selectCssClasses}'>");
    array_push($select, "<option value=''>{$default}</option>");

    foreach($categories as $category) {
        $active = $selected && $selected === $category->slug ? "selected" : "";
        $option = "<option data-id='{$category->term_id}' class='{$optionCssClasses}' value='{$category->slug}' {$active}>{$category->name}</option>";
        array_push($select, $option);
    }

    array_push($select, "</select>");
    $select = implode("", $select);

    return $select;
}
/* SELECT CATEGORY FILTER BUILDER */

function registerStringsToTranslate() {
    if(function_exists('icl_register_string')) {
        // with this function we can register string to be translated
        icl_register_string("antours", "Titulo de Servicio", "Service Title");
        icl_register_string("antours", "Contenido del Servicio", "Service Content");

        icl_register_string("antours", "Titulo de Paquete", "Package Title");
        icl_register_string("antours", "Contenido de Paquete", "Package Content");

        icl_register_string("antours", "Texto por defecto en select de ciudad", "Placeholder select city");
        icl_register_string("antours", "Texto por defecto en select de comuna", "Placeholder select commune");
    }
}

function t($context, $name, $string) {
    if (function_exists('icl_t')) {
        $content = trim(icl_t($context, $name, $string));
        if (!empty($content)) {
            return $content;
        }
    }

    return false;
}

function postExists($post_number) {
    if (!isset($post_number)) {
        throw new Exception('There is not a post id to check');
    }

    $post = get_post($post_number);

    if (is_null($post)) {
        throw new Exception("There is not post with id {$post_number}");
    }

    if ($post->post_status !== 'publish') {
        return false;
    }

    return $post;
}

// add new filter for telephone

add_filter("getTelephoneNumber", "renderAsTelephoneNumber", 10);

function formatNumber($number) {
    $numberFormatted = $number;
    if (preg_match('/^[0-9]{11}$/', $numberFormatted)) {
        $code = substr($numberFormatted, 0 ,2);
        $code = '(+' . $code . ")";
        $numbers = substr($numberFormatted, 2);
        $numberFormatted = $code . " " . $numbers;
    }

    return $numberFormatted;
}

function renderAsTelephoneNumber($number) {
    $numberForRender = formatNumber($number);
    $telAsHTML = "<a href='tel:%s' class='link-telephone'>%s</a>";
    return sprintf($telAsHTML, $number, $numberForRender);
}

// add new filter for email

add_filter("getEmail", "renderAsEmail", 10);

function renderAsEmail($email) {
    $emailAsHTML = "<a href='mailto:%s' class='link-email'>%s</a>";
    return sprintf($emailAsHTML, $email, $email);
}

function call_booking_method($method) {
    if (class_exists("Antours_CarBooking_API")) {
        $args = func_get_args();
        $args = array_slice($args, 1);

        $results = call_user_func_array(array(Antours_CarBooking_API, $method), $args);
        
        if (is_array($results) && count($results) > 0) {
            return $results;
        }
    }

    return false;
}

function generateSelectByMethod($method, $id_name, $name, $attrs) {
    $placeholder = isset($attrs['placeholder']) ? $attrs['placeholder'] : null;
    unset($attrs['placeholder']);

    $attributes = array_map(function($key, $value) {
        return $key . "=" . "'{$value}'";
    }, array_keys($attrs), $attrs);

    $attributes = join(' ', $attributes);

    $select = "<select class='form-control form-control-sm form-control-border t-input-control' id='{$method}' {$attributes}>";
    $selectInput = array($select);

    $default = $placeholder ? "<option selected value=''>{$placeholder}</option>" : '';
    array_push($selectInput, $default);

    if (class_exists("Antours_CarBooking_API")) {
        $args = func_get_args();
        $args = array_slice($args, 4);

        $results = call_booking_method($method, $args);
        
        if (is_array($results)) {
            foreach($results as $index => $item) {
                $option = "<option value='{$item->{$id_name}}' data-name='{$item->{$name}}'>{$item->{$name}}</option>";
                array_push($selectInput, $option);
            }
        }
    }

    array_push($selectInput, "</select>");

    $select = join("", $selectInput);

    return $select;
}

function getDateAs($ts, $format, $returnTS = false) {
    $date = new DateTime();
    $date->setTimestamp($ts / 1000);

    if ($returnTS) {
        return $date->getTimestamp();
    }

    return $date->format($format);
}
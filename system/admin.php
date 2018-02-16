<?php


function settings_on_activate_theme() {
    add_menu_page(
        __("Antours Nosotros", "antours_about_title"),
        __("Antours Nosotros", "antours_about_menu"),
        "manage_options",
        "antours-about",
        "antours_render_about_page",
        "dashicons-groups",
        30
    );
}

add_action('admin_menu', 'settings_on_activate_theme');
add_action('admin_init', 'page_init');

function page_init() {
    register_setting(
        'editor_about_group',
        'editor_about',
        array( $this, 'sanitize' )
    );

    add_settings_section(
        'antours_about_section_page',
        '',
        'antours_render_about_page',
        'antours-about'
    );

    add_settings_field(
        'editor_aboutus',
        '',
        'antours_render_about_page',
        'antours-about',
        'antours_about_section_page'
    );
}

function antours_render_about_page($args) {
    include_once(dirname(__FILE__).'/views/antours-about-template.php');
}

function sanitize($input){
    var_dump($inputs);
    $new_input = array();
    if( isset( $input['id_number'] ) )
        $new_input['id_number'] = absint( $input['id_number'] );

    if( isset( $input['title'] ) )
        $new_input['title'] = sanitize_text_field( $input['title'] );

    return $new_input;
}

?>
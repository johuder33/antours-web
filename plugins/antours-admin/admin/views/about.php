<?php

function wrapper($key) {
    return "antours[".$key."]";
}

$editor_id = "aboutus";
$content = $this->deserializer->get_value($editor_id);

$title_id = "about_title";
$content_title = $this->deserializer->get_value($title_id);
?>

<div class="wrap">
    <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <input name="<?php echo wrapper($title_id); ?>" placeholder="<?php echo __('Ingrese titulo de esta sección', 'antours_about_page_title') ?>" name="antours_aboutus_title" style="font-size: 25px; width: 100%; padding: 10px 5px; margin-bottom: 10px;" value="<?php echo $content_title; ?>" />

        <?php
            wp_editor( $content, "antours_aboutus", $settings = array("textarea_name" => wrapper($editor_id), "drag_drop_upload" => false,"media_buttons" => true, "textarea_rows" => 8, "wpautop" => false) );
            wp_nonce_field( 'acme-settings-save', 'acme-custom-message' );
            submit_button();
        ?>
    </form>
 
</div>
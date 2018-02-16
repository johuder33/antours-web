<?php

class Serializer {
    public function init() {
        add_action( 'admin_post', array($this, 'save') );
    }

    private function redirect() {
        $refer = $_POST['_wp_http_referer'];
        if (!isset($refer)) {
            $refer = wp_login_url();
        }

        $url = sanitize_text_field( wp_unslash($refer) );

        wp_safe_redirect( urldecode($url) );
        exit;
    }

    private function has_valid_nonce() {
        if (!isset($_POST['acme-custom-message'])) {
            return false;
        }

        $field = wp_unslash( $_POST['acme-custom-message'] );
        $action = 'acme-settings-save';

        return wp_verify_nonce($field, $action);
    }
    
    public function save() {
        if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
            // TODO: Display an error message.
        }

        $fields = $_POST['antours'];

        foreach($fields as $field => $value) {
            if (null !== wp_unslash( $value )) {
                update_option($field, $value);
            }
        }

        $this->redirect();
    }
}
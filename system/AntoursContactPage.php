<?php

class AntoursContactPage {
    static public $options = null;
    static public $optionsGroupName = "antours_contact_opts_group";
    static public $optionName = "antours_contact_opts";
    static public $optionPageName = "antours_contact_options_page";
    static public $sectionTitle = "Section Title - Antours Contact Options";
    static public $sectionId = "antours_contact_options_ID";
    static public $sectionName = "antours_contact_section";
    
    // fields names in options
    static public $telephoneFieldName = "telephone";
    static public $emailFieldName = "email";
    static public $fbFieldName = "fb_url";
    static public $twitterFieldName = "twitter_url";
    static public $instagramFieldName = "instagram_url";

    private $defaultCode = 56;

    // enabled country codes
    public $codes = array(
        "56" => array(
            "code" => 56,
            "min" => 9
        )
    );

    public function __construct() {
        //Create the link into menu to the antours options
        add_action("admin_menu", array($this, "add_menu_option_page"));
        add_action("admin_init", array($this, "antours_options_init"));
    }

    public function antours_options_init() {
        // let's register the options where we gonna handle the data
        register_setting(
            self::$optionsGroupName,
            self::$optionName,
            array($this, "sanitizer")
        );

        add_settings_section(
            self::$sectionId,
            self::$sectionTitle,
            array( $this, "render_section_information" ),
            self::$optionPageName
        );

        // telephone field, clonable => true
        $fieldName = self::$telephoneFieldName;
        add_settings_field(
            "contact_telephone_field",
            "Telephone",
            array( $this, "render_clonable_field" ),
            self::$optionPageName,
            self::$sectionId,
            array(
                "name" => self::$optionName . "[{$fieldName}][]",
                "key" => $fieldName,
                "type" => "tel",
                "cssClasses" => array(
                    "telephone_field",
                    "antours_option_field"
                ),
                "placeholder" => "Phone number",
                "button" => array(
                    "cssClass" => array("button", "button-primary", "asBlock"),
                    "label" => "Add Telephone",
                    "id" => "clon_telephone_field"
                )
            )
        );

        // email field, clonable => true
        $fieldName = self::$emailFieldName;
        add_settings_field(
            "contact_email_field",
            "Email",
            array( $this, "render_clonable_field" ),
            self::$optionPageName,
            self::$sectionId,
            array(
                "name" => self::$optionName . "[{$fieldName}][]",
                "key" => $fieldName,
                "type" => "email",
                "cssClasses" => array(
                    "email_field",
                    "antours_option_field"
                ),
                "placeholder" => "Email Address",
                "button" => array(
                    "cssClass" => array("button", "button-primary", "asBlock"),
                    "label" => "Add Email",
                    "id" => "clon_email_field"
                )
            )
        );

        // facebook url field, clonable => false
        $fieldName = self::$fbFieldName;
        add_settings_field(
            "contact_fb_url_field",
            "Facebook Link",
            array( $this, "render_social_network_field" ),
            self::$optionPageName,
            self::$sectionId,
            array(
                "name" => self::$optionName . "[{$fieldName}]",
                "key" => $fieldName,
                "cssClasses" => array("w-50"),
                "placeholder" => "Facebook URL"
            )
        );

        // twiiter url field, clonable => false
        $fieldName = self::$twitterFieldName;
        add_settings_field(
            "contact_twitter_url_field",
            "Twitter Link",
            array( $this, "render_social_network_field" ),
            self::$optionPageName,
            self::$sectionId,
            array(
                "name" => self::$optionName . "[{$fieldName}]",
                "key" => $fieldName,
                "cssClasses" => array("w-50"),
                "placeholder" => "Twitter URL"
            )
        );

        // Instagram url field, clonable => false
        $fieldName = self::$instagramFieldName;
        add_settings_field(
            "contact_instagram_url_field",
            "Instagram Link",
            array( $this, "render_social_network_field" ),
            self::$optionPageName,
            self::$sectionId,
            array(
                "name" => self::$optionName . "[{$fieldName}]",
                "key" => $fieldName,
                "cssClasses" => array("w-50"),
                "placeholder" => "Instagram URL"
            )
        );
    }

    public function render_clonable_field($args) {
        $name = $args["name"];
        $key = $args["key"];
        $type = $args["type"];
        $placeholder = $args["placeholder"];

        $cssClass = $args["cssClasses"];
        $cssClass = isset($cssClass) && count($cssClass) > 0 ? implode(" ", $cssClass) : '';
        
        $button = $args['button'];
        $button = isset($button) && is_array($button) && count($button) > 0 ? $button : false;

        if ($button) {
            $buttonHTML = "<button type='button' id='%s' class='%s' >%s</button>";
            $buttonCssClass = $button['cssClass'];
            $buttonCssClass = isset($buttonCssClass) && count($buttonCssClass) > 0 ? implode(" ", $buttonCssClass) : "";
            $label = $button['label'];
            $id = $button['id'];
        }

        $inputHTML = "<input type='%s' name='%s' value='%s' class='%s' placeholder='%s' />";
        $inputHTMLClonable = array("key" => $key, "name" => $name, "type" => $type, "class" => $cssClass, "placeholder" => $placeholder);

        $fields_values = self::$options[$key];

        if (isset($fields_values) && count($fields_values) > 0) {
            echo "<div class='container-fields container-{$key}'>";
            foreach($fields_values as $index => $value) {
                printf($inputHTML, $type, $name, $value, $cssClass, $placeholder );
            }
            echo "</div>";
        } else {
            printf($inputHTML, $type, $name, $value, $cssClass, $placeholder );
        }

        if ($button) {
            $inputHTMLClonable = json_encode($inputHTMLClonable);
            $hiddenId = $id . "_hidden";
            echo "<div class='container-button-clonable'>";
            echo "<input type='hidden' id='{$hiddenId}' data-field='{$inputHTMLClonable}' />";
            printf($buttonHTML, $id, $buttonCssClass, $label);
            echo "</div>";
        }
    }

    public function render_social_network_field($args) {
        $name = $args["name"];
        $key = $args["key"];
        $placeholder = $args["placeholder"];
        $value = self::$options[$key];
        $cssClasses = $args["cssClasses"];
        $cssClasses = isset($cssClasses) && is_array($cssClasses) && count($cssClasses) > 0 ? implode(" ", $cssClasses) : "";

        printf("<input type='url' name='%s' value='%s' class='%s' placeholder='%s' />", $name, $value, $cssClasses, $placeholder);
    }

    public function render_section_information() {
        echo "";
    }

    private function addCountryCode($number) {
        $telephoneNumber = $number;

        if (!$this->hasCountryCode($number)) {
            $code = $this->defaultCode;
            if ($this->hasMinNumbers($number, $code)) {
                $codeObject = $this->codes[$code];
                $telephoneNumber = $codeObject["code"] . $telephoneNumber;
            }
        }

        return $telephoneNumber;
    }

    private function hasCountryCode($number) {
        $code = substr($number, 0, 2);
        $phoneNumber = substr($number, 2);
        $codeObject = $this->codes[$code];
        
        return is_array($codeObject) && $this->hasMinNumbers($number);
    }

    private function hasMinNumbers($number, $hasCode = false) {
        $code = $hasCode ? $hasCode : substr($number, 0, 2);
        $startFrom = $hasCode ? 0 : 2;
        $phoneNumber = substr($number, $startFrom);
        $codeObject = $this->codes[$code];

        return is_array($codeObject) && strlen($phoneNumber) === $codeObject['min'];
    }

    public function sanitizer($input) {
        // make our sanitize text from input
        $filter = array();

        // check for correct phone number
        $telephones = $input[self::$telephoneFieldName];
        unset($input[self::$telephoneFieldName]);

        if (isset($telephones) && is_array($telephones) && count($telephones) > 0) {
            foreach($telephones as $index => $telephone) {
                $item = trim($telephone);
                if (!empty($item)) {
                    if (filter_var($item, FILTER_VALIDATE_INT)) {
                        if (!isset($filter[self::$telephoneFieldName])) {
                            $filter[self::$telephoneFieldName] = array();
                        }

                        array_push($filter[self::$telephoneFieldName], $this->addCountryCode($item));
                    }
                }
            }
        }

        // check for correct emails
        $emails = $input[self::$emailFieldName];
        unset($input[self::$emailFieldName]);

        if (isset($emails) && is_array($emails) && count($emails) > 0) {
            foreach($emails as $index => $email) {
                $item = trim($email);
                if (!empty($item)) {
                    if (filter_var($item, FILTER_VALIDATE_EMAIL)) {
                        if (!isset($filter[self::$emailFieldName])) {
                            $filter[self::$emailFieldName] = array();
                        }

                        array_push($filter[self::$emailFieldName], $item);
                    }   
                }
            }
        }

        // check url for facebook, twitter, instagram
        foreach($input as $keyname => $url) {
            $url_address = trim($url);
            if (!empty($url_address) && filter_var($url_address, FILTER_VALIDATE_URL)) {
                $filter[$keyname] = $url_address;
            }
        }

        return $filter;
    }

    public function add_menu_option_page() {
        add_menu_page(
            "Antours Contact Options", // page title
            "Antours Contact Options", // menu link title
            "manage_options", // grants for each user
            "antours_contact_options", // slug for the page
            array( $this, "render_contact_options_view" ) // callback to render the form
            // icon name or url,
            // position into menu
        );
    }

    public function render_contact_options_view() {
        // save ref for the current option registered before
        self::$options = get_option(self::$optionName);
        ?>
            <div class="wrap">
                <h1><?php echo self::$sectionTitle; ?></h1>
                <form method="post" action="options.php">
                    <?php
                        settings_fields( self::$optionsGroupName );
                        do_settings_sections(self::$optionPageName);
                        submit_button();
                    ?>
                </form>
            </div>
        <?php
    }

    static public function getOptionOf($fieldName) {
        $options = self::$options;

        if (!$options) {
            $options = get_option(self::$optionName);
        }

        return $options[$fieldName];
    }

    static public function getTelephones() {
        $keyname = AntoursContactPage::$telephoneFieldName;
        $telephones = AntoursContactPage::getOptionOf($keyname);

        $telephonesToReturn = array();

        if (is_array($telephones) && count($telephones) > 0) {
            $telephones = array_map( function($number) { return apply_filters( 'getTelephoneNumber', $number, 2, "clase" ); } , $telephones);
            $telephonesToReturn = array_merge($telephonesToReturn, $telephones);
        }

        return $telephonesToReturn;
    }

    static public function getEmails() {
        $keyname = AntoursContactPage::$emailFieldName;
        $emails = AntoursContactPage::getOptionOf($keyname);

        $emailsToReturn = array();

        if (is_array($emails) && count($emails) > 0) {
            $emails = array_map( function($email) { return apply_filters( 'getEmail', $email ); } , $emails);
            $emailsToReturn = array_merge($emailsToReturn, $emails);
        }

        return $emails;
    }

    static public function renderInformation() {
        $telephones = AntoursContactPage::getTelephones();
        $emails = AntoursContactPage::getEmails();
        $results = array_merge($telephones, $emails);

        if (count($results) > 0) {
            echo "<div>Contacto</div>";
            foreach($results as $index => $value) {
                $row = "<div>%s</div>";
                $row = sprintf($row, $value);
                echo $row;
            }
        }
    }

    static public function getSocialNetworkLinks() {
        $socialNetworks = array(
            "facebook" => AntoursContactPage::$fbFieldName,
            "twitter" => AntoursContactPage::$twitterFieldName,
            "instagram" => AntoursContactPage::$instagramFieldName
        );

        $links = array();
        $icon = "<i class='fa fa-%s fa' aria-hidden='true'></i>";
        
        foreach($socialNetworks as $networkName => $key) {
            $URL = AntoursContactPage::getOptionOf($key);

            if (!empty($URL) && isset($URL)) {
                $iconFormatted = sprintf($icon, $networkName);
                $link = "<a href='%s' class='social-link' target='_blank'>%s</a>";
                $link = sprintf($link, $URL, $iconFormatted);
                array_push($links, $link);
            }
        }

        if (count($links) > 0) {
            $links = implode("", $links);

            echo $links;
        }
    }
}

// initialize only if user logged if admin
if( is_admin() ) {
    $AntoursOptionsPager = new AntoursContactPage();
}
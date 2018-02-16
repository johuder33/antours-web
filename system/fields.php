<?php

class Antours_Languages_Handler {
    private $languages = array(
        'es' => 'español',
        'en' => 'ingles',
        'pt' => 'portugues'
    );

    public static $translations = array(
        'es' => 'es_CL',
        'en' => 'en_US',
        'pt' => 'pt_PT'
    );

    public static $prefix = "antours";

    private $sections = array(
        'services' => array(
            'es' => 'servicios',
            'en' => 'services',
            'pt' => 'servicos'
        ),
        'packages' => array(
            'es' => 'paquetes',
            'en' => 'packages',
            'pt' => 'pacotes'
        ),
        'about' => array(
            'es' => 'nosotros',
            'en' => 'about',
            'pt' => 'sobre-nos'
        ),
    );

    private $fields = array();

    public $currentLang;

    public function generateLabels($section) {
        $labels = array(
            'name' => __('menu_name', 'antours'),
            'singular_name' => __('menu_singular_name', 'antours'),
            'add_new' => __('menu_add_new_name', 'antours'),
            'not_found' => __('menu_not_found', 'antours'),
            'all_items' => __('menu_all_items', 'antours'),
            'add_new_item' => __('menu_add_new_item', 'antours')
        );

        return $labels;
    }

    function __construct($lang) {
        $this->changeLang($lang);
    }

    public function changeLang($lang) {
        $this->currentLang = $lang;

        $_SESSION['lang'] = $this->currentLang;
    }

    public function registerField($fieldName) {
        if(!isset($this->fields[$fieldName])) {
            $this->fields[$fieldName] = $this->registerFieldWithLanguage($fieldName);
        }
    }

    public function getFields($fieldName) {
        if (isset($this->fields[$fieldName])) {
            return $this->fields[$fieldName];
        }

        return false;
    }

    public function getPostTypesFromSection($section) {
        $currentSection = $this->sections[$section];
        if (isset($currentSection)) {
            $posttypes = array();
            foreach($currentSection as $lang => $posttype) {
                array_push($posttypes, $posttype);
            }

            return $posttypes;
        }

        return false;
    }

    public function getSection($section) {
        $current = $this->sections[$section];

        if (isset($current)) {
            return $current;
        }

        return false;
    }

    public static function getLangFromSite() {
        if (isset($_GET['lang'])) {
            return $_GET['lang'];
        }

        if (isset($_SESSION['lang'])) {
            return $_SESSION['lang'];
        }

        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0 ,2);
    }

    private function registerFieldWithLanguage($fieldName) {
        $fields = array();
        foreach($this->languages as $key) {
            $language = $fieldName."_".$key;
            array_push($fields, $language);
        }

        return $fields;
    }

    public function registerPT($sectionName, $args) {
        $sections = $this->getSection($sectionName);
        $tex = array(
            'es' => array('category-service-spanish'),
            'en' => array('category-service-english'),
            'pt' => array('category-service-portuguese')
        );

        if($sections) {
            foreach($sections as $lang => $section) {
                $args['taxonomies'] = $tex[$lang];
                register_post_type($section, $args);
            }
        }
    }
}
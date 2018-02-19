<?php

// let's check if "WP_List_Table" class is already loaded, if not just load it.
if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Reservation_List extends WP_List_Table {
    public static $per_page = 10;
    public static $empty_text = 'N/A';
    public function __construct() {
        parent::__construct(
            [
                'singular' => __('Customer', 'sp'),
                'plural' => __('Customers', 'sp'),
                'ajax' => false
            ]
        );
    }

    public static function get_reservations($per_page = null, $page = 1) {
        global $wpdb;
        $per_page = !is_null($per_page) ? $per_page : self::$per_page;

        $tablename = Configuration::getTableName();

        $query = "SELECT * FROM {$tablename}";
        $orderBy = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : '';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : '';

        if(!empty($orderBy)) {
            $query .= ' ORDER BY ' . esc_sql($orderBy);
            $query .= !empty($order) ? ' ' . esc_sql($order) : ' ASC';
        }

        $query .= " LIMIT {$per_page}";
        $query .= " OFFSET " . ($page - 1) * $per_page;

        $results = $wpdb->get_results($query, 'ARRAY_A');

        return $results;
    }

    public static function get_reservations_count() {
        global $wpdb;

        $tablename = Configuration::getTableName();

        $query = "SELECT COUNT(*) FROM {$tablename}";

        return $wpdb->get_var( $query );
    }

    public function no_items() {
        Configuration::printTranslation('no_reservation_list_data');
    }

    public function column_fullname($item) {
        return $item['customer_fullname'];
    }

    public function column_phone($item) {
        return $item['customer_phone'];
    }

    public function column_email($item) {
        return $item['customer_email'];
    }

    public function column_passengers($item) {
        return $item['amount_passengers'];
    }
    
    public function column_created_at($item) {
        $timestamp = isset($item['updated_at']) ? date('j/m/Y H:i:s', strtotime($item['updated_at'])) : self::$empty_text;
        return $timestamp;
    }

    public function column_default($item, $column_name) {
        return 'nothing by default';
    }

    public function get_columns() {
        $columns = [
            'fullname' => 'Cliente',
            'phone' => 'Teléfono',
            'email' => 'Correo',
            'passengers' => 'Total de pasajeros',
            'created_at' => 'Fecha de solicitud'
        ];

        return $columns;
    }

    public function prepare_items() {
        $this->_column_headers = $this->get_column_info();
        $this->process_bulk_action();

        $per_page = $this->get_items_per_page('reservation_per_page', self::$per_page);
        $current_page = $this->get_pagenum();
        $total_items = self::get_reservations_count();

        $this->set_pagination_args(
            [
                'total_items' => $total_items,
                'per_page' => $per_page
            ]
        );

        $this->items = self::get_reservations($per_page, $current_page);
    }
}
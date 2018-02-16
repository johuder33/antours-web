<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Reservation_List_Table extends WP_List_Table {
    public $found_data = null;
    private $title = null;
    private $reservationInstance = null;

    function __construct($reservationManager, $title){
            $this->title = $title;
            $this->reservationInstance = $reservationManager;

            parent::__construct($args);
            add_action( 'admin_head', array( $this, 'admin_header' ) );
    }

    function admin_header() {
        $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
            if( 'reservation' != $page )
        echo '<style type="text/css">';
        echo '.wp-list-table .column-id { width: 5%; }';
        echo '.wp-list-table .column-booktitle { width: 40%; }';
        echo '.wp-list-table .column-author { width: 35%; }';
        echo '.wp-list-table .column-isbn { width: 20%;}';
        echo '</style>';
    }

    function no_items() {
        global $message;
        $message = __( "No reservation yet", "domain" );
        $not_fount_view = load_template(__DIR__ . "/../views/not_found_items.php");
    }

    /*
    * Custom Function to render table title
    */
    function renderTitle() {
        $title = $this->title;

        echo "<div class='wrap'><div class='antours-reservation-title-table'><h1>{$title}</h1></div>";
    }

    /*
    * Custom Function to render table into form
    */
    function renderTable() {
        $this->renderTitle();

        echo "
                <form method='post'>
                <input type='hidden' name='page' value='test_list_table'>
        ";

        $this->search_box( 'search', 'search_id' );
        $this->display();

        echo '</form></div>';
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'customer_fullname'  => array('customer_fullname',false),
            'customer_phone' => array('customer_phone',false),
            'customer_email'   => array('customer_email',false),
            'cutomer_rut'   => array('cutomer_rut',false)
        );
        return $sortable_columns;
    }

    function get_columns(){
        global $domain;
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'customer_fullname' => __( 'Reservation Customer Fullname', $domain ),
            'customer_phone'    => __( 'Reservation Customer Phone', $domain ),
            'customer_email'    => __( 'Reservation Customer Email', $domain ),
            'customer_rut'    => __( 'Reservation Customer RUT', $domain )
        );
        return $columns;
    }

    function usort_reorder( $a, $b ) {
        // If no sort, default to title
        $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'booktitle';
        // If no order, default to asc
        $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
        // Determine sort order
        $result = strcmp( $a[$orderby], $b[$orderby] );
        // Send final sort direction to usort
        return ( $order === 'asc' ) ? $result : -$result;
    }

    function column_customer_fullname($item){
        $id = $item['id_reservation'];
        $customerName = $item['customer_fullname'];
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&reservation=%s">Ver</a>', "reservation_view", 'edit', $id)
        );
        return sprintf('%1$s %2$s', $customerName, $this->row_actions($actions) );
    }

    function column_customer_phone($item){
        $phone = $item['customer_phone'] ? $item['customer_phone'] : __("N/A", "antours");
        $actions = array();
        return sprintf('%1$s %2$s', $phone, $this->row_actions($actions) );
    }

    function column_customer_email($item) {
        $email = $item['customer_email'];
        $actions = array();
        return sprintf('%1$s %2$s', $email, $this->row_actions($actions) );
    }

    function column_customer_rut($item) {
        $rut = $item['customer_rut'];
        $actions = array();
        return sprintf('%1$s %2$s', $rut, $this->row_actions($actions) );
    }

    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }

    function column_cb($item) {
        $id = $item['id_reservation'];
        return sprintf(
            '<input type="checkbox" name="reservation[]" value="%s" />', $id
        );    
    }

    function prepare_items() {
        $reservation = $this->reservationInstance;
        
        $total_items = $reservation->getCountItems();
        $items_per_page = get_option("posts_per_page");
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $items_per_page;

        $items = $reservation->get($items_per_page, $offset, ARRAY_A);

        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        // only ncessary because we have sample data
        $this->found_data = $items;

        $this->set_pagination_args( array(
            'total_items' => $total_items,   //WE have to calculate the total number of items
            'per_page'    => $items_per_page //WE have to determine how many items to show on a page
        ) );

        $this->items = $this->found_data;
    }
} //class
<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Antours_List_Table extends WP_List_Table {
    public $found_data = null;

    function __construct(){
            parent::__construct($args);
            add_action( 'admin_head', array( $this, 'admin_header' ) );
    }

    function admin_header() {
        /*$page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
            if( 'my_list_test' != $page )
            return;
        echo '<style type="text/css">';
        echo '.wp-list-table .column-id { width: 5%; }';
        echo '.wp-list-table .column-booktitle { width: 40%; }';
        echo '.wp-list-table .column-author { width: 35%; }';
        echo '.wp-list-table .column-isbn { width: 20%;}';
        echo '</style>'*/
    }

    function no_items() {
        global $message;
        $message = __( 'No books found, dude.' );
        $not_fount_view = load_template(__DIR__ . "/../views/Antours_List_Table/not_found_items.php");
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'user'  => array('user',false),
            'start_date' => array('start_date',false),
            'phone'   => array('phone',false),
            'email'   => array('email',false)
        );
        return $sortable_columns;
    }

    function get_columns(){
        global $domain;
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'user' => __( 'User CarBooking', $domain ),
            'start_date'    => __( 'Start Date CarBooking', $domain ),
            'phone'    => __( 'Phone CarBooking', $domain ),
            'email'    => __( 'Email User CarBooking', $domain )
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

    function column_booktitle($item){
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&book=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
            'delete' => sprintf('<a href="?page=%s&action=%s&book=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID'])
        );
        return sprintf('%1$s %2$s', $item['booktitle'], $this->row_actions($actions) );
    }

    function column_author($item){
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&book=%s">Ja Weno</a>',$_REQUEST['page'],'edit',$item['ID'])
        );
        return sprintf('%1$s %2$s', $item['author'], $this->row_actions($actions) );
    }

    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }

    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="book[]" value="%s" />', $item['ID']
        );    
    }

    function prepare_items() {
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );
        $data = array(
            array(
                'booktitle' => 'titulo',
                'author' => 'yode',
                'isbn' => '121282368'
            ),
        );
        usort( $data, array( &$this, 'usort_reorder' ) );
        
        $per_page = 5;
        $current_page = $this->get_pagenum();
        $total_items = count( $data );
        // only ncessary because we have sample data
        $this->found_data = array_slice( $data,( ( $current_page-1 )* $per_page ), $per_page );

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page                     //WE have to determine how many items to show on a page
        ) );
        $this->items = array();
    }
} //class
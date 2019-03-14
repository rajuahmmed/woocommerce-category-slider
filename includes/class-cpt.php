<?php

/**
 * Class WC_Category_Slider_CPT
 */

class WC_Category_Slider_CPT {

    protected $slug;

    /**
     * CPT constructor.
     *
     */
    public function __construct() {
        $this->slug = 'wc_category_slider';
        add_action( 'init', array( $this, 'register_shortcode_post' ), 0 );
        add_filter( 'manage_' . $this->slug . '_posts_columns', array( $this, 'set_shortocode_column' ) );
        add_filter( 'manage_' . $this->slug . '_posts_custom_column', array( $this, 'shortocode_column_data' ), 10, 2 );
    }

    /**
     * Register post type
     */
    public function register_shortcode_post() {
        $labels = array(
            'name'               => _x( 'WooCommerce Category Slider Shortcode', 'post type general name', 'wc_category_slider' ),
            'singular_name'      => _x( 'WooCommerce Category Slider', 'post type singular name', 'wc_category_slider' ),
            'menu_name'          => _x( 'WC Cat Slider', 'admin menu', 'wc_category_slider' ),
            'name_admin_bar'     => _x( 'WooCommerce Category Slider', 'add new on admin bar', 'wc_category_slider' ),
            'add_new'            => _x( 'Add New', 'book', 'wc_category_slider' ),
            'add_new_item'       => __( 'Add New Slider', 'wc_category_slider' ),
            'new_item'           => __( 'New Slider', 'wc_category_slider' ),
            'edit_item'          => __( 'Edit Slider', 'wc_category_slider' ),
            'view_item'          => __( 'View Slider', 'wc_category_slider' ),
            'all_items'          => __( 'All Sliders', 'wc_category_slider' ),
            'search_items'       => __( 'Search Slider', 'wc_category_slider' ),
            'parent_item_colon'  => __( 'Parent Slider:', 'wc_category_slider' ),
            'not_found'          => __( 'No Slider found.', 'wc_category_slider' ),
            'not_found_in_trash' => __( 'No Slider found in Trash.', 'wc_category_slider' )
        );

        $args = array(
            'labels'                => $labels,
            'description'           => __( 'Description.', 'wc_category_slider' ),
            'public'                => false,
            'publicly_queryable'    => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'can_export'            => true,
            'capability_type'       => 'post',
            'has_archive'           => false,
            'hierarchical'          => false,
            'menu_position'         => null,
            'menu_icon'             => 'dashicons-images-alt',
            'supports'              => array( 'title' ),
            'show_in_rest'          => true,
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        );

        register_post_type( $this->slug, $args );
    }

    /**
     * Register shortcode column
     *
     * @param $columns
     *
     * @return mixed
     */
    public function set_shortocode_column( $columns ) {
        unset( $columns['date'] );
        $columns['shortcode'] = __( 'Shortcode', 'wc_category_slider' );
        $columns['date']      = __( 'Date', 'wc_category_slider' );

        return $columns;
    }

    /**
     * show shortcode column data
     *
     * @param $column
     * @param $post_id
     */
    public function shortocode_column_data( $column, $post_id ) {
        switch ( $column ) {

            case 'shortcode' :
                echo "<code>[woo_category_slider id='{$post_id}']</code>";
                break;

        }

    }
}

new WC_Category_Slider_CPT();

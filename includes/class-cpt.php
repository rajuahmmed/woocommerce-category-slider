<?php

namespace Pluginever\WCS;
/**
 * Class CPT
 *
 * @since 1.2.4
 * @package Pluginever\WCS
 */
class CPT {
    protected $slug;

    /**
     * CPT constructor.
     *
     */
    public function __construct() {
        $this->slug = 'woocatslider';
        add_action( 'init', array( $this, 'register_shortcode_post' ), 0 );
        add_filter( 'manage_woocatslider_posts_columns', array( $this, 'set_shortocode_column' ) );
        add_filter( 'manage_woocatslider_posts_custom_column', array( $this, 'shortocode_column_data' ), 10, 2 );
    }


    public function register_shortcode_post() {
        $labels = array(
            'name'               => _x( 'Woo Category Slider Shortcode', 'post type general name', 'woocatslider' ),
            'singular_name'      => _x( 'Woo Category Slider', 'post type singular name', 'woocatslider' ),
            'menu_name'          => _x( 'Woo Cat Slider', 'admin menu', 'woocatslider' ),
            'name_admin_bar'     => _x( 'Woo Category Slider', 'add new on admin bar', 'woocatslider' ),
            'add_new'            => _x( 'Add New', 'book', 'woocatslider' ),
            'add_new_item'       => __( 'Add New Slider', 'woocatslider' ),
            'new_item'           => __( 'New Slider', 'woocatslider' ),
            'edit_item'          => __( 'Edit Slider', 'woocatslider' ),
            'view_item'          => __( 'View Slider', 'woocatslider' ),
            'all_items'          => __( 'All Sliders', 'woocatslider' ),
            'search_items'       => __( 'Search Slider', 'woocatslider' ),
            'parent_item_colon'  => __( 'Parent Slider:', 'woocatslider' ),
            'not_found'          => __( 'No Slider found.', 'woocatslider' ),
            'not_found_in_trash' => __( 'No Slider found in Trash.', 'woocatslider' )
        );

        $args = array(
            'labels'                => $labels,
            'description'           => __( 'Description.', 'woocatslider' ),
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


    public function set_shortocode_column( $columns ) {
        unset( $columns['date'] );
        $columns['shortcode'] = __( 'Shortcode', 'woocatslider' );
        $columns['date']      = __( 'Date', 'woocatslider' );

        return $columns;
    }

    public function shortocode_column_data( $column, $post_id ) {
        switch ( $column ) {

            case 'shortcode' :
                echo "<code>[woo_category_slider id='{$post_id}']</code>";
                break;

        }

    }

}

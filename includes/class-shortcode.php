<?php

namespace Pluginever\WCS;
class Shortcode {

    /**
     * Shortcode constructor.
     */
    public function __construct() {
        add_shortcode( 'woo_category_slider', array( $this, 'woo_cat_slider_callback' ) );
    }

    public function woo_cat_slider_callback( $attr ) {
        $params = shortcode_atts( [ 'id' => null ], $attr );

    }


    protected function get_slider_settings( $post_id = null ) {
        $settings = array();
        $default  = array(
            'selection_type' => 'all',
            'categories'     => [],
            'hide_empty'     => '1',
            'hide_no_image'  => '1',
            'limit'          => '20',
            //design
            'show_content'   => '1',
            'show_button'    => '1',
            'show_name'      => '1',
            'show_nav'       => '1',
            'nav_position'   => 'top-right',
            'hover_effect'   => '1',
            //slider
            'autoplay'       => '1',
            'responsive'     => '1',
        );

        $default_fields = apply_filters('woo_category_slider_default_meta_fields', $default);

        if ( $post_id !== null && get_post_status( $post_id ) ) {
            foreach ( $default_fields as $key => $value ){
                $saved = get_post_meta( $post_id, $key, true );
                if( $saved !== false ){
                    $settings[$key] = $saved;
                }else{
                    $settings[$key] = $value;
                }
            }

            return $settings;
        }


        return $default;

    }
}

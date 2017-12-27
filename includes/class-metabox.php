<?php

namespace Pluginever\WCS;
class Metabox {


    /**
     * Metabox constructor.
     */
    public function __construct() {
//        add_action('admin_enqueue_scripts', [$this, 'load_admin_assets']);
//        add_action( 'add_meta_boxes', [ $this, 'slider_settings_metabox' ] );
//        add_action( 'woo_category_slider_settings_metabox', [ $this, 'add_fields' ] );
    }
    function slider_settings_metabox() {
        add_meta_box( 'woo_cat_slider_metabox', __( 'Slider Settings', 'wpcp' ), 'slider_settings_metabox_callback', 'woocatslider', 'normal', 'high' );
    }

    public function load_admin_assets($hook){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style('woo-category-slider-admin', PLVR_WCS_ASSETS . '/css/framework.css');
    }

    /**
     * Register metabox
     *
     * @param $post
     */
    function slider_settings_metabox_callback( $post ) {
        global $post;
        echo '<div class="pluginever-frameword">';
        do_action( 'woo_category_slider_settings_metabox', $post );
        echo '</div>';
    }

    public function add_fields($post){
        ob_start();
        $output = ob_get_contents();


        ob_get_clean();
        echo $output;
    }


}

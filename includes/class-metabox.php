<?php

namespace Pluginever\WCS;
class Metabox {
    /**
     * Metabox constructor.
     */
    public function __construct() {
        add_action( 'admin_init', [ $this, 'init_category_settings_metabox' ] );
//        add_action( 'admin_init', [ $this, 'init_display_settings_metabox' ] );
//        add_action( 'admin_init', [ $this, 'init_slider_settings_metabox' ] );
    }

    public function init_category_settings_metabox() {
        $metabox = new \Pluginever\Framework\Metabox( 'woo_cat_slider_category_metabox' );
        $config  = array(
            'title'        => __( 'Category Settings', 'woocatslider' ),
            'screen'       => 'woocatslider',
            'context'      => 'normal',
            'priority'     => 'high',
            'lazy_loading' => 'true',
            'fields'       => array(
                array(
                    'type'     => 'select',
                    'name'     => 'selection_type',
                    'label'    => 'Selection Type',
                    'value'    => 'all',
                    'sanitize' => 'sanitize_key',
                    'required' => 'true',
                    'options'  => array(
                        'all'    => 'All',
                        'custom' => 'Custom'
                    ),
                ),
                array(
                    'type'        => 'select',
                    'name'        => 'selected_categories',
                    'label'       => 'Select Categories',
                    'value'       => 'all',
                    'multiple'       => true,
                    'class'       => 'select2',
                    'sanitize'    => 'intval',
                    'condition'   => array(
                        'depend_on'    => 'selection_type',
                        'depend_value' => 'custom',
                        'depend_cond'  => '==',
                    ),
                    'options'     => $this->get_wc_category_list(),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'hide_empty',
                    'label'    => __( 'Hide Empty Categories', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'hide_no_image',
                    'label'    => __( 'Hide Categories Without Image', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'     => 'number',
                    'name'     => 'limit',
                    'label'    => __( 'Limit Items', 'woocatslider' ),
                    'value'    => '20',
                    'sanitize' => 'intval',
                ),
            ),
        );
        $metabox->init( apply_filters( 'woo_category_slider_metabox_config', $config ) );
    }

    public function init_display_settings_metabox() {
        $metabox = new \Pluginever\Framework\Metabox( 'woo_cat_slider_display_metabox' );
        $config  = array(
            'title'        => __( 'Display Settings', 'woocatslider' ),
            'screen'       => 'woocatslider',
            'context'      => 'normal',
            'priority'     => 'high',
            'lazy_loading' => 'true',
            'fields'       => array(
                array(
                    'type'     => 'select',
                    'name'     => 'show_content',
                    'label'    => __( 'Show Content', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'show_button',
                    'label'    => __( 'Show Button', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'condition'   => array(
                        'depend_on'    => 'show_content',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'show_name',
                    'label'    => __( 'Show Name', 'woocatslider' ),
                    'value'    => '0',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'condition'   => array(
                        'depend_on'    => 'show_content',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),

                array(
                    'type'     => 'select',
                    'name'     => 'show_count',
                    'label'    => __( 'Show Count', 'woocatslider' ),
                    'value'    => '0',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'condition'   => array(
                        'depend_on'    => 'show_content',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'show_nav',
                    'label'    => __( 'Show Navigation', 'woocatslider' ),
                    'value'    => '0',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'condition'   => array(
                        'depend_on'    => 'show_content',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'nav_position',
                    'label'    => __( 'Navigation Position', 'woocatslider' ),
                    'value'    => 'top-right',
                    'sanitize' => 'sanitize_key',
                    'options'  => array(
                        'top-right' => 'Top Right',
                        'top-left' => 'Top Left',
                        'bottom-right' => 'Bottom Right',
                        'bottom-left' => 'Bottom Left'
                    ),
                    'condition'   => array(
                        'depend_on'    => 'show_nav',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'hover_effect',
                    'label'    => __( 'Hover Effect', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
            ),
        );
        $metabox->init( apply_filters( 'woo_category_slider_metabox_config', $config ) );
    }

    public function init_slider_settings_metabox() {
        $metabox = new \Pluginever\Framework\Metabox( 'woo_cat_slider_slider_metabox' );
        $config  = array(
            'title'        => __( 'Slider Settings', 'woocatslider' ),
            'screen'       => 'woocatslider',
            'context'      => 'normal',
            'priority'     => 'high',
            'lazy_loading' => 'true',
            'fields'       => array(
                array(
                    'type'     => 'select',
                    'name'     => 'autoplay',
                    'label'    => __( 'Slider Autoplay', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'responsive',
                    'label'    => __( 'Responsive', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
            ),
        );
        $metabox->init( apply_filters( 'woo_category_slider_metabox_config', $config ) );
    }

    protected function get_wc_category_list() {

        $categories = woocatslider_get_wc_categories();
        $list       = array();
        foreach ( $categories as $key => $category ) {
            $list[ $category->term_id ] = $category->name;
        }

        return $list;
    }
}

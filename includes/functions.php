<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return all WC categories
 * @since 2.0.4
 * @param $args
 *
 * @return array|int|\WP_Error
 */
function woocatslider_get_wc_categories( $args = array() ) {
    global $wp_version;
    $product_categories = array();
    $default = array(
        'number'     => '',
        'orderby'    => 'title',
        'order'      => 'ASC',
        'hide_empty' => false,
        'include'    => array()
    );
    if ( version_compare( $wp_version, '4.5.0', '<' ) ) {
        $args               = wp_parse_args( $args, $default );
        $product_categories = get_terms( 'product_cat', $args );
    } else {
        $args               = wp_parse_args( $args, $default );
        $args['taxonomy']   = 'product_cat';
        $product_categories = get_terms( $args );

    }

    return $product_categories;
}

$fields  = array();
$args    = array(
    'label'        => __( 'Slider Settings', 'woocatslider' ),
    'screen'       => 'woocatslider',   //or array( 'post-type1', 'post-type2')
    'context'      => 'normal', //('normal', 'advanced', or 'side')
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
            'name'        => 'categories',
            'label'       => 'Select Categories',
            'value'       => 'custom',
            'class'       => 'select2',
            'sanitize'    => 'sanitize_key',
            'required'    => 'true',
            'custom_attr' => array(
                'multiple' => true,
            ),
            'condition'   => array(
                'depend_on'    => 'selection_type',
                'depend_value' => 'custom',
                'depend_cond'  => '==',
            ),
            'options'     => array(
                'all'    => 'All',
                'custom' => 'Custom'
            ),
        ),
        array(
            'type'     => 'colorpicker',
            'name'     => 'color',
            'label'    => 'Color',
            'value'    => 'rgba(00,00,00,0.5)',
            'required' => 'true',
            'rgba'     => 'true',
        ),
        array(
            'type'     => 'date',
            'name'     => 'color-radio',
            'label'    => 'Color',
            'value'    => 'rgba(00,00,00,0.5)',
            'required' => 'true',
            'rgba'     => 'true',
        ),

    )
);
//$metabox = new Pluginever\Framework\Metabox( 'woo_cat_slider_metabox' );
//$metabox->init( $args );

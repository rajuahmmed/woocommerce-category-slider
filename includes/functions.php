<?php
// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

$fields = array();
$args = array(
    'label'        => __( 'Slider Settings', 'woocatslider' ),
    'screen'        => 'woocatslider',   //or array( 'post-type1', 'post-type2')
    'context'      => 'normal', //('normal', 'advanced', or 'side')
    'priority'     => 'high',
    'lazy_loading' => 'true',
    'fields'       => array(
        array(
            'type'          => 'select',
            'name'          => 'categories_type',
            'label'         => 'Categories',
            'value'         => 'all',
            'sanitize'      => 'sanitize_key',
            'required'      => 'true',
            'options'       => array(
                'all' => 'All',
                'custom' => 'Custom'
            ),
        ),
        array(
            'type'          => 'select',
            'name'          => 'categories',
            'label'         => 'Select Categories',
            'value'         => 'custom',
            'class'         => 'select2',
            'sanitize'      => 'sanitize_key',
            'required'      => 'true',
            'custom_attr'      => array(
                'multiple' => true,
            ),
            'condition' => array(
                'depend_on'    => 'categories_type',
                'depend_value' => 'custom',
                'depend_cond'  => '==',
            ),
            'options'       => array(
                'all' => 'All',
                'custom' => 'Custom'
            ),
        ),
        array(
            'type'          => 'colorpicker',
            'name'          => 'color',
            'label'         => 'Color',
            'value'         => 'rgba(00,00,00,0.5)',
            'required'      => 'true',
            'rgba'      => 'true',
        ),
        array(
            'type'          => 'date',
            'name'          => 'color-radio',
            'label'         => 'Color',
            'value'         => 'rgba(00,00,00,0.5)',
            'required'      => 'true',
            'rgba'      => 'true',
        ),

    )
);
$metabox = new Pluginever\Framework\Metabox('woo_cat_slider_metabox');
$metabox->init($args);

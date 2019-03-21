<?php

global $post;

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'empty_image',
	'label'          => __( 'Hide Image', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => get_post_meta( $post->ID, 'empty_image', true ),
	'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
) );
echo wc_category_slider()->elements->switcher( array(
	'name'           => 'empty_content',
	'label'          => __( 'Hide Content', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => get_post_meta( $post->ID, 'empty_content', true ),
	'default'        => 'no',
	'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
) );
echo wc_category_slider()->elements->switcher( array(
	'name'           => 'empty_button',
	'label'          => __( 'Hide Button', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => get_post_meta( $post->ID, 'empty_button', true ),
	'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
) );
echo wc_category_slider()->elements->switcher( array(
	'name'           => 'empty_name',
	'label'          => __( 'Hide Category Name', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => get_post_meta( $post->ID, 'empty_name', true ),
	'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
) );
echo wc_category_slider()->elements->switcher( array(
	'name'           => 'empty_product_count',
	'label'          => __( 'Hide Product Count', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => get_post_meta( $post->ID, 'empty_product_count', true ),
	'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
) );
echo wc_category_slider()->elements->switcher( array(
	'name'           => 'empty_nav',
	'label'          => __( 'Hide Navigation', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => get_post_meta( $post->ID, 'empty_nav', true ),
	'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
) );
echo wc_category_slider()->elements->switcher( array(
	'name'           => 'empty_border',
	'label'          => __( 'Hide Border', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => get_post_meta( $post->ID, 'empty_border', true ),
	'desc'           => __( 'Border around slider image?', 'woo-category-slider-by-pluginever' ),
) );

echo wc_category_slider()->elements->select( array(
	'label'            => __( 'Image Hover effect', 'woo-category-slider-by-pluginever' ),
	'name'             => 'hover_style',
	'placeholder'      => '',
	'show_option_all'  => '',
	'show_option_none' => '',
	'double_columns'   => false,
	'value'            => 'default',
	'selected'         => get_post_meta( $post->ID, 'hover_style', true ),
	'options'          => apply_filters( 'wc_category_slider_hover_styles', array(
		'no-hover'      => 'No Hover',
		'hover-zoom-in' => 'Zoom In',
	) )
) );
echo wc_category_slider()->elements->select( array(
	'name'             => 'theme',
	'label'            => __( 'Theme', 'wc_category_slider' ),
	'placeholder'      => '',
	'show_option_all'  => '',
	'show_option_none' => '',
	'double_columns'   => false,
	'selected'         => get_post_meta( $post->ID, 'theme', true ),
	'value'            => 'default',
	'options'          => apply_filters( 'wc_category_slider_themes', array(
		'default'    => 'Default',
		'theme-free' => 'Basic',
	) ),

) );

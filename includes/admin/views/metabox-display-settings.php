<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

echo wc_category_slider()->elements->switcher( array(
	'name'  => 'empty_image',
	'label' => __( 'Hide Image', 'woo-category-slider-by-pluginever' ),
	'value' => wc_category_slider_get_meta( $post->ID, 'empty_image', 'off' ),
	'desc'  => __( '', 'woo-category-slider-by-pluginever' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'    => 'empty_content',
	'label'   => __( 'Hide Content', 'woo-category-slider-by-pluginever' ),
	'value'   => wc_category_slider_get_meta( $post->ID, 'empty_content', 'off' ),
	'default' => 'no',
) );

echo wc_category_slider()->elements->switcher( array(
	'name'  => 'empty_button',
	'label' => __( 'Hide Button', 'woo-category-slider-by-pluginever' ),
	'value' => wc_category_slider_get_meta( $post->ID, 'empty_button', 'off' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'  => 'empty_icon',
	'label' => __( 'Hide Icon', 'woo-category-slider-by-pluginever' ),
	'value' => wc_category_slider_get_meta( $post->ID, 'empty_icon', 'off' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'  => 'empty_name',
	'label' => __( 'Hide Category Name', 'woo-category-slider-by-pluginever' ),
	'value' => wc_category_slider_get_meta( $post->ID, 'empty_name', 'off' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'  => 'empty_product_count',
	'label' => __( 'Hide Product Count', 'woo-category-slider-by-pluginever' ),
	'value' => wc_category_slider_get_meta( $post->ID, 'empty_product_count', 'off' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'  => 'empty_nav',
	'label' => __( 'Hide Navigation', 'woo-category-slider-by-pluginever' ),
	'value' => wc_category_slider_get_meta( $post->ID, 'empty_nav', 'off' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'  => 'empty_paginate',
	'label' => __( 'Hide Pagination', 'woo-category-slider-by-pluginever' ),
	'value' => wc_category_slider_get_meta( $post->ID, 'empty_paginate', 'off' ),
	'desc'  => __( 'Show/Hide dotted pagination', 'woo-category-slider-by-pluginever' )
) );

echo wc_category_slider()->elements->switcher( array(
	'name'  => 'empty_border',
	'label' => __( 'Hide Border', 'woo-category-slider-by-pluginever' ),
	'value' => wc_category_slider_get_meta( $post->ID, 'empty_border', 'off' ),
	'desc'  => __( 'Border around slider image?', 'woo-category-slider-by-pluginever' ),
) );

echo wc_category_slider()->elements->select( array(
	'label'            => __( 'Image Hover effect', 'woo-category-slider-by-pluginever' ),
	'name'             => 'hover_style',
	'placeholder'      => '',
	'show_option_all'  => '',
	'show_option_none' => '',
	'value'            => 'default',
	'selected'         => wc_category_slider_get_meta( $post->ID, 'hover_style', 'no-hover' ),
	'options'          => apply_filters( 'wc_category_slider_hover_styles', array(
		'no-hover'      => __( 'No Hover', 'woo-category-slider-by-pluginever' ),
		'hover-zoom-in' => __( 'Zoom In', 'woo-category-slider-by-pluginever' ),
	) )
) );

echo wc_category_slider()->elements->select( array(
	'name'             => 'theme',
	'label'            => __( 'Theme', 'woo-category-slider-by-pluginever' ),
	'placeholder'      => '',
	'show_option_all'  => '',
	'show_option_none' => '',
	'selected'         => wc_category_slider_get_meta( $post->ID, 'theme', 'default' ),
	'value'            => 'default',
	'options'          => apply_filters( 'wc_category_slider_themes', array(
		'default' => 'Default',
		'basic'   => 'Basic',
	) ),

) );

echo wc_get_metabox_promo_text();

echo wc_category_slider()->elements->input( apply_filters( 'wc_category_slider_button_text_args', array(
	'name'        => 'button_text',
	'label'       => __( 'Button Text', 'woo-category-slider-by-pluginever' ),
	'placeholder' => __( 'Shop Now', 'woo-category-slider-by-pluginever' ),
	'disabled'    => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->select( apply_filters( 'wc_category_slider_button_type_args', array(
	'name'             => 'button_type',
	'label'            => __( 'Button Type', 'woo-category-slider-by-pluginever' ),
	'disabled'         => 'disabled',
	'show_option_all'  => '',
	'show_option_none' => '',
	'options'          => array(
		'solid-btn'       => 'Solid',
		'transparent-btn' => 'Transparent'
	),

), $post->ID ) );

echo wc_category_slider()->elements->switcher( apply_filters( 'wc_category_slider_animate_border_args', array(
	'name'     => 'animate_border',
	'label'    => __( 'Animate Border', 'woo-category-slider-by-pluginever' ),
	'disabled' => true,
), $post->ID ) );

echo wc_category_slider()->elements->switcher( apply_filters( 'wc_category_slider_show_desc_args', array(
	'name'     => 'show_desc',
	'label'    => __( 'Show Category Description', 'woo-category-slider-by-pluginever' ),
	'desc'     => __( '', 'woo-category-slider-by-pluginever' ),
	'disabled' => true,
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_button_bg_color_args', array(
	'name'     => 'button_bg_color',
	'label'    => __( 'Button Background', 'woo-category-slider-by-pluginever' ),
	'desc'     => __( '', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_button_color_args', array(
	'name'     => 'button_color',
	'label'    => __( 'Button Color', 'woo-category-slider-by-pluginever' ),
	'desc'     => __( '', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_name_color_args', array(
	'name'     => 'name_color',
	'label'    => __( 'Category Name Color', 'woo-category-slider-by-pluginever' ),
	'desc'     => __( '', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_icon_color_args', array(
	'name'     => 'icon_color',
	'label'    => __( 'Icon Color', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->select( apply_filters( 'wc_category_slider_icon_size_args', array(
	'label'            => __( 'Icon Size', 'woo-category-slider-by-pluginever' ),
	'name'             => 'icon_size',
	'show_option_all'  => '',
	'show_option_none' => '',
	'disabled'         => true,
	'options'          => array(
		'1x'  => '1x',
		'2x'  => '2x',
		'3x'  => '3x',
		'4x'  => '4x',
		'5x'  => '5x',
		'6x'  => '6x',
		'7x'  => '7x',
		'8x'  => '8x',
		'9x'  => '9x',
		'10x' => '10x',
	)
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_description_color_args', array(
	'name'     => 'description_color',
	'label'    => __( 'Description Color', 'woo-category-slider-by-pluginever' ),
	'desc'     => __( '', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_product_count_color_args', array(
	'name'     => 'product_count_color',
	'label'    => __( 'Product Count Color', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_children_category_color_args', array(
	'name'     => 'children_category_color',
	'label'    => __( 'Children Category Color', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_content_bg_args', array(
	'name'     => 'content_bg',
	'label'    => __( 'Content Background Color', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_border_color_args', array(
	'name'     => 'border_color',
	'label'    => __( 'Border Color', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->colorpicker( apply_filters( 'wc_category_slider_border_hover_color_args', array(
	'name'     => 'border_hover_color',
	'label'    => __( 'Border Hover Color', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->input( apply_filters( 'wc_category_slider_border_width_args', array(
	'name'        => 'border_width',
	'label'       => __( 'Border Width', 'woo-category-slider-by-pluginever' ),
	'type'        => 'number',
	'placeholder' => '1',
	'desc'        => __( 'Unit is in px. only input number', 'woo-category-slider-by-pluginever' ),
	'disabled'    => true,
	'attrs'       => ( array(
		'min' => 0
	) )
), $post->ID ) );

echo wc_category_slider()->elements->select( apply_filters( 'wc_category_slider_image_size_args', array(
	'name'             => 'image_size',
	'label'            => __( 'Image Size', 'woo-category-slider-by-pluginever' ),
	'placeholder'      => '',
	'show_option_all'  => '',
	'show_option_none' => '',
	'options'          => wc_category_slider_get_image_sizes(),
	'disabled'         => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->textarea( apply_filters( 'wc_category_slider_custom_css_args', array(
	'name'     => 'custom_css',
	'label'    => __( 'Custom CSS', 'woo-category-slider-by-pluginever' ),
	'disabled' => true,
	'class'    => 'disable',
	'required' => false,
	'desc'     => __( 'Add Custom CSS', 'woo-category-slider-by-pluginever' ),
), $post->ID ) );


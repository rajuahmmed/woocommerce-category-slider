<?php

echo sprintf('<h2 class="pro-feat-title">%s</h2>', 'Pro Features', 'woo-category-slider-by-pluginever');

echo wc_category_slider()->elements->select( array(
	'label'            => __( 'Title Font', 'woo-category-slider-by-pluginever' ),
	'name'             => 'title_font',
	'class'            => 'select-2 title-font',
	'show_option_all'  => '',
	'show_option_none' => '',
	'double_columns'   => false,
	'options'          => wc_slider_get_font_list(),
	'required'         => false,
	'disabled'         => true,
	'selected'         => get_post_meta( $post->ID, 'title_font', true ),
	'desc'             => __( 'Select the font family for title', 'woo-category-slider-by-pluginever' ),
) );

echo wc_category_slider()->elements->select( array(
	'label'            => __( 'Description Font', 'woo-category-slider-by-pluginever' ),
	'name'             => 'description_font',
	'class'            => 'select-2 description-font',
	'show_option_all'  => '',
	'show_option_none' => '',
	'double_columns'   => false,
	'options'          => wc_slider_get_font_list(),
	'required'         => false,
	'disabled'         => true,
	'selected'         => get_post_meta( $post->ID, 'description_font', true ),
	'desc'             => __( 'Select the font family for details', 'woo-category-slider-by-pluginever' ),
) );

echo wc_category_slider()->elements->select( array(
	'label'            => __( 'Button Font', 'woo-category-slider-by-pluginever' ),
	'name'             => 'button_font',
	'class'            => 'select-2 description-font',
	'show_option_all'  => '',
	'show_option_none' => '',
	'double_columns'   => false,
	'options'          => wc_slider_get_font_list(),
	'required'         => false,
	'disabled'         => true,
	'selected'         => get_post_meta( $post->ID, 'button_font', true ),
	'desc'             => __( 'Select the font family for buttons', 'woo-category-slider-by-pluginever' ),
) );



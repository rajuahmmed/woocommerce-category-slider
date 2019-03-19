<?php

/**
 * remove metaboxes
 *
 * @since 3.1.3
 */
function wc_slider_remove_meta_boxes() {
	$post_type = 'wc_category_slider';

	remove_meta_box( 'submitdiv', $post_type, 'side' );
}

add_action( 'add_meta_boxes', 'wc_slider_remove_meta_boxes', 10 );


/**
 * register metaboxes
 *
 * @since 3.1.3
 */
function wc_slider_register_meta_boxes() {
	$post_type = 'wc_category_slider';

	add_meta_box( 'wc-slider-images', __( 'Category Images', 'woo-category-slider-by-pluginever' ), 'wc_slider_render_images_settings_metabox', $post_type, 'normal', 'high' );
	add_meta_box( 'wc_slider_category_settings', __( 'Category Settings', 'woo-category-slider-by-pluginever' ), 'wc_slider_render_category_settings_metabox', $post_type, 'side', 'high' );
	add_meta_box( 'wc_slider_display_settings', __( 'Display Settings', 'woo-category-slider-by-pluginever' ), 'wc_slider_render_display_settings_metabox', $post_type, 'side', 'high' );
}

add_action( 'add_meta_boxes', 'wc_slider_register_meta_boxes', 10 );

/**
 * Images Settings metabox
 */

function wc_slider_render_images_settings_metabox(){
	ob_start();
	include WC_SLIDER_INCLUDES . '/admin/views/html-category-images-metabox.php';
	$html = ob_get_clean();
	echo $html;
}

/**
 * Category settings metabox
 *
 * @since 3.1.3
 */
function wc_slider_render_category_settings_metabox() {

	echo wc_category_slider()->elements->select( array(
		'label'            => __( 'Selection Type', 'woo-category-slider-by-pluginever' ),
		'name'             => 'selection_type',
		'placeholder'      => '',
		'show_option_all'  => '',
		'show_option_none' => '',
		'double_columns'   => false,
		'options'          => array(
			'all'    => 'All',
			'custom' => 'Custom'
		),
		'required'         => true,
		'selected'         => '1',
		'desc'             => __( 'Select all categories or any custom categories', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->select( array(
		'label'            => __( 'Select Categories', 'woo-category-slider-by-pluginever' ),
		'name'             => 'selection_type',
		'placeholder'      => '',
		'show_option_all'  => '',
		'show_option_none' => '',
		'double_columns'   => false,
		'options'          => wc_slider_get_category_list(),
		'required'         => true,
		'selected'         => '1',
		'desc'             => __( '', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->select( array(
		'label'          => __( 'Include Children', 'woo-category-slider-by-pluginever' ),
		'name'           => 'include_child',
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('Will include subcategories of the selected categories', 'woo-category-slider-by-pluginever'),
	) );

	echo wc_category_slider()->elements->select( array(
		'name'           => 'hide_empty',
		'label'          => __( 'Hide Empty Categories', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('Automatically hides Category without products', 'woo-category-slider-by-pluginever'),
	) );

	echo wc_category_slider()->elements->input( array(
		'name'           => 'number',
		'label'          => __( 'Limit Items', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'type'   => 'number',
		'desc' => __('Limit the number of category appear on the slider', 'woo-category-slider-by-pluginever'),
	) );

}

/**
 * Display settings metabox
 *
 * @since 3.1.3
 */

function wc_slider_render_display_settings_metabox(){
	echo wc_category_slider()->elements->select( array(
		'name'           => 'hide_image',
		'label'          => __( 'Hide Image', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('', 'woo-category-slider-by-pluginever'),
	) );
	echo wc_category_slider()->elements->select( array(
		'name'           => 'hide_content',
		'label'          => __( 'Hide Content', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('', 'woo-category-slider-by-pluginever'),
	) );
	echo wc_category_slider()->elements->select( array(
		'name'           => 'hide_button',
		'label'          => __( 'Hide Button', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('', 'woo-category-slider-by-pluginever'),
	) );
	echo wc_category_slider()->elements->select( array(
		'name'           => 'hide_name',
		'label'          => __( 'Hide Category Name', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('', 'woo-category-slider-by-pluginever'),
	) );
	echo wc_category_slider()->elements->select( array(
		'name'           => 'hide_count',
		'label'          => __( 'Hide Product Count', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('', 'woo-category-slider-by-pluginever'),
	) );
	echo wc_category_slider()->elements->select( array(
		'name'           => 'hide_nav',
		'label'          => __( 'Hide Navigation', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('', 'woo-category-slider-by-pluginever'),
	) );
	echo wc_category_slider()->elements->select( array(
		'name'           => 'hide_border',
		'label'          => __( 'Hide Border', 'woo-category-slider-by-pluginever' ),
		'double_columns'   => false,
		'show_option_all'  => '',
		'show_option_none' => '',
		'options'          => array(
			'no'    => 'No',
			'yes' => 'Yes'
		),
		'desc' => __('Hide border around slider image?', 'woo-category-slider-by-pluginever'),
	) );

}

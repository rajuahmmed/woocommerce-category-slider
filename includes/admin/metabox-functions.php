<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
	add_meta_box( 'wc_slider_font_settings', __( 'Font Settings', 'woo-category-slider-by-pluginever' ), 'wc_slider_render_font_settings_metabox', $post_type, 'side', 'high' );
	add_meta_box( 'wc_slider_slider_settings', __( 'Slider Settings', 'woo-category-slider-by-pluginever' ), 'wc_slider_render_slider_settings_metabox', $post_type, 'side', 'high' );
}

add_action( 'add_meta_boxes', 'wc_slider_register_meta_boxes', 10 );

/**
 * Images Settings metabox
 */

function wc_slider_render_images_settings_metabox() {
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
function wc_slider_render_category_settings_metabox( $post ) {

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
		'selected'         => get_post_meta( $post->ID, 'selection_type', true ),
		'desc'             => __( 'Select all categories or any custom categories', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->select( array(
		'label'            => __( 'Select Categories', 'woo-category-slider-by-pluginever' ),
		'name'             => 'selected_categories',
		'class'            => 'select-2 select-categories',
		'show_option_all'  => '',
		'show_option_none' => '',
		'double_columns'   => false,
		'multiple'         => true,
		'options'          => wc_slider_get_category_list(),
		'required'         => false,
		'selected'         => get_post_meta( $post->ID, 'selected_categories', true ),
		'desc'             => __( '', 'woo-category-slider-by-pluginever' ),
		'attrs'            => array(
			'multiple' => 'multiple'
		),
	) );

	echo wc_category_slider()->elements->input( array(
		'name'           => 'limit_number',
		'label'          => __( 'Limit Items', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'type'           => 'number',
		'value'          => get_post_meta( $post->ID, 'limit_number', true ),
		'desc'           => __( 'Limit the number of category appear on the slider', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->switcher( array(
		'label'          => __( 'Include Children', 'woo-category-slider-by-pluginever' ),
		'name'           => 'include_child',
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'include_child', true ),
		'desc'           => __( 'Will include subcategories of the selected categories', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->switcher( array(
		'name'  => 'show_empty',
		'value' => get_post_meta( $post->ID, 'show_empty', true ),
		'label' => __( 'Empty Categories', 'woo-category-slider-by-pluginever' ),
		'desc'  => __( 'Show/hide Category without products', 'woo-category-slider-by-pluginever' ),
	) );


	echo '<input name="save" type="submit" class="button button-primary button-large" id="publish" value="' . __( 'Update Slider', 'woo-category-slider-by-pluginever' ) . '"/>';
}

/**
 * Display settings metabox
 *
 * @since 3.1.3
 */

function wc_slider_render_display_settings_metabox( $post ) {
	echo wc_category_slider()->elements->switcher( array(
		'name'           => 'show_image',
		'label'          => __( 'Image', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'show_image', true ),
		'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
	) );
	echo wc_category_slider()->elements->switcher( array(
		'name'           => 'show_content',
		'label'          => __( 'Content', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'show_content', true ),
		'default'        => 'no',
		'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
	) );
	echo wc_category_slider()->elements->switcher( array(
		'name'           => 'show_button',
		'label'          => __( 'Button', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'show_button', true ),
		'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
	) );
	echo wc_category_slider()->elements->switcher( array(
		'name'           => 'show_name',
		'label'          => __( 'Category Name', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'show_name', true ),
		'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
	) );
	echo wc_category_slider()->elements->switcher( array(
		'name'           => 'show_product_count',
		'label'          => __( 'Product Count', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'show_product_count', true ),
		'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
	) );
	echo wc_category_slider()->elements->switcher( array(
		'name'           => 'show_nav',
		'label'          => __( 'Navigation', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'show_nav', true ),
		'desc'           => __( '', 'woo-category-slider-by-pluginever' ),
	) );
	echo wc_category_slider()->elements->switcher( array(
		'name'           => 'show_border',
		'label'          => __( 'Border', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'show_border', true ),
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

}

/**
 * Font settings metabox
 *
 * @since 3.1.3
 */

function wc_slider_render_font_settings_metabox( $post ) {

	echo wc_category_slider()->elements->select( array(
		'label'            => __( 'Title Font', 'woo-category-slider-by-pluginever' ),
		'name'             => 'title_font',
		'class'            => 'select-2 title-font',
		'show_option_all'  => '',
		'show_option_none' => '',
		'double_columns'   => false,
		'options'          => wc_slider_get_font_list(),
		'required'         => false,
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
		'selected'         => get_post_meta( $post->ID, 'button_font', true ),
		'desc'             => __( 'Select the font family for buttons', 'woo-category-slider-by-pluginever' ),
	) );
}

/**
 * Slider settings metabox
 *
 * @since 3.1.3
 */

function wc_slider_render_slider_settings_metabox( $post ) {
	echo wc_category_slider()->elements->switcher( array(
		'name'           => 'autoplay',
		'label'          => __( 'Slider Autoplay', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'autoplay', true ),
		'desc'           => __( 'Slider will automatically start playing is set Yes.', 'woo-category-slider-by-pluginever' ),
	) );
}

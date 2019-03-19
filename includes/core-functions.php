<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return all WC categories
 *
 * @since 3.0.0
 *
 * @param array $args
 * @param int   $post_id
 *
 * @return array|int|\WP_Error
 */
function wc_category_slider_get_categories( $args = array() ) {
	global $wp_version;
	$categories = array();
	$default    = array(
		'number'     => '20',
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => false,
		'include'    => array(),
		'exclude'    => array(),
		'child_of'   => 0,
	);
	if ( version_compare( $wp_version, '4.5.0', '<' ) ) {
		$args       = wp_parse_args( $args, $default );
		$categories = (array) get_terms( 'product_cat', $args );
	} else {
		$args             = wp_parse_args( $args, $default );
		$args['taxonomy'] = 'product_cat';
		$categories       = (array) get_terms( $args );

	}

//	$results = [];
//	foreach ( $categories as $category ) {
//		$results[] = [
//			'term_id'     => $category->term_id,
//			'name'        => $category->name,
//			'slug'        => $category->slug,
//			'url'         => get_term_link( $category->term_id ),
//			'description' => $category->description,
//			'count'       => $category->count,
//			'image'       => '',
//		];
//	}

	return apply_filters( 'wc_category_slider_get_categories', $categories );
}

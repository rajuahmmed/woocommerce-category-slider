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
		'post_id'    => null,
	);
	if ( version_compare( $wp_version, '4.5.0', '<' ) ) {
		$args       = wp_parse_args( $args, $default );
		$categories = (array) get_terms( 'product_cat', $args );
	} else {
		$args             = wp_parse_args( $args, $default );
		$args['taxonomy'] = 'product_cat';
		$categories       = (array) get_terms( $args );

	}

	$results = [];
	foreach ( $categories as $category ) {
		$image        = WC_SLIDER_ASSETS_URL . '/images/no-image-placeholder.jpg';
		$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
		if ( ! empty( $thumbnail_id ) ) {
			$size  = is_admin() ? 'thumbnail' : apply_filters( 'wc_category_slider_image_size', 'medium', $args );
			$attachment = wp_get_attachment_image_src( $thumbnail_id, $size );
			if(is_array($attachment) && !empty($attachment[0])){
				$image = esc_url($attachment[0]);
			}
		}

		$results[] = [
			'term_id'     => $category->term_id,
			'name'        => $category->name,
			'url'         => get_term_link( $category->term_id, 'product_cat' ),
			'description' => $category->description,
			'count'       => $category->count,
			'image'       => $image,
		];
	}

	return apply_filters( 'wc_category_slider_get_categories', $results, $args );
}


/**
 * Sanitizes a string key for Metabox Settings
 *
 * Keys are used as internal identifiers. Alphanumeric characters, dashes, underscores, stops, colons and slashes are allowed
 * since 1.0.0
 *
 * @param $key
 *
 * @return string
 */
function wc_slider_sanitize_key( $key ) {

	return preg_replace( '/[^a-zA-Z0-9_\-\.\:\/]/', '', $key );
}

/**
 * Get category list
 *
 * @return array
 */
function wc_slider_get_category_list() {

	$categories = wc_category_slider_get_categories( [ 'number' => 1000 ] );
	$list       = wp_list_pluck( $categories, 'name', 'term_id' );

	return $list;
}

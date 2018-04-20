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
 * @param $args
 *
 * @return array|int|\WP_Error
 */
function woocatslider_get_wc_categories( $args = array() ) {
    global $wp_version;
    $categories = array();
    $default    = array(
        'number'     => '20',
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => false,
        'include'    => array(),
        'exclude'    => array(),
        'child_of'    => 0,
    );
    //$args = array_intersect_key( $args, $default);

    if ( version_compare( $wp_version, '4.5.0', '<' ) ) {
        $args       = wp_parse_args( $args, $default );
        $categories = get_terms( 'product_cat', $args );
    } else {
        $args             = wp_parse_args( $args, $default );
        $args['taxonomy'] = 'product_cat';
        $categories       = get_terms( $args );

    }

    return $categories;
}

/**
 * Get category image
 *
 * @param      $category
 * @param null $post_id
 *
 * @return string
 */
function woocatslider_get_category_image($category, $post_id = null){
    $image_size   = apply_filters( 'woo_cat_slider_image_size', 'large', $post_id );
    $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
    if ( ! empty( $thumbnail_id ) ) {
        $url = wp_get_attachment_image_url( $thumbnail_id, $image_size );
    } else {
        $url = PLVR_WCS_ASSETS . '/images/placeholder.png';
    }

    return apply_filters( 'woo_category_slider_category_image', $url, $category, $post_id, $thumbnail_id );
}

/**
 * Checks if pro version is active or not
 *
 * @since 3.0.0
 * @return bool
 */
function woocatslider_is_pro_active() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    return is_plugin_active( 'woo-category-slider-pro/woo-category-slider-pro.php' );
}

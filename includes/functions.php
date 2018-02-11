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
 * Checks if pro version is active or not
 *
 * @since 3.0.0
 * @return bool
 */
function woocatslider_is_pro_active() {

    return defined('WCSP_VERSION');
}

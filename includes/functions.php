<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return all WC categories
 * @since 2.0.4
 * @param $args
 *
 * @return array|int|\WP_Error
 */
function woocatslider_get_wc_categories( $args = array() ) {
    global $wp_version;
    $categories = array();
    $default = array(
        'number'     => '',
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => false,
        'include'    => array(),
        'exclude'    => array(),
    );
    if ( version_compare( $wp_version, '4.5.0', '<' ) ) {
        $args               = wp_parse_args( $args, $default );
        $categories = get_terms( 'product_cat', $args );
    } else {
        $args               = wp_parse_args( $args, $default );
        $args['taxonomy']   = 'product_cat';
        $categories = get_terms( $args );

    }

    return $categories;
}

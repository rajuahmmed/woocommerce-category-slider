<?php

/**
 * Plugin Upgrade Routine
 *
 * @since 1.0.0
 */
class Woocommerce_Category_Slider_Upgrades {

    /**
     * The upgrades
     *
     * @var array
     */
    private static $upgrades = array(// '1.0'    => 'updates/update-1.0.php',
    );

    /**
     * Get the plugin version
     *
     * @return string
     */
    public function get_version() {
        return get_option( 'wc_category_slider_version' );
    }

    /**
     * Check if the plugin needs any update
     *
     * @return boolean
     */
    public function needs_update() {

        if ( empty( get_option( 'wc_category_slider_post_type_updated' ) ) ) {
            $this->change_post_type();
        }

        // may be it's the first install
        if ( ! $this->get_version() ) {
            return false;
        }

        if ( version_compare( $this->get_version(), 'WCS_VERSION', '<' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Perform all the necessary upgrade routines
     *
     * @return void
     */
    function perform_updates() {
        $installed_version = $this->get_version();
        $path              = trailingslashit( dirname( __FILE__ ) );

        foreach ( self::$upgrades as $version => $file ) {
            if ( version_compare( $installed_version, $version, '<' ) ) {
                include $path . $file;
                update_option( 'wc_category_slider_version', $version );
            }
        }

        update_option( 'wc_category_slider_version', 'WCS_VERSION' );
    }

    function change_post_type() {
        global $wpdb;
        $sql = "UPDATE $wpdb->posts SET post_type = 'wc_category_slider' WHERE post_type = 'woocatslider'";
        error_log($sql);
        $wpdb->query($sql);
        $sql = "UPDATE $wpdb->posts SET post_type = 'wc_category_slider' WHERE post_type = 'woocatsliderpro'";
        error_log($sql);
        $wpdb->query($sql);

        update_option( 'wc_category_slider_post_type_updated', 1 );
    }

}

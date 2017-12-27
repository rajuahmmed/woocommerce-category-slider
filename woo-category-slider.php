<?php
/**
 * Plugin Name: Woo Category Slider
 * Plugin URI:  https://pluginever.com/woo-category-slider
 * Description: Showcase Your WooCommerce powered Shop's category in a more appealing way to expand your sell.
 * Version:     1.2.4
 * Author:      PluginEver
 * Author URI:  http://pluginever.com
 * Donate link: https://pluginever.com/woo-category-slider
 * License:     GPLv2+
 * Text Domain: woocatlider
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2017 PluginEver (email : support@pluginever.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main initiation class
 *
 * @since 1.24
 */
class Woo_Category_Slider {

    /**
     * Add-on Version
     *
     * @since 1.0.0
     * @var  string
     */
    public $version = '1.2.4';

    /**
     * Initializes the class
     *
     * Checks for an existing instance
     * and if it does't find one, creates it.
     *
     * @since 1.2.4
     *
     * @return object Class instance
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Constructor for the class
     *
     * Sets up all the appropriate hooks and actions
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct() {
        // Localize our plugin
        add_action( 'init', [ $this, 'localization_setup' ] );

        // on activate plugin register hook
        register_activation_hook( __FILE__, array( $this, 'install' ) );

        // on deactivate plugin register hook
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        // Define constants
        $this->define_constants();

        // Include required files
        $this->includes();

        // Initialize the action hooks
        $this->init_actions();

        // instantiate classes
        $this->instantiate();

        // Loaded action
        do_action( 'woo_category_slider' );
    }

    /**
     * Initialize plugin for localization
     *
     * @since 1.2.4
     *
     * @return void
     */
    public function localization_setup() {
        $locale = apply_filters( 'plugin_locale', get_locale(), 'woo_category_slider' );
        load_textdomain( 'woocatlider', WP_LANG_DIR . '/woo-category-slider/woo-category-slider-' . $locale . '.mo' );
        load_plugin_textdomain( 'woocatlider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Executes during plugin activation
     *
     * @since 1.2.4
     *
     * @return void
     */
    function install() {


    }

    /**
     * Executes during plugin deactivation
     *
     * @since 1.2.4
     *
     * @return void
     */
    function deactivate() {

    }

    /**
     * Define constants
     *
     * @since 1.2.4
     *
     * @return void
     */
    private function define_constants() {
        define( 'PLVR_WCS_VERSION', $this->version );
        define( 'PLVR_WCS_FILE', __FILE__ );
        define( 'PLVR_WCS_PATH', dirname( PLVR_WCS_FILE ) );
        define( 'PLVR_WCS_INCLUDES', PLVR_WCS_PATH . '/includes' );
        define( 'PLVR_WCS_URL', plugins_url( '', PLVR_WCS_FILE ) );
        define( 'PLVR_WCS_ASSETS', PLVR_WCS_URL . '/assets' );
        define( 'PLVR_WCS_VIEWS', PLVR_WCS_PATH . '/views' );
        define( 'PLVR_WCS_TEMPLATES_DIR', PLVR_WCS_PATH . '/templates' );
    }

    /**
     * Include required files
     *
     * @since 1.2.4
     *
     * @return void
     */
    private function includes() {
        require PLVR_WCS_PATH . '/framework/class-framework.php';
        require PLVR_WCS_INCLUDES . '/functions.php';
        require PLVR_WCS_INCLUDES . '/class-cpt.php';
    }

    /**
     * Init Hooks
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function init_actions() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );
    }

    /**
     * Instantiate classes
     *
     * @since 1.2.4
     *
     * @return void
     */
    private function instantiate() {
        new \Pluginever\WCS\CPT();
    }

    /**
     * Add all the assets required by the plugin
     *
     * @since 1.0.0
     *
     * @return void
     */
    function load_assets() {
        $suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
        wp_register_style( 'woo-category-slider', PLVR_WCS_ASSETS . '/css/woo-category-slider{$suffix}.css', [], date( 'i' ) );
        wp_register_script( 'woo-category-slider', PLVR_WCS_ASSETS . '/js/woo-category-slider{$suffix}.js', [ 'jquery' ], date( 'i' ), true );
        wp_localize_script( 'woo-category-slider', 'jsobject', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ] );
        wp_enqueue_style( 'woo-category-slider' );
        wp_enqueue_script( 'woo-category-slider' );
    }


    /**
     * Logger for the plugin
     *
     * @since    1.2.4
     *
     * @param  $message
     *
     * @return  string
     */
    public static function log( $message ) {
        if ( WP_DEBUG !== true ) {
            return;
        }
        if ( is_array( $message ) || is_object( $message ) ) {
            $message = print_r( $message, true );
        }
        $debug_file = WP_CONTENT_DIR . '/custom-debug.log';
        if ( ! file_exists( $debug_file ) ) {
            @touch( $debug_file );
        }

        return error_log( date( "Y-m-d\tH:i:s" ) . "\t\t" . strip_tags( $message ) . "\n", 3, $debug_file );
    }

}

// init our class
$GLOBALS['Woo_Category_Slider'] = new Woo_Category_Slider();

/**
 * Grab the $Woo_Category_Slider object and return it
 */
function woo_category_slider() {
    global $Woo_Category_Slider;

    return $Woo_Category_Slider;
}

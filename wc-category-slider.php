<?php
/**
 * Plugin Name: WooCommerce Category Slider
 * Plugin URI:  https://pluginever.com/woocommerce-category-slider
 * Description: Showcase Your WooCommerce powered Shop's category in a more appealing way to expand your sell.
 * Version:     3.0.4
 * Author:      pluginever
 * Author URI:  http://pluginever.com
 * Donate link: https://pluginever.com/contact
 * License:     GPLv2+
 * Text Domain: wc_category_slider
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2018 manikmist09 (email : support@pluginever.com)
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
 * @since 1.0.0
 */
class Woocommerce_Category_Slider {

    /**
     * Add-on Version
     *
     * @since 1.0.0
     * @var  string
     */
    public $version = '3.0.4';

    /**
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '5.4.0';


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
        // dry check on older PHP versions, if found deactivate itself with an error
        register_activation_hook( __FILE__, array( $this, 'auto_deactivate' ) );

        if ( ! $this->is_supported_php() ) {
            return;
        }

        // Define constants
        $this->define_constants();

        // Include required files
        $this->includes();

        // Initialize the action hooks
        $this->init_hooks();

        // instantiate classes
        $this->instantiate();

        do_action( 'woocommerce_category_slider_loaded' );
    }

    /**
     * Initializes the class
     *
     * Checks for an existing instance
     * and if it does't find one, creates it.
     *
     * @since 1.0.0
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
     * Define constants
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function define_constants() {
        define( 'WCS_VERSION', $this->version );
        define( 'WCS_FILE', __FILE__ );
        define( 'WCS_PATH', dirname( WCS_FILE ) );
        define( 'WCS_INCLUDES', WCS_PATH . '/includes' );
        define( 'WCS_URL', plugins_url( '', WCS_FILE ) );
        define( 'WCS_ASSETS', WCS_URL . '/assets' );
        define( 'WCS_VIEWS', WCS_PATH . '/views' );
        define( 'WCS_TEMPLATES_DIR', WCS_PATH . '/templates' );
    }

    /**
     * Include required files
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function includes() {
        require WCS_INCLUDES . '/functions.php';
        require WCS_INCLUDES . '/class-install.php';
        require WCS_INCLUDES . '/metabox/class-metabox.php';
        require WCS_INCLUDES . '/class-metabox.php';
        require WCS_INCLUDES . '/class-cpt.php';
        require WCS_INCLUDES . '/class-scripts.php';
        require WCS_INCLUDES . '/class-shortcode.php';
        require WCS_INCLUDES . '/class-insights.php';
        require WCS_INCLUDES . '/class-tracker.php';
    }

    /**
     * Do plugin upgrades
     *
     * @since 1.0.0
     *
     * @return void
     */
    function plugin_upgrades() {

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        require_once WCS_INCLUDES . '/class-upgrades.php';

        $upgrader = new Woocommerce_Category_Slider_Upgrades();

        if ( $upgrader->needs_update() ) {
            $upgrader->perform_updates();
        }
    }

    /**
     * Init Hooks
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function init_hooks() {
        // Localize our plugin
        add_action( 'init', [ $this, 'localization_setup' ] );

        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
    }

    /**
     * Initialize plugin for localization
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function localization_setup() {
        load_plugin_textdomain( 'wc_category_slider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Instantiate classes
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function instantiate() {
        new \Pluginever\WoocommerceCategorySlider\Install();
        new \Pluginever\WoocommerceCategorySlider\CPT();
        new \Pluginever\WoocommerceCategorySlider\Shortcode();
        new \Pluginever\WoocommerceCategorySlider\MetaBox();
        new \Pluginever\WoocommerceCategorySlider\Scripts();
        new \Pluginever\WoocommerceCategorySlider\Tracker();
    }

    /**
     * Plugin action links
     *
     * @param  array $links
     *
     * @return array
     */
    function plugin_action_links( $links ) {
        $action_links = [];
        if ( ! wc_category_slider_is_pro_active() ) {
            $action_links['Upgrade'] = '<a target="_blank" href="https://www.pluginever.com/plugins/woocommerce-category-slider-pro/" title="' . esc_attr( __( 'Upgrade To Pro', 'wc_category_slider' ) ) . '" style="color:red;font-weight:bold;">' . __( 'Upgrade To Pro', 'wc_category_slider' ) . '</a>';
        }
        $action_links['Documentation'] = '<a target="_blank" href="https://www.pluginever.com/docs/woocommerce-category-slider/" title="' . esc_attr( __( 'View Plugin\'s Documentation', 'wc_category_slider' ) ) . '">' . __( 'Documentation', 'wc_category_slider' ) . '</a>';


        return array_merge( $action_links, $links );
    }


    /**
     * Check if the PHP version is supported
     *
     * @return bool
     */
    public function is_supported_php( $min_php = null ) {

        $min_php = $min_php ? $min_php : $this->min_php;

        if ( version_compare( PHP_VERSION, $min_php, '<=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Show notice about PHP version
     *
     * @return void
     */
    function php_version_notice() {

        if ( $this->is_supported_php() || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $error = __( 'Your installed PHP Version is: ', 'wc_category_slider' ) . PHP_VERSION . '. ';
        $error .= __( 'The <strong>WooCommerce Category Slider</strong> plugin requires PHP version <strong>', 'wc_category_slider' ) . $this->min_php . __( '</strong> or greater.', 'wc_category_slider' );
        ?>
        <div class="error">
            <p><?php printf( $error ); ?></p>
        </div>
        <?php
    }

    /**
     * Bail out if the php version is lower than
     *
     * @return void
     */
    function auto_deactivate() {
        if ( $this->is_supported_php() ) {
            return;
        }

        deactivate_plugins( plugin_basename( __FILE__ ) );

        $error = __( '<h1>An Error Occured</h1>', 'wc_category_slider' );
        $error .= __( '<h2>Your installed PHP Version is: ', 'wc_category_slider' ) . PHP_VERSION . '</h2>';
        $error .= __( '<p>The <strong>WooCommerce Category Slider</strong> plugin requires PHP version <strong>', 'wc_category_slider' ) . $this->min_php . __( '</strong> or greater', 'wc_category_slider' );
        $error .= __( '<p>The version of your PHP is ', 'wc_category_slider' ) . '<a href="http://php.net/supported-versions.php" target="_blank"><strong>' . __( 'unsupported and old', 'wc_category_slider' ) . '</strong></a>.';
        $error .= __( 'You should update your PHP software or contact your host regarding this matter.</p>', 'wc_category_slider' );

        wp_die( $error, __( 'Plugin Activation Error', 'wc_category_slider' ), array( 'back_link' => true ) );
    }

}

/**
 * Initialize the plugin
 *
 * @return object
 */
function wc_category_slider() {
    return Woocommerce_Category_Slider::init();
}

// kick-off
wc_category_slider();

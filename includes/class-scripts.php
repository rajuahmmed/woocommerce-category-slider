<?php
class WC_Category_Slider_Scripts{

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
		add_action( 'wp_enqueue_scripts', array( $this, 'load_public_assets') );
		//add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets') );
    }

   	/**
	 * Add all the assets of the public side
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function load_public_assets(){
		wp_register_style('wccs-fontawesome', WC_CATEGORY_SLIDER_ASSETS_URL."/vendor/font-awesome/font-awesome.css", [], date('i'));
		wp_register_style('wc-category-slider', WC_CATEGORY_SLIDER_ASSETS_URL."/css/wc-category-slider-public.css", ['wccs-fontawesome'], date('i'));
//		wp_register_script('owl-carousel', WC_CATEGORY_SLIDER_ASSETS_URL."/public/js/owl-carousel.js", ['jquery'], date('i'), true);
//		wp_register_script('image-liquid', WC_CATEGORY_SLIDER_ASSETS_URL."/public/js/image-liquid.js", ['jquery'], date('i'), true);
//		wp_register_script('wc-category-slider', WC_CATEGORY_SLIDER_ASSETS_URL."/public/js/wc-category-slider-public.js", ['jquery', 'owl-carousel', 'image-liquid'], date('i'), true);
//		wp_localize_script('wc-category-slider', 'WCS', ['ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => 'wc-category-slider']);
		wp_enqueue_style('wc-category-slider');
//		wp_enqueue_script('wc-category-slider');
	}

	 /**
	 * Add all the assets required by the plugin
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function load_admin_assets(){
		wp_register_style('wc-category-slider', WCS_ASSETS."/admin/css/wc-category-slider-admin.css", [], date('i'));
		wp_register_script('wc-category-slider', WCS_ASSETS."/admin/js/wc-category-slider-admin.js", ['jquery'], date('i'), true);
		wp_localize_script('wc-category-slider', 'WCS', ['ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => 'wc-category-slider']);
		wp_enqueue_style('wc-category-slider');
		wp_enqueue_script('wc-category-slider');
	}


}

new WC_Category_Slider_Scripts();

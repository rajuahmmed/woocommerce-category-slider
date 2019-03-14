<?php


class WC_Category_Slider_MetaBox {
	/**
	 * Metabox constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_wc_category_slider_metaboxes' ) );
	}

	/**
	 * Register metabox for category selection
	 */
	public function register_wc_category_slider_metaboxes() {
		add_meta_box( 'wc-category-slider-images', __( 'Category Images', 'woo-category-slider-by-pluginever' ), array(
			$this,
			'images_metabox'
		), 'wc_category_slider', 'normal', 'high' );
	}


	public function images_metabox() {
		ob_start();
		include WC_CATEGORY_SLIDER_INCLUDES . '/admin/views/html-category-images-metabox.php';
		$html = ob_get_clean();
		echo $html;
	}


}

new WC_Category_Slider_MetaBox();

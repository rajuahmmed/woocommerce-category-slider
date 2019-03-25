<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Slider_Form_Handler {

	/**
	 * WC_Slider_Form_Handler constructor.
	 */

	public function __construct() {
		//add_action( 'save_post_wc_category_slider', array( $this, 'update_slider_settings' ) );
	}

}

new WC_Slider_Form_Handler();

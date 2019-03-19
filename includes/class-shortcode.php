<?php

class WC_Category_Slider_Shortcode {
	/**
	 * Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'woo_category_slider', array( $this, 'render_shortcode' ) );
		add_shortcode( 'wc_category_slider', array( $this, 'render_shortcode' ) );
	}


	public function render_shortcode( $attr ) {
		ob_start();
		$attr = wp_parse_args( $attr, array(
			'template' => 'default',
		) );
		?>
		<style>
			.wcsn-slider{
				/*width: 300px !important;*/
				overflow: hidden;
				float: left;
				margin: 0 10px 10px 0;
			}
			.wrap{
				width: 1200px !important;
			}
		</style>
		<?php
		$files = glob(WC_SLIDER_TEMPLATES .'/*.php');
		foreach ($files as $file){
			include $file;
		}
//		$file = WC_CATEGORY_SLIDER_TEMPLATES . '/' . $attr['template'] . '.php';
//		if ( file_exists( $file ) ) {
//			include $file;
//		}

		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}
}

new WC_Category_Slider_Shortcode();

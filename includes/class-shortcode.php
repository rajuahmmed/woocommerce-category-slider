<?php

class WC_Category_Slider_Shortcode {
	/**
	 * Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'woo_category_slider', array( $this, 'render' ) );
		add_shortcode( 'wc_category_slider', array( $this, 'render_shortcode_demo' ) );
	}


	public function render_shortcode_demo( $attr ) {
		ob_start();
		$attr = wp_parse_args( $attr, array(
			'template' => 'default',
		) );
		?>
		<style>
			.wcsn-slider {
				width: 300px !important;
				overflow: hidden;
				float: left;
				margin: 0 10px 10px 0;
			}

			.wrap {
				width: 1200px !important;
			}
		</style>
		<?php
		$files = glob( WC_SLIDER_TEMPLATES . '/*.php' );
		foreach ( $files as $file ) {
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

	public function render( $attr ) {
		$params = shortcode_atts( [ 'id' => null ], $attr );
		if ( empty( $params['id'] ) ) {
			return false;
		}
		$post_id = $params['id'];

		$selected_categories = 'all';
		$selection_type        = get_post_meta( $post_id, 'selection_type', true );
		if ( 'all' != $selection_type ) {
			$selected_category_ids = get_post_meta( $post_id, 'selected_categories', true );
			if(is_array($selected_category_ids) && !empty($selected_category_ids))
			$selected_categories = wp_parse_id_list($selected_category_ids);
		}

		var_dump($selected_categories);

		$terms = get_terms( array(
			'taxonomy'               => 'product_cat',
			'orderby'                => 'name',
			'order'                  => 'ASC',
			'hide_empty'             => false, //can be 1, '1' too
			'include'                => $selected_categories, //empty string(''), false, 0 don't work, and return empty array
			'number'                 => false, //can be 0, '0', '' too
			'child_of'               => false, //can be 0, '0', '' too
			'childless'              => false,
		) );


		var_dump( $terms );


	}

	/**
	 * Get slider settings
	 *
	 * @param $settings
	 *
	 * @return object
	 */
	protected function get_slider_config( $settings ) {
		$config = array(
			'dots'               => false,
			'autoHeight'         => true,
			'singleItem'         => true,
			'autoplay'           => empty( $settings['autoplay'] ) ? false : true,
			'loop'               => empty( $settings['loop'] ) ? false : true,
			'lazyLoad'           => empty( $settings['lazy_load'] ) ? false : true,
			'margin'             => intval( $settings['column_gap'] ),
			'autoplayTimeout'    => intval( $settings['slider_speed'] ),
			'autoplayHoverPause' => true,
			'nav'                => empty( $settings['hide_nav'] ) ? true : false,
			'navText'            => [ '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ],
			'stagePadding'       => 4,
			'items'              => empty( $settings['cols'] ) ? 4 : intval( $settings['cols'] ),
			'responsive'         => [
				'0'    => [
					'items' => empty( $settings['phone_cols'] ) ? 4 : intval( $settings['phone_cols'] ),
				],
				'600'  => [
					'items' => empty( $settings['tab_cols'] ) ? 4 : intval( $settings['tab_cols'] ),
				],
				'1000' => [
					'items' => empty( $settings['cols'] ) ? 4 : intval( $settings['cols'] ),
				],
			],
		);
		if ( ! empty( $settings['fluid_speed'] ) ) {
			$config['fluidSpeed'] = intval( $settings['slider_speed'] );
			$config['smartSpeed'] = intval( $settings['slider_speed'] );
		}
		$config = apply_filters( 'woo_category_slider_slider_config', $config );

		return json_encode( $config );
	}

	/**
	 * Get slider wrapper classes
	 *
	 * @param $settings
	 *
	 * @return array
	 */
	protected function get_wrapper_class( $settings ) {
		$classes = array(
			'owl-carousel',
			'owl-theme',
			'ever-slider',
			'ever-category-slider'
		);
		if ( ! empty( $settings['theme'] ) ) {
			$classes[] = sanitize_key( $settings['theme'] );
		}
		if ( empty( $settings['hide_border'] ) ) {
			$classes[] = 'border';
		}
		if ( ! empty( $settings['button_type'] ) ) {
			$classes[] = sanitize_key( $settings['button_type'] );
		}
		if ( intval( $settings['cols'] ) < 2 ) {
			$classes[] = 'single-slide';
		}
		if ( ! empty( $settings['hover_style'] ) || $settings['hover_style'] !== 'no-hover' ) {
			$classes[] = esc_attr( $settings['hover_style'] );
		}

		return apply_filters( 'wc_category_slider_wrapper_classes', $classes, $settings );
	}

	/**
	 * Get slider ID
	 *
	 * @return string
	 */
	protected function get_slider_id( $post_id ) {
		return esc_attr( 'woo-cat-slider-' . $post_id );
	}

}

new WC_Category_Slider_Shortcode();

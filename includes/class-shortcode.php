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
		$theme               = wc_slider_get_settings( $post_id, 'theme', 'default' );
		$selection_type      = wc_slider_get_settings( $post_id, 'selection_type', 'all' );
		$limit_number        = wc_slider_get_settings( $post_id, 'limit_number', '10' );
		$include_child       = wc_slider_get_settings( $post_id, 'include_child', 'off' );
		$show_empty          = wc_slider_get_settings( $post_id, 'show_empty', 'on' );

		if ( 'all' != $selection_type ) {
			$selected_category_ids = wc_slider_get_settings( $post_id, 'selected_categories', [] );
			if ( is_array( $selected_category_ids ) && ! empty( $selected_category_ids ) ) {
				$selected_categories = wp_parse_id_list( $selected_category_ids );
			}
		}

		$terms = get_terms( apply_filters( 'wc_category_slider_term_list_args', array(
			'taxonomy'   => 'product_cat',
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => $show_empty == 'on' ? true : false,
			'include'    => $selected_categories,
			'number'     => $limit_number,
			'child_of'   => $include_child == 'on' ? $selected_categories : 0,
			'childless'  => false,
		) ), $post_id );

		$slider_class = 'wc-category-slider-' . $post_id;
		ob_start();
		?>
		<div class="wc-category-slider">
			<?php foreach ( $terms as $term ) { ?>
				<div class="wcsn-slider">
					<div class="wcsn-slider-image-wrapper">
						<img src="https://picsum.photos/200/300" alt="">
					</div>
					<div class="wcsn-slider-content-wrapper">
						<i class="fa fa-bicycle wcsn-slider-icon fa-2x" aria-hidden="true"></i>
						<a href="#" class="wcsn-slider-link"><h3 class="wcsn-slider-title">Fox Fur Coat</h3></a>
						<span class="wcsn-slider-product-count">5 products</span>
						<a href="#" class="wcsn-slider-button">Shop Now</a>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}


	/**
	 * Get slider settings
	 *
	 * @param $settings
	 *
	 * @return object
	 */
	protected function get_slider_config( $post_id ) {
		$settings = array();
		$config   = array(
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

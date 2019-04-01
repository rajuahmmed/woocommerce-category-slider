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
			.wc-slider {
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

		$file = WC_SLIDER_TEMPLATES . '/' . $attr['template'] . '.php';
		if ( file_exists( $file ) ) {
			include $file;
		}

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

		$theme               = wc_category_slider_get_meta( $post_id, 'theme', 'default' );
		$selection_type      = wc_category_slider_get_meta( $post_id, 'selection_type', 'all' );
		$limit_number        = wc_category_slider_get_meta( $post_id, 'limit_number', '10' );
		$orderby             = wc_category_slider_get_meta( $post_id, 'orderby', 'name' );
		$order               = wc_category_slider_get_meta( $post_id, 'order', 'asc' );
		$include_child       = wc_category_slider_get_meta( $post_id, 'include_child', 'on' );
		$show_empty          = wc_category_slider_get_meta( $post_id, 'show_empty', 'on' );
		$empty_name          = wc_category_slider_get_meta( $post_id, 'empty_name', 'off' );
		$empty_image         = wc_category_slider_get_meta( $post_id, 'empty_image', 'off' );
		$empty_content       = wc_category_slider_get_meta( $post_id, 'empty_content', 'off' );
		$empty_product_count = wc_category_slider_get_meta( $post_id, 'empty_product_count', 'off' );
		$empty_border        = wc_category_slider_get_meta( $post_id, 'empty_border', 'off' );
		$empty_button        = wc_category_slider_get_meta( $post_id, 'empty_button', 'off' );
		$empty_icon          = wc_category_slider_get_meta( $post_id, 'empty_icon', 'off' );
		$button_text         = wc_category_slider_get_meta( $post_id, 'button_text', __( 'Shop Now', 'woo-category-slider-by-pluginever' ) );
		$image_size          = 'large';
		if ( 'all' != $selection_type ) {
			$selected_category_ids = wc_category_slider_get_meta( $post_id, 'selected_categories', [] );

			if ( is_array( $selected_category_ids ) && ! empty( $selected_category_ids ) ) {
				$selected_categories = wp_parse_id_list( $selected_category_ids );
			}
		}

		$terms = wc_category_slider_get_categories( apply_filters( 'wc_category_slider_term_list_args', array(
			'taxonomy'   => 'product_cat',
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $show_empty == 'on' ? false : true,
			'include'    => $selected_categories,
			'number'     => $limit_number,
			//'child_of'   => $include_child == 'on' ? $selected_categories : 0,
			'childless'  => false,
		), $post_id ) );

		$terms = apply_filters( 'wc_category_slider_categories', $terms, $post_id );

		$theme_class   = 'wc-category-' . $theme;
		$slider_class  = 'wc-category-slider-' . $post_id;
		$wrapper_class = $theme_class . ' ' . $slider_class;
		if ( 'on' == $empty_image ) {
			$wrapper_class .= ' hide-image';
		}

		if ( 'on' == $empty_content ) {
			$wrapper_class .= ' hide-content';
		}

		if ( 'on' == $empty_border ) {
			$wrapper_class .= ' hide-border';
		}

		ob_start();

		?>

		<div class="wc-category-slider <?php echo $wrapper_class; ?>" id="<?php echo 'wc-category-slider-' . $post_id ?>" data-slider-config='<?php echo $this->get_slider_config( $post_id ); ?>'>
			<?php
			foreach ( $terms as $term ) { ?>
				<div class="wc-slide">

					<!--Image-->
					<div class="wc-slide-image-wrapper">
						<?php if ( 'on' !== $empty_image && ! empty( $term['image_id'] ) ) { ?><?php echo sprintf( '<a class="wc-slide-link" href="%s">%s</a>', $term['url'], wp_get_attachment_image( $term['image_id'], $image_size ) ) ?><?php } ?>
					</div>

					<div class="wc-slide-content-wrapper">

						<!--Icon-->
						<?php if ( 'off' == $empty_icon && ! empty( $term['icon'] ) ) {
							echo sprintf( '<i class="fa %s wc-slide-icon fa-2x" aria-hidden="true"></i>', esc_attr( $term['icon'] ) );
						} ?>

						<!--Title-->
						<?php if ( $empty_name != 'on' ) { ?>
							<a href="#" class="wc-slide-link">
								<h3 class="wc-slide-title"><?php echo $term['name'] ?></h3></a>
						<?php } ?>

						<!--Product Count-->
						<?php if ( $empty_product_count != 'on' ) { ?>
							<span class="wc-slide-product-count"><?php _e( sprintf( '%s Products', $term['count'] ), 'woo-category-slider-by-pluginever' ); ?></span>
						<?php } ?>

						<!--Child Terms-->
						<?php if ( $include_child == 'on' ) {
							$taxonomy = 'product_cat';
							$children = array_filter( get_term_children( $term['term_id'], $taxonomy ) );
							?>
							<ul class="wc-slide-child-items">
								<?php
								foreach ( $children as $child ) {
									$child_term = get_term_by( 'id', $child, $taxonomy );
									echo sprintf( ' <li class="wc-slide-child-item"><a href="%s" class="wc-slide-link">%s (%s)</a></li> ', get_term_link( $child, $taxonomy ), $child_term->name, $child_term->count );
								}
								?>
							</ul>
						<?php } ?>

						<!--Description-->
						<?php if ( $empty_content != 'on' && ! empty( $term['description'] ) ) {
							echo sprintf( '<p class="wc-slide-description">%s</p>', $term['description'] );
						} ?>

						<!--Button-->
						<?php if ( $empty_button != 'on' ) {
							echo sprintf( '<a href="%s" class="wc-slide-button">%s</a>', esc_url( $term['url'] ), 'Shop Now' );
						} ?>

					</div>
				</div>
			<?php }

			?>
		</div>
		<?php

		do_action( 'wc_category_slider_after_html', $post_id );

		$html = ob_get_clean();

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

		$config = array(
			'dots'               => true,
			'autoHeight'         => true,
			'singleItem'         => true,
			'autoplay'           => 'on' == wc_category_slider_get_meta( $post_id, 'autoplay' ) ? true : false,
			'loop'               => 'on' == wc_category_slider_get_meta( $post_id, 'loop' ) ? true : false,
			'lazyLoad'           => 'on' == wc_category_slider_get_meta( $post_id, 'lazy_load' ) ? true : false,
			'margin'             => intval( wc_category_slider_get_meta( $post_id, 'column_gap', 10 ) ),
			'autoplayTimeout'    => intval( wc_category_slider_get_meta( $post_id, 'slider_speed', 2000 ) ),
			'autoplayHoverPause' => true,
			//			'nav'                => 'on' == wc_category_slider_get_meta( $post_id, 'hide_nav' ) ? true : false,
			'nav'                => true,
			'navText'            => [ '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ],
			'stagePadding'       => 4,
			'items'              => intval( wc_category_slider_get_meta( $post_id, 'cols', 3 ) ),
			'responsive'         => [
				'0'    => [
					'items' => intval( wc_category_slider_get_meta( $post_id, 'phone_cols', 3 ) ),
				],
				'600'  => [
					'items' => intval( wc_category_slider_get_meta( $post_id, 'tab_cols', 3 ) ),
				],
				'1000' => [
					'items' => intval( wc_category_slider_get_meta( $post_id, 'cols', 4 ) ),
				],
			],
		);

		//		if ( ! empty( $settings['fluid_speed'] ) ) {
		//			$config['fluidSpeed'] = intval( wc_category_slider_get_meta( $post_id, 'slider_speed' ) );
		//			$config['smartSpeed'] = intval( wc_category_slider_get_meta( $post_id, 'slider_speed' ) );
		//		}

		$config = apply_filters( 'wc_slider_config', $config );

		return json_encode( $config );
	}

}

new WC_Category_Slider_Shortcode();

<?php

function wc_slider_get_categories_ajax_callback() {
	$selection_type      = empty( $_REQUEST['selection_type'] ) ? 'all' : sanitize_key( $_REQUEST['selection_type'] );
	$selected_categories = empty( $_REQUEST['selected_categories'] ) ? [] : wp_parse_id_list( $_REQUEST['selected_categories'] );
	$include_child       = empty( $_REQUEST['include_child'] ) || 'on' !== $_REQUEST['include_child'] ? false : true;
	$hide_empty          = empty( $_REQUEST['hide_empty'] ) || 'on' !== $_REQUEST['hide_empty'] ? false : true;
	$number              = empty( $_REQUEST['number'] ) ? 10 : intval( $_REQUEST['number'] );
	$orderby             = empty( $_REQUEST['orderby'] ) ? 'name' : sanitize_key( $_REQUEST['orderby'] );
	$order               = empty( $_REQUEST['order'] ) ? 'ASC' : sanitize_key( $_REQUEST['order'] );
	$slider_id           = empty( $_REQUEST['slider_id'] ) ? null : sanitize_key( $_REQUEST['slider_id'] );
	if ( $selection_type == 'all' ) {
		$selected_categories = [];
	}

	$categories = wc_category_slider_get_categories( array(
		'slider_id'  => $slider_id,
		'number'     => $number,
		'orderby'    => $orderby,
		'order'      => $order,
		'hide_empty' => $hide_empty,
		'include'    => $selected_categories,
		'exclude'    => array(),
		'child_of'   => 0,
		'post_id'    => $slider_id,
	) );

	$categories = apply_filters( 'wc_category_slider_categories', $categories, $slider_id );

	wp_send_json_success( $categories );
}

add_action( 'wp_ajax_wc_slider_get_categories', 'wc_slider_get_categories_ajax_callback' );

function wc_category_slider_print_js_template() {

	global $current_screen;

	if ( empty( $current_screen->id ) || ( 'wc_category_slider' !== $current_screen->id ) ) {
		return;
	}


	?>
	<script type="text/html" id="tmpl-wc-category-slide">

		<div class="ever-col-6 ever-slider-container">
			<div class="ever-slide">
				<div class="ever-slide-header">
					<div class="ever-slide-headerleft">{{data.name}}</div>
				</div>
				<div class="ever-slide-main">
					<div class="ever-slide-thumbnail">
						<img src="{{data.image}}" class="img-prev" alt="{{data.name}}">
						<input type="hidden" name="categories[{{data.term_id}}][image_id]" class="wccs-slider img-id" value="{{data.image_id}}">
						<div class="ever-slide-thumbnail-tools">
							<?php if ( ! wc_category_slider()->is_pro_installed() ) { ?>
								<div class="promotion-text">
									<span>Upgrade to <a href="https://www.pluginever.com/plugins/woocommerce-category-slider-pro/">PRO</a>, to change the Image</span>
								</div>
							<?php } ?>
							<div class="image-action <?php echo wc_category_slider()->is_pro_installed() ? 'change-img' : '' ?>">
								<a href="#" class="edit-image"><span class="dashicons dashicons-edit"></span></a>
								<a href="#" class="delete-image"><span class="dashicons dashicons-trash"></span></a>
							</div>

						</div>
					</div>
					<div class="ever-slide-inner">
						<!--title-->
						<div class="ever-slide-title">
							<input class="ever-slide-url-inputbox regular-text" name="categories[{{data.term_id}}][name]" placeholder="{{data.name}}" type="text" value="{{data.name}}">
						</div><!--/title-->

						<!--description-->
						<div class="ever-slide-captionarea">
							<textarea name="categories[{{data.term_id}}][description]" id="caption-{{data.term_id}}" class="ever-slide-captionarea-textfield" data-gramm_editor="false" placeholder="Description">{{data.description}}</textarea>
						</div><!--/description-->

						<!--icon-->

						<div class="ever-slide-icon">
							<select name="categories[{{data.term_id}}][icon]" id="categories-{{data.term_id}}-icon" class="select-2">
								<option value="">No Icon</option>
								<?php

								//todo before release block pro icons
								$icons = wc_slider_get_icon_list();

								ob_start();

								if ( ! wc_category_slider()->is_pro_installed() ) {

									for ( $a = 0; $a < 2; $a ++ ) {

										$offset       = $a == 0 ? 0 : 10;
										$length       = $a == 0 ? 10 : - 1;
										$sliced_icons = array_slice( $icons, $offset, $length );

										$label    = sprintf( __( '%s Icons', 'woo-category-slider-by-pluginever' ), $a == 0 ? 'Free' : 'Pro' );
										$disabled = $a == 0 ? '' : 'disabled';

										echo "<optgroup label='{$label}'>";

										foreach ( $sliced_icons as $key => $value ) {
											echo sprintf( '<option value="%s" %s  <# if( data.icon == "' . $key . '" ){ #> selected <# } #> >&#x%s; &nbsp; %1$s</option>', $key, $disabled, $value );
										}

										echo '</optgroup>';

									}
								} else {
									foreach ( $icons as $key => $value ) {
										echo sprintf( '<option value="%s"  <# if( data.icon == "' . $key . '" ){ #> selected <# } #> >&#x%s; &nbsp; %1$s</option>', $key, $value );
									}
								}

								$output = ob_get_clean();

								echo $output;

								?>

							</select>


						</div><!--/icon-->

						<!--url-->
						<div class="ever-slide-url">
							<input name="categories[{{data.term_id}}][url]" class="ever-slide-url-inputbox regular-text" placeholder="{{data.url}}" value="{{data.url}}" type="url">
						</div><!--/url-->

					</div>
				</div>
			</div>
		</div>
	</script>
	<?php
}

add_action( 'admin_footer', 'wc_category_slider_print_js_template' );


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
		add_action( 'save_post_wc_category_slider', array( $this, 'update_slider_settings' ) );
	}

	public function update_slider_settings( $post_id ) {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return false;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		//save post meta
		$posted = empty( $_POST ) ? [] : $_POST;

		update_post_meta( $post_id, 'categories', empty( $posted['categories'] ) ? '' : $posted['categories'] );
		update_post_meta( $post_id, 'selection_type', empty( $posted['selection_type'] ) ? '' : sanitize_key( $posted['selection_type'] ) );
		update_post_meta( $post_id, 'selected_categories', empty( $posted['selected_categories'] ) ? '' : $posted['selected_categories'] );
		update_post_meta( $post_id, 'limit_number', empty( $posted['limit_number'] ) ? '' : intval( $posted['limit_number'] ) );
		update_post_meta( $post_id, 'include_child', empty( $posted['include_child'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'show_empty', empty( $posted['show_empty'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'show_image', empty( $posted['show_image'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'show_content', empty( $posted['show_content'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'show_button', empty( $posted['show_button'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'show_name', empty( $posted['show_name'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'show_product_count', empty( $posted['show_product_count'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'show_nav', empty( $posted['show_nav'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'show_border', empty( $posted['show_border'] ) ? 'off' : 'on' );
		update_post_meta( $post_id, 'hover_style', empty( $posted['hover_style'] ) ? '' : sanitize_key( $posted['hover_style'] ) );
		update_post_meta( $post_id, 'theme', empty( $posted['theme'] ) ? '' : sanitize_key( $posted['theme'] ) );
		update_post_meta( $post_id, 'title_font', empty( $posted['title_font'] ) ? '' : sanitize_text_field( $posted['title_font'] ) );
		update_post_meta( $post_id, 'description_font', empty( $posted['description_font'] ) ? '' : sanitize_text_field( $posted['description_font'] ) );
		update_post_meta( $post_id, 'button_font', empty( $posted['button_font'] ) ? '' : sanitize_text_field( $posted['button_font'] ) );
		update_post_meta( $post_id, 'autoplay', empty( $posted['autoplay'] ) ? 'off' : 'on' );

		do_action( 'wc_update_slider_settings', $post_id, $posted );

	}

}

new WC_Slider_Form_Handler();

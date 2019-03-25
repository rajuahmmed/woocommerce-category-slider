/**
 * WooCommerce Category Slider
 * pluginever.com
 *
 * Copyright (c) 2018 pluginever
 * Licensed under the GPLv2+ license.
 */

/*jslint browser: true */
/*global jQuery:false */

jQuery(document).ready(function ($, window, document, undefined) {
	'use strict';

	$.wc_category_slider_admin = {
		init: function () {
			$('#selection_type, #selected_categories, #limit_number, #include_child, #hide_empty').on('change', this.regenerateSlides);
			$('#selection_type').on('change', this.handleSelectionType);
			$('.edit-image').on('click', this.handleImageUpload);
			$('.select-2').select2();
			$('.ever-colorpicker').wpColorPicker();
		},
		regenerateSlides: function () {

			var data = {
				selection_type: $('#selection_type').val() || 'all',
				selected_categories: $('#selected_categories').val() || [],
				include_child: $('#include_child').val() || 'no',
				hide_empty: $('#hide_empty').val() || 'no',
				number: $('#limit_number').val() || 10,
				orderby: $('#orderby').val() || 'name',
				order: $('#order').val() || 'ASC',
				slider_id: $('#post_ID').val() || null
			};
			var mountPoint = $('.wc-category-slides-wrapper');
			mountPoint.removeClass('loaded');
			wp.ajax.send('wc_slider_get_categories', {
				data: data,
				success: function (categories) {
					mountPoint.find('.ever-col-6').remove();
					mountPoint.addClass('loaded');
					categories.forEach(function (category) {
						var template = wp.template('wc-category-slide');
						mountPoint.append(template(category));
						// $el.html( template( category ) );
						// console.log(template( category ));
					});

					$('.select-2').select2();

				},
				error: function (res) {
					console.log(res);
				}
			});

		},

		handleSelectionType: function () {
			var $select_type = $('#selection_type');
			var $display = $select_type.val() === 'custom' ? 'block' : 'none';

			$('.selected_categories_field').css('display', $display);

		},

		handleImageUpload: function (e) {

			e.preventDefault();

			var $parent = jQuery(this).parentsUntil('.ever-slide-thumbnail');

			var $img_prev = $parent.children('.img-prev');
			var $img_id = $parent.children('.img-id');

			var image = wp.media({
				title: 'Upload Image'
			}).open().on('select', function () {
				var uploaded_image = image.state().get('selection').first();
				console.log(uploaded_image);
				var image_url = uploaded_image.toJSON().url;
				var image_id = uploaded_image.toJSON().id;
				$img_prev.prop('src', image_url);
				$img_id.val(image_id);
				return false;
			});

		}


	};

	$.wc_category_slider_admin.init();
	$.wc_category_slider_admin.handleSelectionType();
	$.wc_category_slider_admin.regenerateSlides();

});

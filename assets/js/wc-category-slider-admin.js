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

		},
		regenerateSlides:function () {
			var data = {
				selection_type : $('#selection_type').val() || 'all',
				selected_categories : $('#selected_categories').val() || [],
				include_child : $('#include_child').val() || 'no',
				hide_empty : $('#hide_empty').val() || 'no',
				number : $('#number').val() || 10,
				orderby : $('#orderby').val() || 'name',
				order : $('#order').val() || 'ASC'
			};
			wp.ajax.send('wc_slider_get_categories', {
				data:data,
				success:function (res) {
					console.log(res);
				},
				error:function (res) {
					console.log(res);
				}
			});
		}

	};

	$.wc_category_slider_admin.init();
	$.wc_category_slider_admin.regenerateSlides();
});

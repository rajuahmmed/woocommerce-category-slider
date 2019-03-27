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
	$.wc_category_slider_public = {
		init: function () {
			$(".wc-category-slider").owlCarousel({
				items:3,
				loop:false,
				margin:10,
				nav:true,
			});
		}
	};


	$.wc_category_slider_public.init();
});

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

			$('.wc-category-slider').each( function(index, el) {
				var config = $(el).data('slider-config');
				$.wc_category_slider_public.initSlider(config, el);
			});

		},

		initSlider: function (config, el){

			config.onInitialized = function (event) {

				var slider = $(event.currentTarget);

				if (slider.hasClass('single-slide')) {
					return false;

				}

				var maxHeight = 0;
				slider.find('.owl-item.active').each(function () {
					var thisHeight = parseInt(slider.find('img').height());
					maxHeight = (maxHeight >= thisHeight ? maxHeight : thisHeight);
				});

				if (maxHeight < 300) {
					maxHeight = 300;
				}

				//slider.find('.wc-slide-image-wrapper').css('min-height', maxHeight);
				// slider.find('.wc-slide-image-wrapper img').css('height', maxHeight);
				// slider.find('.wc-slide-image-wrapper img').css('width', 'auto');

				slider.find('.wc-slide').css('border-width', 0);
				slider.find('.wc-slide').css('border-width', '1px');

			};

			$(el).owlCarousel(config);

		}

	};


	$.wc_category_slider_public.init();
});

/**
 * Woo Category Slider
 * https://pluginever.com/woo-category-slider
 *
 * Copyright (c) 2017 PluginEver
 * Licensed under the GPLv2+ license.
 */

/*jslint browser: true */
/*global jQuery:false */

window.Woo_Category_Slider = (function(window, document, $, undefined){
	'use strict';

	var app = {};

	app.init = function() {
	    $('.plvr-category-slider').each(function () {
            var config = $(this).data('sliderconfig');
            $(this).slick(config);
        });
	};

	$(document).ready( app.init );

	return app;

})(window, document, jQuery);

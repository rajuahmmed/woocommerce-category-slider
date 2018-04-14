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
        // $('.plvr-category-slider').each(function () {
        //     var config = $(this).data('sliderconfig');
        //     $(this).slick(config);
        // });


        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            items:4,
            autoHeight: true,
            // autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            nav : true,
            dots: true, //Make this true
            navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
            onInitialized: setOwlStageHeight,
            onResized: setOwlStageHeight,
            onTranslated: setOwlStageHeight,

        });
        function setOwlStageHeight(event) {
            console.log(event);
            var maxHeight = 0;
            $('.owl-item.active').each(function () { // LOOP THROUGH ACTIVE ITEMS
                var thisHeight = parseInt( $(this).find('img').height() );
                maxHeight=(maxHeight>=thisHeight?maxHeight:thisHeight);
            });
            $('.owl-carousel img').css('height', maxHeight );
           // $('.owl-stage-outer').css('height', maxHeight ); // CORRECT DRAG-AREA SO BUTTONS ARE CLICKABLE
        }


	};

	$(document).ready( app.init );

	return app;


})(window, document, jQuery);

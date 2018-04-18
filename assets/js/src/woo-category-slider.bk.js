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

        var options = {
            loop:true,
            margin:10,
            items:4,
            stagePadding:4,
            autoHeight: true,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            fluidSpeed: true,
            smartSpeed: 2000,
            nav : true,
            dots: true, //Make this true
            navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
            onInitialized: setOwlStageHeight,
            onResized: setOwlStageHeight,
            onTranslated: setOwlStageHeight

        };



        $('.ever-slider').owlCarousel(options);

        function setOwlStageHeight(event) {
            console.log(event);
            var maxHeight = 0;
            $('.owl-item.active').each(function () { // LOOP THROUGH ACTIVE ITEMS
                var thisHeight = parseInt( $(this).find('img').height() );
                maxHeight=(maxHeight>=thisHeight?maxHeight:thisHeight);
            });
            $('.ever-slider img').css('height', maxHeight );
        }
        function owlResize($owl) {
            $owl.trigger('destroy.owl.carousel');
            $owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');
            $owl.owlCarousel(options);
        }

        var $owl = $(".ever-slider").owlCarousel(options);
        owlResize($owl);

        $('.pro-8').trigger('destroy.owl.carousel');
        $('.pro-8').owlCarousel({
            loop:true,
            margin:10,
            items:1,
            stagePadding:4,
            autoHeight: true,
            // autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            nav : true,
            dots: true, //Make this true
            navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
            onInitialized: setOwlStageHeight,
            onResized: setOwlStageHeight,
            onTranslated: setOwlStageHeight
        });

    };


	$(document).ready( app.init );

	return app;


})(window, document, jQuery);

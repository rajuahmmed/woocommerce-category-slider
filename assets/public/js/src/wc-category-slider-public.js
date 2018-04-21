/**
 * WooCommerce Category Slider Public
 * https://pluginever.com/woo-category-slider
 *
 * Copyright (c) 2018 manikmist09
 * Licensed under the GPLv2+ license.
 */

/*jslint browser: true */
/*global jQuery:false */
window.WooCommerce_Category_Slider_Public = (function (window, document, $, undefined) {
    'use strict';

    var app = {

        initialize: function () {
            $('.ever-category-slider').each(function (index, el) {
                var config = $(el).data('slider-config');
                WooCommerce_Category_Slider_Public.initSlider(config, el);
            });


            $(".ever-slider-image-wrapper").imgLiquid({
                fill: true,
                horizontalAlign: "center",
                verticalAlign: "top"
            });


        },
        initSlider: function (config, el) {
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

                slider.find('.ever-slider-image-wrapper').css('height', maxHeight);

                slider.find('.ever-slider-item').css('border-width', 0);
                slider.find('.ever-slider-item').css('border-width', '1px');

            };

            config.onResized = function (event) {
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
                slider.find('.ever-slider-image-wrapper').css('height', maxHeight);
            };

            config.onTranslated = function (event) {
                var slider = $(event);

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
                slider.find('.ever-slider-image-wrapper').css('height', maxHeight);
            };

            $(el).owlCarousel(config);
        }
    };

    $(document).ready(app.initialize);

    return app;

})(window, document, jQuery);



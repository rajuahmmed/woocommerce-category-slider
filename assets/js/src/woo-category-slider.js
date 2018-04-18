/**
 * Woo Category Slider
 * https://pluginever.com/woo-category-slider
 *
 * Copyright (c) 2017 PluginEver
 * Licensed under the GPLv2+ license.
 */

/*jslint browser: true */
/*global jQuery:false */

window.Woo_Category_Slider = (function (window, document, $, undefined) {
    'use strict';

    var app = {};

    app.init = function () {
        $('.ever-category-slider').each(function (index, el) {
            var config = $(el).data('slider-config');
            Woo_Category_Slider.initSlider(config, el);
        });

    };

    app.initSlider = function (config, el) {

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
            slider.find('.ever-slider-image-wrapper').css('height', maxHeight);
        };

        $(el).owlCarousel(config);

    };


    $(document).ready(app.init);
    // $(window).on('onload', app.init);
    // window.onload(app.init);

    return app;


})(window, document, jQuery);

define([
    'jquery',
    'uiComponent',
    'Magento_Shipping/js/model/config'

], function ($, Component, config) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Dotsquares_Opc/shipping/shipping-policy'
        },
        config: config(),
        appendScrollbar: function (element) {
            $(element).scrollbar();
        }
    });
});

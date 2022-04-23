define(
    [
        'jquery',
        'Magento_Authorizenet/js/view/payment/method-renderer/authorizenet-directpost'
    ],
    function ($, Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Dotsquares_Opc/payment/methods-renderers/authorizenet-directpost',
                isCurrentlySecure: window.checkoutConfig.dotsquaresOpcSettings.isCurrentlySecure
            }
        });
    }
);

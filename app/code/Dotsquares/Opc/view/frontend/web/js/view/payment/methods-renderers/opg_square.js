define(
    [
        'jquery',
        'OPG_Square/js/view/payment/method-renderer/opg_square'
    ],
    function ($, Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Dotsquares_Opc/payment/methods-renderers/opg_square',
                isCurrentlySecure: window.checkoutConfig.dotsquaresOpcSettings.isCurrentlySecure
            },

            getInputStyles: function () {
                return {
                    fontSize: '14px',
                    padding: 0,
                    lineHeight: '19px'
                };
            }
        });
    }
);

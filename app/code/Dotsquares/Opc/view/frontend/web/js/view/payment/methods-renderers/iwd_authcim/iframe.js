define(
    [
        'jquery',
        'Dotsquares_AuthCIM/js/view/payment/method-renderer/iframe'
    ],
    function ($, Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Dotsquares_Opc/payment/methods-renderers/iwd_authcim/iframe',
                isCurrentlySecure: window.checkoutConfig.dotsquaresOpcSettings.isCurrentlySecure
            },
            optionsRenderCallback: 0,
            decorateSelect: function (uid) {
                clearTimeout(this.optionsRenderCallback);
                this.optionsRenderCallback = setTimeout(function () {
                    var select = $('#' + uid);
                    if (select.length) {
                        select.decorateSelect();
                    }
                }, 0);
            }
        });
    }
);
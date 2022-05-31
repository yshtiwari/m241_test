define(
    [
        'mage/translate',
        'Dotsquares_SavedCreditCard/js/view/payment/method-renderer/dotsquares_saved_credit_card'
    ],
    function ($t, Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Dotsquares_Opc/payment/methods-renderers/dotsquares_saved_credit_card',
                isCurrentlySecure: window.checkoutConfig.dotsquaresOpcSettings.isCurrentlySecure

            }
        });
    }
);

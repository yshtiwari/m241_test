define(
    [
        'Magento_Paypal/js/view/payment/method-renderer/paypal-express-bml',
        'mage/translate'
    ],
    function (Component, $t) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Dotsquares_Opc/payment/methods-renderers/paypal-express-bml'
            },
            getInstructions: function () {
                return $t('After clicking "Place Order", you will be directed to one of our trusted partners to complete your purchase.');
            }
        });
    }
);

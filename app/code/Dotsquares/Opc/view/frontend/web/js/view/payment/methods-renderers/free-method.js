define(
    [
        'Magento_Payment/js/view/payment/method-renderer/free-method'
    ],
    function (Component) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Dotsquares_Opc/payment/methods-renderers/free'
            }
        });
    }
);

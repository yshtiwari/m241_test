define(
    [
        'Magento_Eway/js/view/payment/method-renderer/direct'
    ],
    function (ccFormComponent) {
        'use strict';

        return ccFormComponent.extend({
            defaults: {
                template: 'Dotsquares_Opc/payment/methods-renderers/eway-direct-form'
            }
        });
    }
);

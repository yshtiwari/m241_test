define(
    [
        'Magento_OfflinePayments/js/view/payment/method-renderer/checkmo-method'],
    function (Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Dotsquares_Opc/payment/methods-renderers/checkmo'
            }
        });
    }
);

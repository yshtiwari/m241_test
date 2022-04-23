define([
    'Amasty_CheckoutCore/js/view/utils'
], function (viewUtils) {
    'use strict';

    return function (Component) {
        return Component.extend({
            getNameSummary: function () {
                return viewUtils.getBlockTitle('summary');
            }
        });
    };
});

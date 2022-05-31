/**
 * Delivery Date View
 */
define([
    'jquery',
    'underscore',
    'uiComponent',
    'Amasty_CheckoutCore/js/view/utils',
    'Amasty_CheckoutDeliveryDate/js/action/update-delivery',
    'Amasty_CheckoutDeliveryDate/js/model/delivery',
    'Magento_Checkout/js/model/payment/additional-validators',
    'Amasty_CheckoutCore/js/view/checkout/datepicker'
], function (
    $,
    _,
    Component,
    viewUtils,
    updateAction,
    deliveryService,
    paymentValidatorRegistry
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Amasty_CheckoutDeliveryDate/delivery_date',
            listens: {
                'update': 'update'
            }
        },
        isLoading: deliveryService.isLoading,
        _requiredFieldSelector: '.amcheckout-delivery-date .field._required :input:not(:button)',

        initialize: function () {
            this._super();

            var self = this,
                validator = {
                    validate: self.validate.bind(self)
                };

            paymentValidatorRegistry.registerValidator(validator);

            return this;
        },

        update: function () {
            var data;

            if (this.validate()) {
                data = this.source.get('amcheckoutDelivery');

                updateAction(data);
            }
        },

        validate: function () {
            var validationResult;

            this.source.set('params.invalid', false);
            this.source.trigger('amcheckoutDelivery.data.validate');

            if (this.source.get('params.invalid')) {
                return false;
            }

            validationResult = true;

            this.elems().forEach(function (item) {
                if (item.validate().valid === false) {
                    validationResult = false;

                    return false;
                }

                return true;
            });

            return validationResult;
        },

        getDeliveryDateName: function () {
            return viewUtils.getBlockTitle('delivery');
        }
    });
});

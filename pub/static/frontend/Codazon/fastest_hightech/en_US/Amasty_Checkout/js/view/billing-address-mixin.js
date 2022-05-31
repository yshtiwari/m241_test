/**
 * Billing address view mixin for store flag is billing form in edit mode (visible)
 */
define([
    'ko',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/quote'
], function (ko, customer, quote) {
    'use strict';

    return function (billingAddress) {
        return billingAddress.extend({
            initObservable: function () {
                this._super();

                if (window.checkoutConfig.isBillingSameAsShipping) {
                    return this;
                }

                this.observe({
                    stateForBillingShipping: window.checkoutConfig.isBillingSameAsShipping
                });

                quote.billingAddress.subscribe(function (newAddress) {
                    if (!quote.isVirtual()) {
                        this.isAddressSameAsShipping(
                            newAddress !== null
                                && newAddress.getCacheKey() === quote.shippingAddress().getCacheKey()
                                && this.stateForBillingShipping()
                        );
                    }

                    this.isAddressDetailsVisible(this.isAddressSameAsShipping());
                }, this);

                return this;
            },

            /**
             * Cancel address edit action
             * Disable button action if customer isn`t logged in because
             * the state of the "Same as delivered" checkbox is hidden
             *
             * @return {*}
             */
            cancelAddressEdit: function () {
                if (!customer.isLoggedIn() && !window.checkoutConfig.displayBillingSameAsShipping) {
                    return;
                }

                this._super();

                if (!window.checkoutConfig.displayBillingSameAsShipping && quote.billingAddress()) {
                    this.isAddressSameAsShipping(this.stateForBillingShipping());
                }
            },

            /**
             * @return {Boolean}
             */
            useShippingAddress: function () {
                if (!window.checkoutConfig.isBillingSameAsShipping) {
                    this.stateForBillingShipping(!this.stateForBillingShipping());
                    this.isAddressDetailsVisible(this.isAddressSameAsShipping());
                }

                return this._super();
            },

            /**
             * Update address action
             *
             * @return {*}
             */
            updateAddress: function () {
                this._super();

                if (!window.checkoutConfig.isBillingSameAsShipping) {
                    if (this.selectedAddress() && !this.isAddressFormVisible()) {
                        this.isAddressDetailsVisible(true);
                    } else if (!this.source.get('params.invalid')) {
                        this.isAddressDetailsVisible(true);
                    }
                }
            },

            /**
             * Manage checkbox visibility for billing
             *
             * @return {Boolean}
             */
            canUseShippingAddress: ko.computed(function () {
                return !quote.isVirtual()
                    && quote.shippingAddress()
                    && quote.shippingAddress().canUseForBilling()
                    && window.checkoutConfig.displayBillingSameAsShipping;
            })
        });
    };
});

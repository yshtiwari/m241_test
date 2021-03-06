define(
    [
        'Magento_Customer/js/model/address-list',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/checkout-data',
        'Magento_Checkout/js/action/create-shipping-address',
        'Magento_Checkout/js/action/select-shipping-address',
        'Magento_Checkout/js/action/select-shipping-method',
        'Magento_Checkout/js/model/payment-service',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Checkout/js/model/address-converter',
        'Magento_Checkout/js/action/select-billing-address',
        'Magento_Checkout/js/action/create-billing-address',
        'underscore'
    ],
    function (addressList,
              quote,
              checkoutData,
              createShippingAddress,
              selectShippingAddress,
              selectShippingMethodAction,
              paymentService,
              selectPaymentMethodAction,
              addressConverter,
              selectBillingAddress,
              createBillingAddress,
              _) {
        'use strict';

        return {

            /**
             * Resolve estimation address. Used local storage
             */
            resolveEstimationAddress: function () {
                var address;

                if (checkoutData.getShippingAddressFromData()) {
                    address = addressConverter.formAddressDataToQuoteAddress(checkoutData.getShippingAddressFromData());
                    selectShippingAddress(address);
                } else {
                    this.resolveShippingAddress();
                }

                if (quote.isVirtual()) {
                    if (checkoutData.getBillingAddressFromData()) {
                        address = addressConverter.formAddressDataToQuoteAddress(
                            checkoutData.getBillingAddressFromData()
                        );
                        selectBillingAddress(address);
                    } else {
                        this.resolveBillingAddress();
                    }
                }

            },

            /**
             * Resolve shipping address. Used local storage
             */
            resolveShippingAddress: function () {
                var newCustomerShippingAddress = checkoutData.getNewCustomerShippingAddress();

                if (newCustomerShippingAddress) {
                    createShippingAddress(newCustomerShippingAddress);
                }

                this.applyShippingAddress(false);
            },

            /**
             * Apply resolved estimated address to quote
             *
             * @param {Object} isEstimatedAddress
             */
            applyShippingAddress: function (isEstimatedAddress) {
                var address,
                    shippingAddress,
                    isConvertAddress,
                    addressData,
                    isShippingAddressInitialized;

                if (addressList().length === 0) {
                    address = addressConverter.formAddressDataToQuoteAddress(
                        checkoutData.getShippingAddressFromData()
                    );
                    selectShippingAddress(address);
                }
                shippingAddress = quote.shippingAddress();
                isConvertAddress = isEstimatedAddress || false;

                if (!shippingAddress) {
                    isShippingAddressInitialized = addressList.some(function (addressFromList) {
                        if (checkoutData.getSelectedShippingAddress() === addressFromList.getKey()) {
                            addressData = isConvertAddress ?
                                addressConverter.addressToEstimationAddress(addressFromList)
                                : addressFromList;
                            selectShippingAddress(addressData);

                            return true;
                        }

                        return false;
                    });

                    if (!isShippingAddressInitialized) {
                        isShippingAddressInitialized = addressList.some(function (address) {
                            if (address.isDefaultShipping()) {
                                addressData = isConvertAddress ?
                                    addressConverter.addressToEstimationAddress(address)
                                    : address;
                                selectShippingAddress(addressData);

                                return true;
                            }

                            return false;
                        });
                    }

                    if (!isShippingAddressInitialized && addressList().length === 1) {
                        addressData = isConvertAddress ?
                            addressConverter.addressToEstimationAddress(addressList()[0])
                            : addressList()[0];
                        selectShippingAddress(addressData);
                    }
                }
            },

            /**
             * @param {Object} ratesData
             */
            resolveShippingRates: function (ratesData) {
                var selectedShippingRate = checkoutData.getSelectedShippingRate(),
                    availableRate = false;

                if (ratesData.length === 1) {
                    availableRate = ratesData[0];
                }

                if (!availableRate && quote.shippingMethod()) {
                    availableRate = _.find(ratesData, function (rate) {
                        return rate.carrier_code === quote.shippingMethod().carrier_code &&
                            rate.method_code === quote.shippingMethod().method_code;
                    });
                }

                if (!availableRate && selectedShippingRate) {
                    availableRate = _.find(ratesData, function (rate) {
                        return rate.carrier_code + '_' + rate.method_code === selectedShippingRate;
                    });
                }

                if (!availableRate && quote.getSelectedShippingMethod()) {
                    availableRate = quote.getSelectedShippingMethod();
                }

                if (!availableRate && quote.getDefaultShippingMethod()) {
                    var defaultShipping = quote.getDefaultShippingMethod();
                    availableRate = _.find(ratesData, function (rate) {
                        return rate.carrier_code + '_' + rate.method_code === defaultShipping;
                    });
                }

                if (!availableRate) {
                    selectShippingMethodAction(null);
                } else {
                    selectShippingMethodAction(availableRate);
                }
            },

            /**
             * Resolve payment method. Used local storage
             */
            resolvePaymentMethod: function () {
                var availablePaymentMethods = paymentService.getAvailablePaymentMethods(),
                    selectedPaymentMethod = checkoutData.getSelectedPaymentMethod();

                if (availablePaymentMethods.length === 1) {
                    selectedPaymentMethod = availablePaymentMethods[0].method;
                }

                if (!selectedPaymentMethod && quote.getDefaultPaymentMethod()) {
                    selectedPaymentMethod = quote.getDefaultPaymentMethod();
                }

                if (selectedPaymentMethod) {
                    availablePaymentMethods.some(function (payment) {
                        if (payment.method === selectedPaymentMethod) {
                            selectPaymentMethodAction(payment);
                            checkoutData.setSelectedPaymentMethod(selectedPaymentMethod);
                            quote.paymentMethod.valueHasMutated();
                        }
                    });
                } else {
                    selectPaymentMethodAction(null);
                    checkoutData.setSelectedPaymentMethod(null);
                }
            },

            /**
             * Resolve billing address. Used local storage
             */
            resolveBillingAddress: function () {
                var selectedBillingAddress = checkoutData.getSelectedBillingAddress(),
                    newCustomerBillingAddressData = checkoutData.getNewCustomerBillingAddress();

                if (selectedBillingAddress) {
                    if (selectedBillingAddress === 'new-customer-address' && newCustomerBillingAddressData) {
                        selectBillingAddress(createBillingAddress(newCustomerBillingAddressData));
                    } else {
                        addressList.some(function (address) {
                            if (selectedBillingAddress === address.getKey()) {
                                selectBillingAddress(address);
                            }
                        });
                    }
                } else if (quote.isVirtual()) {
                    this.applyBillingAddress();
                }
            },

            /**
             * Apply resolved billing address to quote
             */
            applyBillingAddress: function () {
                var isBillingAddressInitialized = false;
                if (addressList().length) {
                    isBillingAddressInitialized = addressList.some(function (address) {
                        if (address.isDefaultBilling()) {
                            selectBillingAddress(address);
                            return true;
                        }

                        return false;
                    });

                    if (addressList().length === 1 || !isBillingAddressInitialized) {
                        selectBillingAddress(addressList()[0]);
                        isBillingAddressInitialized = true;
                    }
                }

                return isBillingAddressInitialized;
            }
        };
    }
);

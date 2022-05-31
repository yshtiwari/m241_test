define([
    'jquery',
    'Magento_Ui/js/form/element/abstract',
    'dotsquaresOpcHelper'
], function ($, Abstract) {
    'use strict';

    return Abstract.extend({
        defaults: {
            elementTmpl: 'Dotsquares_Opc/form/element/textarea'
        },
        textareaAutoSize: function (element) {
            $(element).textareaAutoSize();
        }
    });
});

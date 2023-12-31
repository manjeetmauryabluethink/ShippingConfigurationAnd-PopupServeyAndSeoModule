define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction, messageContainer) {

            var shippingAddress = quote.shippingAddress();

            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            if (shippingAddress.customAttributes != undefined) {
                var shippingField = [];
                $.each(shippingAddress.customAttributes , function( key, value ) {
                    if($.isPlainObject(value)){
                        value = value['value'];
                        shippingField.push(value);
                        key = this.attribute_code;
                    }

                    shippingAddress['customAttributes'][key] =  value;
                });

                shippingAddress['extension_attributes']
                    ['additional_address_data'] =  JSON.stringify(shippingAddress['customAttributes']);
            }

            return originalAction(messageContainer);
        });
    };
});

<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Bluethinkinc\AddNewAddressField\Model\Config\Provider;

/**
 * LayoutProcessorPlugin  used for add field shipping and billing
 */
class LayoutProcessorPlugin
{
    /**
     * @var Provider
     */
    private $provider;

    /**
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }
    /**
     * AfterProcess plugin used for add custom field on checkout
     *
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(LayoutProcessor $subject, array $jsLayout)
    {
        $customFields = $this->provider->getArrayFieldConfiguration();
        foreach ($customFields as $customField) {
            if (!empty($customField["field_code"]) &&
                !empty($customField["field_label"])
            ) {
                $jsLayout = $this->setShippingAddressField(
                    $customField,
                    $jsLayout
                );
            }
        }

        return $jsLayout;
    }

    /**
     * Set ShippingAddressField  used for check shipping address
     *
     * @param array $customField
     * @param array $jsLayout
     * @return array
     */
    private function setShippingAddressField($customField, $jsLayout)
    {
        if (isset(
            $jsLayout["components"]["checkout"]["children"]["steps"][
                    "children"
                ]["shipping-step"]["children"]["shippingAddress"]["children"][
                    "shipping-address-fieldset"
                ]
        )
        ) {
            $jsLayout["components"]["checkout"]["children"]["steps"][
                "children"
            ]["shipping-step"]["children"]["shippingAddress"]["children"][
                "shipping-address-fieldset"
            ]["children"][
                $customField["field_code"]
            ] = $this->getUnitNumberAttributeForAddress(
                "shippingAddress",
                $customField
            );
        }

        return $jsLayout;
    }

    /**
     * Get UnitNumberAttributeForAddress  used for check unit number attribute for address
     *
     * @param array $addressType
     * @param array $customField
     * @return array
     */
    private function getUnitNumberAttributeForAddress(
        $addressType,
        $customField
    ) {
        return [
            "component" => "Magento_Ui/js/form/element/abstract",
            "config" => [
                "customScope" => $addressType . ".custom_attributes",
                "customEntry" => null,
                "template" => "ui/form/field",
                "elementTmpl" => "ui/form/element/input",
            ],
            "dataScope" =>
                $addressType .
                ".custom_attributes" .
                "." .
                $customField["field_code"],
            "label" => $customField["field_label"],
            "provider" => "checkoutProvider",
            "sortOrder" => 999,
            "validation" => [
                "required-entry" => false,
            ],
            "options" => [],
            "filterBy" => null,
            "customEntry" => null,
            "visible" => true,
        ];
    }
}

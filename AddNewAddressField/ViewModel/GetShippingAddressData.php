<?php
namespace Bluethinkinc\AddNewAddressField\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Bluethinkinc\AddNewAddressField\Model\Config\Provider;
use Magento\Customer\Api\Data\AddressInterface;

/**
 * Get shipping address used for taking data on phtml
 */
class GetShippingAddressData implements ArgumentInterface
{
    /**
     * @var Provider
     */
    public Provider $provider;

    /**
     * @param Provider $provider
     */
    public function __construct(
        Provider $provider,
    ) {
        $this->provider = $provider;
    }

    /**
     * Get Configuration Data is used for all the configuration field
     *
     * @return array
     */
    public function getConfigurationData(): array
    {
        return $this->provider->getArrayFieldConfiguration();
    }

    /**
     * Get CustomField Value is used for get custom value
     *
     * @param AddressInterface $address
     * @param string $fieldCode
     * @return string|null
     */
    public function getCustomFieldValue(AddressInterface $address, string $fieldCode): ?string
    {
        if ($customFieldValue = $address->getCustomAttribute($fieldCode)) {
            $customFieldValue = $customFieldValue->getValue();
        }

        return $customFieldValue ?? null;
    }
}

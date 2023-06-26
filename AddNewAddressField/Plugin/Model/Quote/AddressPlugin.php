<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Plugin\Model\Quote;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Quote\Model\Quote\Address;
use Psr\Log\LoggerInterface;

/**
 * AddressPlugin - set custom customer address attribute values from shipping address
 */
class AddressPlugin
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @param LoggerInterface $logger
     * @param SerializerInterface $serializer
     */
    public function __construct(
        LoggerInterface $logger,
        SerializerInterface $serializer
    ) {
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    /**
     * Export data to customer address Data Object.
     *
     * @param Address $subject
     * @param AddressInterface $result
     * @return AddressInterface
     */
    public function afterExportCustomerAddress(
        Address $subject,
        AddressInterface $result
    ): AddressInterface {
        if ($additionalAddressData = $subject->getQuote()->getShippingAddress()->getAdditionalAddressData()) {
            foreach ($this->serializer->unserialize($additionalAddressData) as $addressData) {
                if (!empty($addressData['attribute_code']) && !empty($addressData['value'])) {
                    $result->setCustomAttribute($addressData['attribute_code'], $addressData['value']);
                }
            }
        }

        return $result;
    }
}

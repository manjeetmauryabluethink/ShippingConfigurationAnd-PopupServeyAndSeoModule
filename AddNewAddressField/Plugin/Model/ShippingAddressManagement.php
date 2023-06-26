<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Plugin\Model;

use Magento\Quote\Api\Data\AddressInterface;
use Psr\Log\LoggerInterface;

/**
 * ShippingAddressManagement  used for get and set custom value of shipping field
 */
class ShippingAddressManagement
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Used for save shipping address
     *
     * @param \Magento\Quote\Model\ShippingAddressManagement $subject
     * @param int $cartId
     * @param AddressInterface $address
     * @return void
     */
    public function beforeAssign(
        \Magento\Quote\Model\ShippingAddressManagement $subject,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $address
    ) {
        if ($additionalAddressData = $address->getExtensionAttributes()->getAdditionalAddressData()) {
            try {
                $address->setAdditionalAddressData($additionalAddressData);
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }
}

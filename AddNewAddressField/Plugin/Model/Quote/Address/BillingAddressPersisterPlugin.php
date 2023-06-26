<?php
namespace Bluethinkinc\AddNewAddressField\Plugin\Model\Quote\Address;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Address\BillingAddressPersister;
use Magento\Quote\Api\Data\CartInterface;
use Psr\Log\LoggerInterface;

/**
 * BillingAddress used for save billing address
 */
class BillingAddressPersisterPlugin
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Before save used for save billing address
     *
     * @param BillingAddressPersister $subject
     * @param CartInterface $quote
     * @param AddressInterface $address
     * @param bool $useForShipping
     * @return void
     */
    public function beforeSave(
        BillingAddressPersister $subject,
        CartInterface $quote,
        AddressInterface $address,
        bool $useForShipping = false
    ): void {
        if ($additionalAddressData = $address->getExtensionAttributes()->getAdditionalAddressData()) {
            try {
                $address->setAdditionalAddressData($additionalAddressData);
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }
}

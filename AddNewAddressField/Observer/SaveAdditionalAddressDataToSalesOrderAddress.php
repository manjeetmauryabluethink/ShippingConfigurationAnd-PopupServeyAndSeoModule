<?php

namespace Bluethinkinc\AddNewAddressField\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Quote\Model\Quote;
use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class SaveAdditionalAddressDataToSalesOrderAddress used for convert quote address to sales address
 */
class SaveAdditionalAddressDataToSalesOrderAddress implements ObserverInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private CartRepositoryInterface $quoteRepository;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param CartRepositoryInterface $quoteRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        LoggerInterface $logger
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->logger = $logger;
    }

    /**
     * Execute
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        try {
            /** @var Order $order */
            $order = $observer->getEvent()->getOrder();
            /** @var Quote $quote */
            $quote = $this->quoteRepository->get($order->getQuoteId());
            $shippingAdditionalAddressData = $quote
                ->getShippingAddress()
                ->getAdditionalAddressData();
            if (isset($shippingAdditionalAddressData)) {
                $order
                    ->getShippingAddress()
                    ->setAdditionalAddressData($shippingAdditionalAddressData);
            }
            $billingAdditionalAddressData = $quote
                ->getBillingAddress()
                ->getExtensionAttributes()
                ->getAdditionalAddressData();
            if (isset($billingAdditionalAddressData)) {
                $order
                    ->getBillingAddress()
                    ->setAdditionalAddressData($billingAdditionalAddressData);
            }
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}

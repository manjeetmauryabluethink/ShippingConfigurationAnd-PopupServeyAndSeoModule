<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Plugin\Model\Order\Address;

use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Sales\Model\Order\Address;

/**
 * Address format renderer default
 */
class RendererPlugin
{
     /**
      * @var SerializerInterface
      */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * Format address in a specific way
     *
     * @param Renderer $subject
     * @param Address $address
     * @param string $type
     * @return array
     */
    public function beforeFormat(
        Renderer $subject,
        Address $address,
        $type
    ): array {
        if (!empty($address->getData('additional_address_data'))) {
            $additionalAddressData = $this->serializer->unserialize($address->getData('additional_address_data'));
            foreach ($additionalAddressData as $customAttribute) {
                $address->setData($customAttribute['attribute_code'], $customAttribute['value']);
            }
        }

        return [$address, $type];
    }
}

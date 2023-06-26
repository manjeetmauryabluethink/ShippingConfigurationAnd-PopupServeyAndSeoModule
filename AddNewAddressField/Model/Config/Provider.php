<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Bluethinkinc module configuration
 */
class Provider
{
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * field label  config path
     */
    public const FIELD_LABEL = "add_address_field/general/shipping_field_configuration";

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }
    /**
     * GetFieldConfiguration  used for get configuration value
     *
     * @return string
     */
    public function getFieldConfiguration(): string
    {
        return $this->scopeConfig->getValue(
            self::FIELD_LABEL,
            ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * GetArrayFieldConfiguration convert into array
     *
     * @return array
     */
    public function getArrayFieldConfiguration(): array
    {
        return !empty(
            $this->getFieldConfiguration()
        ) ? $this->serializer->unserialize($this->getFieldConfiguration()) : [];
    }
}

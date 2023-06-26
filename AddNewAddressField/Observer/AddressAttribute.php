<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * Class AddressAttribute used for create customer address attribute
 */
class AddressAttribute implements ObserverInterface
{
    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param Config $eavConfig
     * @param EavSetupFactory $eavSetupFactory
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * Execute methods execute first and create columns
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $dataFields = $observer->getEvent()->getData("configData");
        if (!empty($dataFields["section"])
            && $dataFields["section"] == "add_address_field"
        ) {
            if (!empty($shippingFields =
                    $dataFields["groups"]["general"]["fields"][
                    "shipping_field_configuration"
                    ]["value"])
            ) {
                $customerSetup = $this->customerSetupFactory->create();
                $customerAddressEntity = $customerSetup
                    ->getEavConfig()
                    ->getEntityType("customer_address");
                $attributeSetId = $customerAddressEntity->getDefaultAttributeSetId();

                /** @var $attributeSet AttributeSet */
                $attributeSet = $this->attributeSetFactory->create();
                $attributeGroupId = $attributeSet->getDefaultGroupId(
                    $attributeSetId
                );
                foreach (array_filter($shippingFields) as $value) {
                    $customerSetup->addAttribute(
                        "customer_address",
                        $value["field_code"],
                        [
                            "type" => "varchar",
                            "input" => "text",
                            "label" => $value["field_label"],
                            "visible" => true,
                            "required" => false,
                            "user_defined" => true,
                            "system" => false,
                            "group" => "General",
                            "global" => true,
                            "visible_on_front" => true,
                        ]
                    );
                    $customAttribute = $customerSetup
                        ->getEavConfig()
                        ->getAttribute("customer_address", $value["field_code"])
                        ->addData([
                            "attribute_set_id" => $attributeSetId,
                            "attribute_group_id" => $attributeGroupId,
                            "used_in_forms" => [
                                "adminhtml_customer_address",
                                "customer_address_edit",
                                "customer_register_address",
                                "customer_address",
                            ],
                        ]);

                    $customAttribute->save();
                }
            }
        }
    }
}

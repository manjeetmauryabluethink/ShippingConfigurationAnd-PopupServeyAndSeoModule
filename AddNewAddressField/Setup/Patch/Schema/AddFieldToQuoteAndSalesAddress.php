<?php
declare(strict_types=1);

namespace Bluethinkinc\AddNewAddressField\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * AddFieldToQuoteAndSalesAddress  used for create columns
 */
class AddFieldToQuoteAndSalesAddress implements SchemaPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * Construct
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Get Dependencies function get dependencies
     *
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get Aliases function used for get aliases
     *
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Apply firstly execute and create column
     *
     * @return void
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $connection->addColumn(
            $this->moduleDataSetup->getTable('quote_address'),
            'additional_address_data',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment'  => 'Additional Address Data',
            ],
        );

        $connection->addColumn(
            $this->moduleDataSetup->getTable('sales_order_address'),
            'additional_address_data',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment'  => 'Additional Address Data',
            ],
        );

        $this->moduleDataSetup->endSetup();
    }
}

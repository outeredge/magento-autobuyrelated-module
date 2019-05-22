<?php

namespace OuterEdge\AutoBuyRelated\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * Upgrades DB for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //Add store_id to catalog_product_link
        $productLinkTable = 'catalog_product_link';
        $setup->getConnection()
            ->addColumn(
                    $setup->getTable($productLinkTable),
                    'store_id',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => false,
                        'default' => 0,
                        'comment' => 'Store Id'
                    ]
            );

        
        /**
         * Install product link types
         */
        $data = [
            ['link_type_id' => \OuterEdge\AutoBuyRelated\Model\Catalog\Product\Link::LINK_TYPE_AUTOBUY, 'code' => 'autobuy']
        ];

        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('catalog_product_link_type'), $bind);
        }

        /**
         * install product link attributes
         */
        $data = [
            [
                'link_type_id' => \OuterEdge\AutoBuyRelated\Model\Catalog\Product\Link::LINK_TYPE_AUTOBUY,
                'product_link_attribute_code' => 'position',
                'data_type' => 'int',
            ]
        ];

        $setup->getConnection()
            ->insertMultiple($setup->getTable('catalog_product_link_attribute'), $data);
        
        $setup->endSetup();
    }
}
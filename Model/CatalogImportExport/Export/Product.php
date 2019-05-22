<?php

namespace OuterEdge\AutoBuyRelated\Model\CatalogImportExport\Export;

class Product extends \Magento\CatalogImportExport\Model\Export\Product
{
    /**
     * {@inheritdoc}
     */
    protected function setHeaderColumns($customOptionsData, $stockItemRows)
    {
        if (!$this->_headerColumns) {
            parent::setHeaderColumns($customOptionsData, $stockItemRows);

            $this->_headerColumns = array_merge(
                $this->_headerColumns,
                [
                    'autobuy_skus',
                    'autobuy_position'
                ]
            );
        }
    }
}

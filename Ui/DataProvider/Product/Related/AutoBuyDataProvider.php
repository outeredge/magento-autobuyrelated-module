<?php

namespace OuterEdge\AutoBuyRelated\Ui\DataProvider\Product\Related;

use Magento\Catalog\Ui\DataProvider\Product\Related\AbstractDataProvider;

/**
 * Class AutoBuyDataProvider
 */
class AutoBuyDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc
     */
    protected function getLinkType()
    {
        return 'autobuy';
    }
}

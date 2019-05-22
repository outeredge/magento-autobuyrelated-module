<?php

namespace OuterEdge\AutoBuyRelated\Model\Product\Link\CollectionProvider;

class Autobuy implements \Magento\Catalog\Model\ProductLink\CollectionProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLinkedProducts(\Magento\Catalog\Model\Product $product)
    {
        $products = $product->getAutobuyProducts();

        if (!isset($products)) {
            return [];
        }

        return $products;
    }
}
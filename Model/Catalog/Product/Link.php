<?php

namespace OuterEdge\AutoBuyRelated\Model\Catalog\Product;

class Link extends \Magento\Catalog\Model\Product\Link
{
    const LINK_TYPE_AUTOBUY = 6;

    /**
     * @return \Magento\Catalog\Model\Product\Link $this
     */
    public function useAutobuyLinks()
    {
        $this->setLinkTypeId(self::LINK_TYPE_AUTOBUY);
        return $this;
    }

    /**
     * Save data for product relations
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return \Magento\Catalog\Model\Product\Link
     */
    public function saveProductRelations($product)
    {
        parent::saveProductRelations($product);

        $data = $product->getAutobuyData();
        if (!is_null($data)) {
            $this->_getResource()->saveProductLinks($product->getId(), $data, self::LINK_TYPE_AUTOBUY);
        }
    }
}

<?php

namespace OuterEdge\AutoBuyRelated\Model;

class Product extends \Magento\Catalog\Model\Product
{
    /**
     * Retrieve array of Autobuy products
     *
     * @return array
     */
    public function getAutobuyProducts() 
    {
        if (!$this->hasAutobuyProducts()) {
            $products = [];
            foreach ($this->getAutobuyProductCollection() as $product) {
                $products[] = $product;
            }
            $this->setAutobuyProducts($products);
        }
        return $this->getData('autobuy_products');
    }
    /**
     * Retrieve Autobuy products identifiers
     *
     * @return array
     */
    public function getAutobuyIds() 
    {
        if (!$this->hasAutobuyProductIds()) {
            $ids = [];
            foreach ($this->getAutobuyProducts() as $product) {
                $ids[] = $product->getId();
            }
            $this->setAutobuyProductIds($ids);
        }
        return $this->getData('autobuy_product_ids');
    }
    /**
     * Retrieve collection Autobuy product
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection
     */
    public function getAutobuyProductCollection() 
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection $collection */
        $collection = $this->getLinkInstance()->useAutobuyLinks()->getProductCollection()->setIsStrongMode();
        $collection
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('thumbnail')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('special_price');
        $collection->setProduct($this);
        return $collection;
    }
    /**
     * Retrieve collection Autobuy link
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Collection
     */
    public function getAutobuyLinkCollection() 
    {
        $collection = $this->getLinkInstance()->useAutobuyLinks()->getLinkCollection();
        $collection->setProduct($this);
        $collection->addLinkTypeIdFilter();
        $collection->addProductIdFilter();
        $collection->joinAttributes();
        return $collection;
    }
    
}
<?php

namespace OuterEdge\AutoBuyRelated\Model\Catalog\Product\Link;

class Proxy extends \Magento\Catalog\Model\Product\Link\Proxy
{
    /**
     * {@inheritdoc}
     */
    public function useAutobuyLinks()
    {
        return $this->_getSubject()->useAutobuyLinks();
    }
}
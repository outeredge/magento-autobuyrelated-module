<?php

namespace OuterEdge\AutoBuyRelated\Block\Adminhtml\Catalog\Product\Edit;

class Tab extends \Magento\Backend\Block\Widget\Tab
{
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        if (!$this->_request->getParam('id') || !$this->_authorization->isAllowed('Magento_Review::reviews_all')) {
            $this->setCanShow(false);
        }
    }
}

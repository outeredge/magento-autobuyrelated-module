<?php

namespace OuterEdge\AutoBuyRelated\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\Product;
use Magento\Framework\Data\Form\FormKey;

class AddToCart implements ObserverInterface
{
    private $logger;

    protected $formKey;  

    protected $cart;

    public function __construct(
        LoggerInterface $logger = null,
        Cart $cart,
        Product $product,
        FormKey $formKey
    )
    {
        $this->logger = $logger ?: ObjectManager::getInstance()->get(LoggerInterface::class);
        $this->cart = $cart;
        $this->product = $product;
        $this->formKey = $formKey; 
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');
        $item = ($item->getParentItem() ? $item->getParentItem() : $item);

        if ($item->getProduct()->getId()) {

            $autoBuyRelatedProducts = $item->getProduct()->getAutobuyProducts();
           
            if ($autoBuyRelatedProducts) {
                foreach ($autoBuyRelatedProducts as $autoBuyProduct) {
                    $autoBuyProductId = $autoBuyProduct->getId();

                    try {
                        $params = array(
                            'form_key' => $this->formKey->getFormKey(),
                            'product' => $autoBuyProductId,
                            'qty'   => 1
                            //'options' => $option        
                        );              
                        $productRelated = $this->product->load($autoBuyProductId);  
                        $productRelated->setName($item->getProduct()->getName() . 'Auto Buy');
                        $this->cart->addProduct($productRelated, $params);
                        $this->cart->save();
        
                    } catch (\Exception $e) {
                        $this->logger->critical('Error on AutoBuy Promotion module: ' . $e->getMessage());
                    }
                }
            }       
        }
    }
}

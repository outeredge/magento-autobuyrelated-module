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
        $product = $observer->getEvent()->getProduct();
        
        echo "name: ".$product->getName();
        echo $product->getAutobuyProducts();
        die;

        if (!$product->getId()) {
            try {
                //Add auto buy related product to cart
                //Todo get all autobuyproducts
                $productId =10;
                $params = array(
                    'form_key' => $this->formKey->getFormKey(),
                    'product' => $productId,
                    'qty'   => 1               
                );              
                $productRelated = $this->product->load($productId);  
                $this->cart->addProduct($productRelated, $params);
                $this->cart->save();

            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
    }
}

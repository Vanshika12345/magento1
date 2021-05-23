<?php
class Ccc_Vendor_Block_Product extends Mage_Core_Block_Template
{
    protected $_finalPrice = array();

    public function getProduct()
    {
        if (!$this->getData('product') instanceof Ccc_Vendor_Model_Product) {
            if ($this->getData('product')->getProductId()) {
                $productId = $this->getData('product')->getProductId();
            }
            if ($productId) {
                $product = Mage::getModel('vendor/product')->load($productId);
                if ($product) {
                    $this->setProduct($product);
                }
            }
        }
        return $this->getData('product');
    }

    public function getPrice()
    {
        return $this->getProduct()->getPrice();
    }

    public function getFinalPrice()
    {
        if (!isset($this->_finalPrice[$this->getProduct()->getId()])) {
            $this->_finalPrice[$this->getProduct()->getId()] = $this->getProduct()->getFinalPrice();
        }
        return $this->_finalPrice[$this->getProduct()->getId()];
    }

    public function getPriceHtml($product)
    {
        $this->setTemplate('vendor/product/price.phtml');
        $this->setProduct($product);
        return $this->toHtml();
    }
}
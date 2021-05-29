<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Items extends Mage_Core_Block_Template{
    protected $cart;
   
    public function setCart(Ccc_Order_Model_Order_Cart $cart)
    {
        $this->cart = $cart;
        return $this;
    }
    public function getCart()
    {
        return $this->cart;
    }

    public function getCollection(){
        return $this->getCart()->getItems();
    }

    public function getProductName($id){
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getName();   
    }

    public function getProductSKU($id){
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getSku();
    }

    public function getUpdateUrl(){
        return $this->getUrl('*/adminhtml_order_cart/changeQuantity',array('_current' => true));
    }

    public function getDeleteUrl($id){
        return $this->getUrl('*/adminhtml_order_cart/delete',array('_current' => true,'itemId'=>$id));
    }
}
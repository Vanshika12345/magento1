<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Product extends Mage_Core_BLock_Template
{
    protected $_buttons = array();
    protected $cart;
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('order/cart/index/product.phtml');
    }

    public function getHeaderText()
    {
        return Mage::helper('sales')->__('Items Ordered');
    }

    public function setCart(Ccc_Order_Model_Order_Cart $cart)
    {
        $this->cart = $cart;
        return $this;
    }
   
    public function getCart()
    {
        return $this->cart;
    }

    /*public function getItemObject()
    {   
        $cartId = Mage::getModel('order/session')->cartId;
        return Mage::getModel('order/order_cart_item')->load($cartId,'cart_id');
    }
*/
    public function getProductName($id){
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getName();   
    }

    public function getProductSKU($id){
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getSku();
    }

    public function getUpdateUrl(){
       
        return $this->getUrl('*/adminhtml_order_cart/changeQuantity',['id' => $this->getRequest()->getParam('id')]);
    }

    public function getDeleteItemUrl($id){
        return $this->getUrl('*/adminhtml_order_cart/delete',['id' => $this->getRequest()->getParam('id'),'itemId'=>$id]);
    }
  
}

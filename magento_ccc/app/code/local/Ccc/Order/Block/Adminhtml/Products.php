<?php 

class Ccc_Order_Block_Adminhtml_Products extends Mage_Core_Block_Template
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/products.phtml');
	}

	public function getOrder()
	{
		$id = $this->getRequest()->getParam('order_id');
		return Mage::getModel('order/order')->load($id);
	}

	public function getProducts()
	{
		return $this->getOrder()->getItems();
	}

	 public function getProductName($id){
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getName();   
    }

    public function getProductSKU($id){
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getSku();
    }

}
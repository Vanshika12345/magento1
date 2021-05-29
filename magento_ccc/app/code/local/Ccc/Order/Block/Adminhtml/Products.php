<?php 

class Ccc_Order_Block_Adminhtml_Products extends Mage_Core_Block_Template
{
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/products.phtml');
	}

	public function getProducts()
	{
		$orderId = $this->getRequest()->getParam('order_id');
		$products = Mage::getModel('order/order')->load($orderId)->getItems();
		return $products;
	}

}
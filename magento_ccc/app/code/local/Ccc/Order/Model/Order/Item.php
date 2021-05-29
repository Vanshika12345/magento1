<?php

class Ccc_Order_Model_Order_Item extends Mage_Core_Model_Abstract {

	protected $order = null;
	protected $product = null;

	public function _construct() {
		$this->_init('order/order_item');
	}

	public function setOrder(Ccc_Order_Model_Order $order) {
		$this->order = $order;
		return $this;
	}

	public function getOrder() {
		if (!$this->order) {
			return false;
		}
		$order = Mage::getModel('order/order')->load($this->order_id);
		$this->setOrder($order);
		return $this->order;
	}

	public function setProduct(Mage_Catalog_Model_Product $product) {
		$this->product = $product;
		return $this;
	}

	public function getProduct() {
		if (!$this->product) {
			return false;
		}
		$product = Mage::getModel('catalog/product')->load($this->product_id);
		$this->setProduct($product);
		return $this->product;
	}
}
<?php
class Ccc_Vendor_Block_Product_Tab_Attributes extends Mage_Core_Block_Template {
	protected function _construct() {
		$this->setTemplate('vendor/product/tab/attributes.phtml');
	}

	public function getProduct() {
		return Mage::registry('current_product');
	}
}
?>
<?php

class Ccc_Vendor_Block_Product_Edit_Tab_Attributes extends Mage_Core_Block_Template {

	protected function _construct() {
		$this->setTemplate('vendor/product/edit/tab/attributes.phtml');
	}

	public function getProduct() {
		return Mage::registry('current_product');
	}
}

?>
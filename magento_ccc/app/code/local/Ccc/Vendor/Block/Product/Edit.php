<?php
class Ccc_Vendor_Block_Product_Edit extends Mage_Core_Block_Template {
	public function getBackUrl() {
		return $this->getUrl('vendor/product/grid');
	}
}
?>
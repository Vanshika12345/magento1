<?php

class Ccc_Vendor_Block_Product_Edit extends Mage_Core_Block_Template {

	public function getSaveUrl() {
		return $this->getUrl('*/*/save', ['id' => $this->getRequest()->getParam('id')]);
	}

	public function getDeleteUrl() {
		return $this->getUrl('*/*/delete', ['id' => $this->getRequest()->getParam('id')]);
	}
}

?>
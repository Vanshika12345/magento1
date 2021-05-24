<?php
class Ccc_Vendor_Block_Attribute_Grid extends Mage_Core_Block_Template {

	public function __construct() {
		parent::__construct();
		$this->_prepareCollection();
	}

	public function _getCollectionClass() {
		return "vendor/product_attribute_collection";
	}

	public function _prepareCollection() {
		$collection = Mage::getResourceModel($this->_getCollectionClass())->addFieldToFilter('vendor_id', ['eq' => Mage::getSingleton('vendor/session')->getId()]);
		$this->setCollection($collection);
	}

	public function getAttributeUrl() {
		return $this->getUrl('vendor/attribute/edit/');
	}

	public function getPagerHtml() {
		return $this->getChildHtml('pager');
	}

	public function getEditUrl($attribute) {
		return $this->getUrl('vendor/attribute/edit', ['attribute_id' => $attribute->getId()]);
	}

	public function getDeleteUrl($attribute) {
		return $this->getUrl('vendor/attribute/delete', ['attribute_id' => $attribute->getId()]);
	}

}
?>
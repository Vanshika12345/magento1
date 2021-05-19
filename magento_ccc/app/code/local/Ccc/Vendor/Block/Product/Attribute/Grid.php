<?php

class Ccc_Vendor_Block_Product_Attribute_Grid extends Mage_Core_Block_Template {

	public function __construct() {
		$attributes = Mage::getResourceModel('vendor/product_attribute_collection')
			->addFieldToSelect('*')
			->addFieldToFilter('vendor_id', Mage::getSingleton('vendor/session')->getVendor()->getId());

		$this->setCollection($attributes);
	}

	public function prepareLayout() {
		parent::prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'attribute.pager')
			->setCollection($this->getCollection());
		$this->setChild('pager', $pager);
		return $this;
	}

	public function getPagerHtml() {
		return $this->getChildHtml('pager');
	}

	public function getBackUrl() {
		return $this->getUrl('vendor/account/');
	}

	public function getEditUrl($row) {
		return $this->getUrl('*/*/edit', ['attribute_id' => $row->getId()]);
	}

	public function getDeleteUrl($row) {
		return $this->getUrl('*/*/delete', ['attribute_id' => $row->getId()]);
	}

	public function getAddUrl() {
		return $this->getUrl('*/*/add');
	}

}

?>
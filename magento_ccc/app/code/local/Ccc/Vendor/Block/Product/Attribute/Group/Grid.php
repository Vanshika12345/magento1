<?php

class Ccc_Vendor_Block_Product_Attribute_Group_Grid extends Mage_Core_Block_Template {

	public function __construct() {
		$groups = Mage::getResourceModel('vendor/group_collection')
			->addFieldToSelect('*')
			->addFieldToFilter('vendor_id', Mage::getSingleton('vendor/session')->getVendor()->getId());

		$this->setCollection($groups);
	}

	public function prepareLayout() {
		parent::prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'group.pager')
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
		return $this->getUrl('*/*/edit', ['group_id' => $row->getGroupId()]);
	}

	public function getDeleteUrl($row) {
		return $this->getUrl('*/*/delete', ['group_id' => $row->getGroupId()]);
	}

	public function getAddUrl() {
		return $this->getUrl('*/*/add');
	}

}

?>
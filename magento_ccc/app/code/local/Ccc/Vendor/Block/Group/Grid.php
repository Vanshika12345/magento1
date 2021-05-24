<?php
class Ccc_Vendor_Block_Group_Grid extends Mage_Core_block_Template {

	public function __construct() {
		parent::__construct();
		$this->_prepareCollection();
	}

	public function _getCollectionClass() {
		return "vendor/group_collection";
	}

	public function _prepareCollection() {
		$collection = Mage::getResourceModel($this->_getCollectionClass())->addFieldToFilter('entity_id', ['eq' => Mage::getSingleton('vendor/session')->getId()]);
		$this->setCollection($collection);
	}

	protected function _prepareLayout() {
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock("page/html_pager", "group.pager")
			->setCollection($this->getCollection());
		$this->setChild('pager', $pager);
		return $this;
	}

	public function getPagerHtml() {
		return $this->getChildHtml('pager');
	}

	public function getGroupUrl() {
		return $this->getUrl('vendor/group/add/');
	}

	public function getEditUrl($group) {
		return $this->getUrl('vendor/group/add', ['id' => $group->getGroupId()]);
	}

	public function getDeleteUrl($group) {
		return $this->getUrl('vendor/group/delete', ['id' => $group->getGroupId()]);
	}
}
?>
<?php

class Ccc_Vendor_Block_Product_Edit_Tabs extends Ccc_Vendor_Block_Widget_Tabs {
	function __construct() {
		parent::__construct();
		$this->setDestElementId('edit_form');
	}

	public function getProduct() {
		$id = $this->getRequest()->getParam('id');

		// return Mage::getModel('vendor/product')
		// 	->setStoreId($this->getRequest()->getParam('store', 0))
		// 	->load($id);
		return Mage::registry('current_product');
	}

	protected function _beforeToHtml() {

		$productAttributes = Mage::getResourceModel('eav/entity_attribute_collection')
			->setEntityTypeFilter(Mage::getModel('eav/entity')->setType('vendor_product')->getTypeId())
			->addFieldToFilter('is_visible', ['eq' => 1]);
		// ->addFieldToFilter(['vendor_id', 'vendor_id'], [['eq' => ''], ['eq' => Mage::helper('vendor')->_getSession()->getId()]]);

		


		if (!$this->getProduct()->getId()) {
			foreach ($productAttributes as $attribute) {
				$default = $attribute->getDefaultValue();
				if ($default != null) {
					$this->getProduct()->setData($attribute->getAttributeCode(), $default);
				}
			}
		}

		$attributeSetId = $this->getProduct()->getResource()->getEntityType()->getDefaultAttributeSetId();


		$groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
			->setAttributeSetFilter($attributeSetId)
			->setSortOrder()
			->load();

		$defaultGroupId = 0;

		foreach ($groupCollection as $group) {
			if ($defaultGroupId == 0 || $group->getIsDefault()) {
				$defaultGroupId = $group->getId();
			}
			$attributes = [];
			foreach ($productAttributes as $attribute) {
				
				if ($this->getProduct()->checkInGroup($attribute->getId(), $attributeSetId, $group->getId())) {
					$attributes[] = $attribute;
				}
			}

			if (!$attributes) {
				continue;
			}
			//Mage::log($attributes, null, 'attribute.log', true);
			$active = $defaultGroupId == $group->getId();

			$block = $this->getLayout()->createBlock('vendor/product_edit_tab_attributes')
				->setGroup($group)
				->setAttributes($attributes)
				->setAddHiddenFields($active)
				->toHtml();
			//print_r($block);
			//die();
			$this->addTab('group_' . $group->getId(), [
				'label' => Mage::helper('vendor')->__($group->getAttributeGroupName()),
				'content' => $block,
				'active' => $active,
			]);
		}

		return parent::_beforeToHtml();

	}
}

?>
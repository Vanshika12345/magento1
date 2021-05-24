<?php
class Ccc_Vendor_Block_Attribute_Edit extends Mage_Core_Block_Template {

	public function __construct() {
		$this->getGroup();
	}

	public function getGroup() {
		$groupModel = Mage::getResourceModel('vendor/group_collection')->addFieldToFilter('entity_id', ['eq' => Mage::getSingleton('vendor/session')->getId()]);
		$this->setCollection($groupModel);
	}

	protected function _prepareLayout() {
		$this->setChild('delete_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('eav')->__('Delete'),
					'class' => 'delete delete-option',
				)));

		$this->setChild('add_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('eav')->__('Add Option'),
					'class' => 'add',
					'id' => 'add_new_option_button',
				)));
		return parent::_prepareLayout();
	}

	public function getBackUrl() {
		return $this->getUrl('vendor/attribute/grid');
	}

	public function getDeleteButtonHtml() {
		return $this->getChildHtml('delete_button');
	}

	public function getAddNewButtonHtml() {
		return $this->getChildHtml('add_button');
	}

	public function getSaveUrl() {
		return $this->getUrl('vendor/attribute/save', ['attribute_id' => $this->getRequest()->getParam('attribute_id')]);
	}

	public function getAttribute() {
		return Mage::registry('entity_attribute');
	}

	public function getAttributeObject() {
		if (null === $this->_attribute) {
			return Mage::registry('entity_attribute');
		}
		return Mage::getModel("ccc_vendor/resource_vendor_eav_attribute")
			->setEntityTypeId($this->getEntityTypeId());
	}

	public function getAttributeGroup() {
		$group = Mage::getResourceModel('vendor/group');
		$adapter = $group->getReadConnection();
		$select = $adapter->select()
			->from('eav_attribute_group', array('attribute_group_id'))
			->joinLeft('eav_attribute_set',
				'eav_attribute_set.attribute_set_id
                = eav_attribute_group.attribute_set_id')
			->joinLeft('eav_entity_attribute',
				'eav_entity_attribute.attribute_group_id
                = eav_attribute_group.attribute_group_id')
			->joinLeft('eav_attribute',
				'eav_attribute.attribute_id
                = eav_entity_attribute.attribute_id')
			->where("eav_attribute.attribute_id = {$this->getRequest()->getParam('attribute_id', 0)}");

		$groupId = $adapter->fetchOne($select);
		return $groupId;
	}

	public function getOptionValues() {
		$attributeType = $this->getAttribute()->getFrontendInput();
		$defaultValues = $this->getAttribute()->getDefaultValue();
		if ($attributeType == 'select' || $attributeType == 'multiselect') {
			$defaultValues = explode(',', $defaultValues);
		} else {
			$defaultValues = array();
		}

		switch ($attributeType) {
		case 'select':
			$inputType = 'radio';
			break;
		case 'multiselect':
			$inputType = 'checkbox';
			break;
		default:
			$inputType = '';
			break;
		}

		$values = $this->getData('option_values');
		if (is_null($values)) {
			$values = array();
			$optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
				->setAttributeFilter($this->getAttribute()->getId())
				->setPositionOrder('desc', true)
				->load();

			$helper = Mage::helper('core');
			foreach ($optionCollection as $option) {
				$value = array();
				if (in_array($option->getId(), $defaultValues)) {
					$value['checked'] = 'checked="checked"';
				} else {
					$value['checked'] = '';
				}

				$value['intype'] = $inputType;
				$value['id'] = $option->getId();
				$value['sort_order'] = $option->getSortOrder();
				foreach ($this->getStores() as $store) {
					$storeValues = $this->getStoreOptionValues($store->getId());
					$value['store' . $store->getId()] = isset($storeValues[$option->getId()])
					? $helper->escapeHtml($storeValues[$option->getId()]) : '';
				}
				$values[] = new Varien_Object($value);
			}
			$this->setData('option_values', $values);
		}

		return $values;
	}

	public function getStoreOptionValues($storeId) {
		$values = $this->getData('store_option_values_' . $storeId);
		if (is_null($values)) {
			$values = array();
			$valuesCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
				->setAttributeFilter($this->getAttribute()->getId())
				->setStoreFilter($storeId, false)
				->load();
			foreach ($valuesCollection as $item) {
				$values[$item->getId()] = $item->getValue();
			}
			$this->setData('store_option_values_' . $storeId, $values);
		}
		return $values;
	}

	public function getLabelValues() {
		$values = array();
		$frontendLabel = $this->getAttribute()->getFrontend()->getLabel();
		if (is_array($frontendLabel)) {
			return $frontendLabel;
		}
		$values[0] = $frontendLabel;
		$storeLabels = $this->getAttribute()->getStoreLabels();
		foreach ($this->getStores() as $store) {
			if ($store->getId() != 0) {
				$values[$store->getId()] = isset($storeLabels[$store->getId()]) ? $storeLabels[$store->getId()] : '';
			}
		}
		return $values;
	}

	public function getStores() {
		$stores = $this->getData('stores');
		if (is_null($stores)) {
			$stores = Mage::getModel('core/store')
				->getResourceCollection()
				->setLoadDefault(true)
				->load();
			$this->setData('stores', $stores);
		}
		return $stores;
	}

}
?>
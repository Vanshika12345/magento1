<?php

class Ccc_Practice8_Block_Adminhtml_Practice8_Attribute_Set_Toolbar_Add extends Mage_Adminhtml_Block_Template {
	protected function _construct() {
		$this->setTemplate('practice8/attribute/set/toolbar/add.phtml');
	}

	protected function _prepareLayout() {
		$this->setChild('save_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('practice8')->__('Save Practice8 Attribute Set'),
					'onclick' => 'if (addSet.submit()) disableElements(\'save\');',
					'class' => 'save',
				)));
		$this->setChild('back_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('practice8')->__('Back'),
					'onclick' => 'setLocation(\'' . $this->getUrl('*/*/') . '\')',
					'class' => 'back',
				)));

		$this->setChild('setForm',
			$this->getLayout()->createBlock('practice8/adminhtml_practice8_attribute_set_main_formset')
		);
		return parent::_prepareLayout();
	}

	protected function _getHeader() {
		return Mage::helper('practice8')->__('Add New Practice8 Attribute Set');
	}

	protected function getSaveButtonHtml() {
		return $this->getChildHtml('save_button');
	}

	protected function getBackButtonHtml() {
		return $this->getChildHtml('back_button');
	}

	protected function getFormHtml() {
		return $this->getChildHtml('setForm');
	}

	protected function getFormId() {
		return $this->getChild('setForm')->getForm()->getId();
	}
}

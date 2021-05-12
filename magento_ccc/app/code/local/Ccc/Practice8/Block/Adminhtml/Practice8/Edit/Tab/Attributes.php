<?php

class Ccc_Practice8_Block_Adminhtml_Practice8_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Widget_Form{



	public function getPractice8()
	{
		return Mage::registry('current_practice8');
	}

	protected function _prepareLayout(){
		if(Mage::getSingleton('cms/wysiwyg_config')->isEnabled()){
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
		}

		parent::_prepareLayout();
	}

	public function _prepareForm()
	{
		$group = $this->getGroup();
		$attributes = $this->getAttributes();

		$form = new Varien_Data_Form();
		$this->setForm($form);

		$form->setDataObject($this->getPractice8());
		$form->setHtmlIdPrefix('group_' . $group->getId());
        $form->setFieldNameSuffix('practice8');
		$fieldset = $form->addFieldSet('group_'.$group->getId(),[
			'legend' => Mage::helper('practice8')->__($group->getAttributeGroupName()),
			'class' => 'fieldset'
		]);	

		$form->addValues($this->getPractice8()->getData());
		$this->_setFieldset($attributes,$fieldset);
		return parent::_prepareForm();
	}
	
}
?>
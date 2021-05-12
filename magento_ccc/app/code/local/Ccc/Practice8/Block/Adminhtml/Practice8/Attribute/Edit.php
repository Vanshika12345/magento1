<?php

class Ccc_Practice8_Block_Adminhtml_Practice8_Attribute_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{

	public function __construct()
	{
        $this->_objectId = 'attribute_id';
		$this->_controller = 'adminhtml_practice8_attribute';
		$this->_blockGroup = 'practice8';
		parent::__construct();
		

		if (!Mage::registry('entity_attribute')->getIsUserDefined()) {
            $this->_removeButton('delete');
        } else {
            $this->_updateButton('delete', 'label', Mage::helper('practice8')->__('Delete Attribute'));
        }
	}

	public function getHeaderText()
    {
        if (Mage::registry('entity_attribute')->getId()) {
            $frontendLabel = Mage::registry('entity_attribute')->getFrontendLabel();
            if (is_array($frontendLabel)) {
                $frontendLabel = $frontendLabel[0];
            }
            return Mage::helper('practice8')->__('Edit Practice8 Attribute "%s"', $this->escapeHtml($frontendLabel));
        }
        else {
            return Mage::helper('practice8')->__('New Practice8 Attribute');
        }
    }

	public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate', array('_current'=>true));
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/'.$this->_controller.'/save', array('_current'=>true, 'back'=>null));
    }
}




?>
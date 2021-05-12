<?php

class Ccc_Practice8_Block_Adminhtml_Practice8_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
    	$this->_blockGroup = 'practice8';
        $this->_controller = 'adminhtml_practice8_attribute';
        $this->_headerText = Mage::helper('practice8')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('practice8')->__('Add New Attribute');
        parent::__construct();
    }

}

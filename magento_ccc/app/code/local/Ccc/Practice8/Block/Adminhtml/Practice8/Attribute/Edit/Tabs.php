<?php



class Ccc_Practice8_Block_Adminhtml_Practice8_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{


	public function __construct()
	{
		parent::__construct();
		$this->setId('practice8_edit_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('practice8')->__('Practice8 Attribute Tab'));
	}

	public function _beforeToHtml()
	{
		$this->addTab('main',[
			'label' => Mage::helper('practice8')->__('Properties'),
			'title' => Mage::helper('practice8')->__('Properties'),
			'content' => $this->getLayout()->createBlock('practice8/adminhtml_practice8_attribute_edit_tab_main')->toHtml(),
			'active' => true
		]);

		$this->addTab('labels',[
			'label' => Mage::helper('practice8')->__('Manage Options'),
			'title' => Mage::helper('practice8')->__('Manage Options'),
			'content' => $this->getLayout()->createBlock('practice8/adminhtml_practice8_attribute_edit_tab_options')->toHtml(),
			'active' => true
		]);

		return parent::_beforeToHtml();
	}
}



?>
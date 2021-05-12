<?php

class Ccc_Practice8_Block_Adminhtml_Practice8_Attribute_Grid extends Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract{
	public function __construct()
	{
		parent::__construct();

	}

	public function _prepareCollection()
	{
		$collection = Mage::getResourceModel('practice8/practice8_attribute_collection');
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	public function _prepareColumns()
	{
		parent::_prepareColumns();
		$this->addColumnAfter('is_visible',[
			'header' => Mage::helper('practice8')->__('Is Visible'),
			'index' => 'is_visible_on_front',
			'type'=>'options',
			'options'=>[
				'1' => Mage::helper('practice8')->__('Yes'),
				'0' => Mage::helper('practice8')->__('No')
			]
		],'frontend_label');

		$this->addColumnAfter('is_global',[
			'header' => Mage::helper('practice8')->__('Scope'),
			'index' => 'is_global',
			'type'=> 'options',
			'options' => [
				Ccc_Practice8_Model_Resource_Eav_Attribute::SCOPE_GLOBAL =>Mage::helper('practice8')->__('Global'),
				Ccc_Practice8_Model_Resource_Eav_Attribute::SCOPE_STORE => Mage::helper('practice8')->__('Store'),
				Ccc_Practice8_Model_Resource_Eav_Attribute::SCOPE_WEBSITE => Mage::helper('practice8')->__('Website'),
			]
		],'is_visible');

		$this->addColumnAfter('is_searchable',[
			'header' => Mage::helper('practice8')->__('Scope'),
			'index' => 'is_searchable',
			'type' => 'options',
			'options' => [
				'1' => Mage::helper('practice8')->__('Yes'),
				'0' => Mage::helper('practice8')->__('No')

			]
		],'is_global');

		$this->addColumnAfter('is_filterable',[
			'header' => Mage::helper('practice8')->__('Use in Layered Navigation'),
			'index' => 'is_filterable',
			'type' => 'options',
			'options' => [
				'1' => Mage::helper('practice8')->__('Yes'),
				'0' => Mage::helper('practice8')->__('No')

			]

		],'is_searchable');
		$this->addColumnAfter('is_comparable',[
			'header' => Mage::helper('practice8')->__('Comparable'),
			'index' => 'is_filterable',
			'type' => 'options',
			'options' => [
				'1' => Mage::helper('practice8')->__('Yes'),
				'0' => Mage::helper('practice8')->__('No')

			]

		],'is_filterable');

	}
}


?>
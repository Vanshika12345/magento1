<?php

class Ccc_Practice2_Block_Adminhtml_Practice2_Grid extends Mage_Adminhtml_Block_Widget_Grid{

	public function __construct(){
		parent::__construct();
	}

	public function _getCollectionClass()
	{
		return "practice2/practice2_collection";
	}

	public function _prepareCollection()
	{
		$collection = Mage::getResourceModel($this->_getCollectionClass());
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	public function _prepareColumns()
	{
		$this->addColumn('practice2_id',[
			'header' => Mage::helper('practice2')->__('ID'),
			'index' => 'practice2_id'
		]);
		$this->addColumn('title',[
			'header' => Mage::helper('practice2')->__('Title'),
			'index' => 'title'
		]);
		$this->addColumn('createdAt',[
			'header' => Mage::helper('practice2')->__('Created At'),
			'index' => 'createdAt',
			'type' => 'date',
			'default' => '-'
		]);
		return parent::_prepareColumns();		
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit',['id' => $row->getId()]);
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/index');
	}

}
?>
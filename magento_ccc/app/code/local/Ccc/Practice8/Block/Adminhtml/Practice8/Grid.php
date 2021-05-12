<?php

class Ccc_Practice8_Block_Adminhtml_Practice8_Grid extends Mage_Adminhtml_Block_Widget_Grid{

	public function __construct()
	{
		parent::__construct();
        $this->setId('practice8Grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
	}

	public function _getStore()
	{
		$id = $this->getRequest()->getParam('store',0);
		return Mage::app()->getStore($id);
	}
	public function _prepareCollection()
	{
		$storeId = $this->_getStore();
		$collection = Mage::getModel('practice8/practice8')->getCollection()->addAttributeToSelect('fname');

		$adminStoreId = Mage_Core_Model_App::ADMIN_STORE_ID;
		$collection->joinAttribute(
			'fname',
			'practice8/fname',
			'entity_id',
			null,
			'inner',
			$adminStoreId
		);
		
		$collection->joinAttribute(
			'id',
			'practice8/entity_id',
			'entity_id',
			null,
			'inner',
			$adminStoreId
		);		
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}

	public function _prepareColumns()
	{
		$this->addColumn('id',
            array(
                'header' => Mage::helper('practice8')->__('id'),
                'index'  => 'id',
            ));
        $this->addColumn('fname',
            array(
                'header' => Mage::helper('practice8')->__('First Name'),
                'index'  => 'fname',
            ));
        
        $this->addColumn('action',array(
                'header'   => Mage::helper('practice8')->__('Action'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                	array(
                	'caption' => Mage::helper('practice8')->__('Delete'),
                	'url' => array(
                		'base' => '*/*/delete'
                	),
                	'field' => 'id'
              	  )
                )
        ));

        parent::_prepareColumns();
        return $this;
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit',array('store'=>$this->getRequest()->getParam('store'), 'id'=>$row->getId()));
	}

	public function getGridUrl()
    {
        return $this->getUrl('*/*/index', array('_current' => true));
    }
}
?>
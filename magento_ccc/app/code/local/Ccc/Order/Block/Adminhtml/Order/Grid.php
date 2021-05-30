<?php

class Ccc_Order_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        /*$this->setId('custom_order_grid');
       // $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);*/
    }

    protected function _getCollectionClass()
    {
        return 'order/order_collection';
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('order_id', array(
            'header'=> Mage::helper('order')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'order_id',
        ));
        
        $this->addColumn('customer_name', array(
            'header' => Mage::helper('order')->__('Customer Name'),
            'index' => 'customer_name',
        ));

        $this->addColumn('total', array(
            'header' => Mage::helper('order')->__('Grand Total'),
            'index' => 'total',
            'type'  => 'currency',
            'currency' => 'order_currency_code',
        ));

        $this->addColumn('created_at',[
            'header' => Mage::helper('order')->__('Created At'),
            'index' => 'created_at',
            'type' => 'date',
            'default' => '-'
        ]);

        /*$this->addColumn('status', array(
            'header' => Mage::helper('order')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('order/order_config')->getStatuses(),
        ));*/
    
        // if (Mage::getSingleton('admin/session')->isAllowed('order/order/actions/view')) {
        //     $this->addColumn('action',
        //         array(
        //             'header'    => Mage::helper('order')->__('Action'),
        //             'width'     => '50px',
        //             'type'      => 'action',
        //             'getter'     => 'getId',
        //             'actions'   => array(
        //                 array(
        //                     'caption' => Mage::helper('order')->__('View'),
        //                     'url'     => array('base'=>'*/order_order/view'),
        //                     'field'   => 'order_id',
        //                     'data-column' => 'action',
        //                 )
        //             ),
        //             'filter'    => false,
        //             'sortable'  => false,
        //             'index'     => 'stores',
        //             'is_system' => true,
        //     ));
        // }
        $this->addRssList('rss/order/new', Mage::helper('order')->__('New Order RSS'));

        $this->addExportType('*/*/exportCsv', Mage::helper('order')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('order')->__('Excel XML'));
        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
            return $this->getUrl('*/adminhtml_order/view', array('order_id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/', array('_current'=>true));
    }

}

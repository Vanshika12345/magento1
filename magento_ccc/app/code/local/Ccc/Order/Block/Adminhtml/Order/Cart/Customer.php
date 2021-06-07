<?php 

class Ccc_Order_Block_Adminhtml_Order_Cart_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
    {
     	$this->_controller = 'adminhtml_order_cart_customer';
     	$this->_blockGroup = 'order';
     	$this->_headerText = 'Please Select a Customer';
     	//$this->removeButton('add');
        $this->_addButtonLabel = Mage::helper('order')->__('Add New Customer');
        parent::__construct();
        

     	$this->addButton('back', [
			'label' => 'Back',
			'onclick' => 'setLocation(\'' . $this->getUrl('*/adminhtml_order/index') . '\')',
			'class' => 'back',
		], 0, 1, 'header');

    }	

    public function getCreateUrl()
    {
        return $this->getUrl('*/adminhtml_customer/new');
    }
}


?>
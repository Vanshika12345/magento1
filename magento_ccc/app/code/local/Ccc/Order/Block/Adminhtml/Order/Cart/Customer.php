<?php 

class Ccc_Order_Block_Adminhtml_Order_Cart_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
    {
        parent::__construct();
     	$this->_controller = 'adminhtml_order_cart_customer';
     	$this->_blockGroup = 'order';
     	$this->_headerText = 'Please Select a Customer';
     	$this->removeButton('add');

     	$this->addButton('back', [
			'label' => 'Back',
			'onclick' => 'setLocation(\'' . $this->getUrl('*/adminhtml_order/index') . '\')',
			'class' => 'back',
		], 0, 1, 'header');

    }	
}


?>
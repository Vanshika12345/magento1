<?php 
class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Product extends Mage_Adminhtml_Block_Widget_Grid_Container{
	
    public function __construct(){
        parent::__construct();
        $this->_controller = 'adminhtml_order_cart_index_product';
        $this->_blockGroup = 'order';
        $this->_headerText = 'Select Products';
        $this->_removeButton('add');
      }
}
?>
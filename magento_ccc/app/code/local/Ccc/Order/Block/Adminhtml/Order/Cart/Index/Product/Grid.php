<?php

class Ccc_Order_Block_Adminhtml_Order_Cart_Index_Product_Grid extends Mage_Core_BLock_Template
{
    protected $_moveToCustomerStorage = true;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('order/cart/index/product/grid.phtml');
    }

    public function getProducts()
    {
        $products = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect('name','inner')
                ->addAttributeToSelect('price','inner');
        if($products){
            return $products->getData();
        }
            return false;
    }

    
}

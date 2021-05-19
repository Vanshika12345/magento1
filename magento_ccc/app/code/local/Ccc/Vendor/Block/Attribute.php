<?php

class Ccc_Vendor_Block_Attribute extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('vendor/attribute/grid.phtml');
        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('vendor')->__('My Products'));
    }
}

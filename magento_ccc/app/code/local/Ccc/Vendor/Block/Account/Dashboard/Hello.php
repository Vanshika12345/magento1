<?php

class Ccc_Vendor_Block_Account_Dashboard_Hello extends Mage_Core_Block_Template
{

    public function getVendorName()
    {
    	$session = Mage::getSingleton('vendor/session')->getVendor();
        $lastname =  $session->getLastname();
        $firstname =  $session->getFirstname();
        return $firstname.' '.$lastname;
    }

}
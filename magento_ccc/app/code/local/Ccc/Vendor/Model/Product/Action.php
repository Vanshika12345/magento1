<?php

class Ccc_Vendor_Model_Product_Action extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('vendor/product_action');
    }

    protected function _getResource()
    {
        return parent::_getResource();
    }

    public function updateAttributes($productIds, $attrData, $storeId)
    {
        Mage::dispatchEvent('vendor_product_attribute_update_before', array(
            'attributes_data' => &$attrData,
            'product_ids'   => &$productIds,
            'store_id'      => &$storeId
        ));

        $this->_getResource()->updateAttributes($productIds, $attrData, $storeId);
        $this->setData(array(
            'product_ids'       => array_unique($productIds),
            'attributes_data'   => $attrData,
            'store_id'          => $storeId
        ));

        // register mass action indexer event
        Mage::getSingleton('index/indexer')->processEntityAction(
            $this, Ccc_Vendor_Model_Product::ENTITY, Mage_Index_Model_Event::TYPE_MASS_ACTION
        );

        Mage::dispatchEvent('vendor_product_attribute_update_after', array(
            'product_ids'   => $productIds,
        ));

        return $this;
    }

    public function updateWebsites($productIds, $websiteIds, $type)
    {
        Mage::dispatchEvent('vendor_product_website_update_before', array(
            'website_ids'   => $websiteIds,
            'product_ids'   => $productIds,
            'action'        => $type
        ));

        if ($type == 'add') {
            Mage::getModel('vendor/product_website')->addProducts($websiteIds, $productIds);
        } else if ($type == 'remove') {
            Mage::getModel('vendor/product_website')->removeProducts($websiteIds, $productIds);
        }

        $this->setData(array(
            'product_ids' => array_unique($productIds),
            'website_ids' => $websiteIds,
            'action_type' => $type
        ));

        // register mass action indexer event
        Mage::getSingleton('index/indexer')->processEntityAction(
            $this, Ccc_Vendor_Model_Product::ENTITY, Mage_Index_Model_Event::TYPE_MASS_ACTION
        );

        // add back compatibility system event
        Mage::dispatchEvent('vendor_product_website_update', array(
            'website_ids'   => $websiteIds,
            'product_ids'   => $productIds,
            'action'        => $type
        ));
    }
}
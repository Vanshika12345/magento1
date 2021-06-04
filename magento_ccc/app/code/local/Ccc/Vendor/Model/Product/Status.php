<?php

class Ccc_Vendor_Model_Product_Status extends Mage_Core_Model_Abstract
{
    const STATUS_ENABLED    = 1;
    const STATUS_DISABLED   = 2;

    protected $_attribute;

    protected function _construct()
    {
        $this->_init('vendor/product_status');
    }

    protected function _getResource()
    {
        return parent::_getResource();
    }

    
    public function getProductAttribute($attributeCode)
    {
        return $this->_getResource()->getProductAttribute($attributeCode);
    }

    
    public function addVisibleFilterToCollection(Mage_Eav_Model_Entity_Collection_Abstract $collection)
    {
        //$collection->addAttributeToFilter('status', array('in'=>$this->getVisibleStatusIds()));
        return $this;
    }

    public function addSaleableFilterToCollection(Mage_Eav_Model_Entity_Collection_Abstract $collection)
    {
        //$collection->addAttributeToFilter('status', array('in'=>$this->getSaleableStatusIds()));
        return $this;
    }

   
    public function getVisibleStatusIds()
    {
        return array(self::STATUS_ENABLED);
    }

    public function getSaleableStatusIds()
    {
        return array(self::STATUS_ENABLED);
    }

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('vendor')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('vendor')->__('Disabled')
        );
    }

    static public function getAllOption()
    {
        $options = self::getOptionArray();
        array_unshift($options, array('value'=>'', 'label'=>''));
        return $options;
    }


    static public function getAllOptions()
    {
        $res = array(
            array(
                'value' => '',
                'label' => Mage::helper('vendor')->__('-- Please Select --')
            )
        );
        foreach (self::getOptionArray() as $index => $value) {
            $res[] = array(
               'value' => $index,
               'label' => $value
            );
        }
        return $res;
    }

    static public function getOptionText($optionId)
    {
        $options = self::getOptionArray();
        return isset($options[$optionId]) ? $options[$optionId] : null;
    }

    public function updateProductStatus($productId, $storeId, $value)
    {
        Mage::getSingleton('vendor/product_action')
            ->updateAttributes(array($productId), array('status' => $value), $storeId);

        // add back compatibility event
        $status = $this->_getResource()->getProductAttribute('status');
        if ($status->isScopeWebsite()) {
            $website = Mage::app()->getStore($storeId)->getWebsite();
            $stores  = $website->getStoreIds();
        } else if ($status->isScopeStore()) {
            $stores = array($storeId);
        } else {
            $stores = array_keys(Mage::app()->getStores());
        }

        foreach ($stores as $storeId) {
            Mage::dispatchEvent('vendor_product_status_update', array(
                'product_id'    => $productId,
                'store_id'      => $storeId,
                'status'        => $value
            ));
        }

        return $this;
    }

    public function getProductStatus($productIds, $storeId = null)
    {
        return $this->getResource()->getProductStatus($productIds, $storeId);
    }


    public function getFlatColums()
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $column = array(
            'unsigned'  => true,
            'default'   => null,
            'extra'     => null
        );

        if (Mage::helper('core')->useDbCompatibleMode()) {
            $column['type']     = 'tinyint';
            $column['is_null']  = true;
        } else {
            $column['type']     = Varien_Db_Ddl_Table::TYPE_SMALLINT;
            $column['nullable'] = true;
            $column['comment']  = 'Vendor Product Status ' . $attributeCode . ' column';
        }

        return array($attributeCode => $column);
    }

    public function getFlatIndexes()
    {
        $indexes = array();

        $index = 'IDX_' . strtoupper($this->getAttribute()->getAttributeCode());
        $indexes[$index] = array(
            'type'      => 'index',
            'fields'    => array($this->getAttribute()->getAttributeCode())
        );

        return $indexes;
    }

    public function getFlatUpdateSelect($store)
    {
        return Mage::getResourceSingleton('eav/entity_attribute')
            ->getFlatUpdateSelect($this->getAttribute(), $store);
    }

    public function setAttribute($attribute)
    {
        $this->_attribute = $attribute;
        return $this;
    }

    public function getAttribute()
    {
        return $this->_attribute;
    }

    public function addValueSortToCollection($collection, $dir = 'asc')
    {
        $attributeCode  = $this->getAttribute()->getAttributeCode();
        $attributeId    = $this->getAttribute()->getId();
        $attributeTable = $this->getAttribute()->getBackend()->getTable();

        if ($this->getAttribute()->isScopeGlobal()) {
            $tableName = $attributeCode . '_t';
            $collection->getSelect()
                ->joinLeft(
                    array($tableName => $attributeTable),
                    "e.entity_id={$tableName}.entity_id"
                        . " AND {$tableName}.attribute_id='{$attributeId}'"
                        . " AND {$tableName}.store_id='0'",
                    array());
            $valueExpr = $tableName . '.value';
        }
        else {
            $valueTable1 = $attributeCode . '_t1';
            $valueTable2 = $attributeCode . '_t2';
            $collection->getSelect()
                ->joinLeft(
                    array($valueTable1 => $attributeTable),
                    "e.entity_id={$valueTable1}.entity_id"
                        . " AND {$valueTable1}.attribute_id='{$attributeId}'"
                        . " AND {$valueTable1}.store_id='0'",
                    array())
                ->joinLeft(
                    array($valueTable2 => $attributeTable),
                    "e.entity_id={$valueTable2}.entity_id"
                        . " AND {$valueTable2}.attribute_id='{$attributeId}'"
                        . " AND {$valueTable2}.store_id='{$collection->getStoreId()}'",
                    array()
                );

                $valueExpr = $collection->getConnection()->getCheckSql(
                    $valueTable2 . '.value_id > 0',
                    $valueTable2 . '.value',
                    $valueTable1 . '.value'
                );
        }

        $collection->getSelect()->order($valueExpr . ' ' . $dir);
        return $this;
    }
}
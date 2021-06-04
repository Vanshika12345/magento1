<?php

abstract class Ccc_Vendor_Model_Abstract extends Mage_Core_Model_Abstract
{
    
    const DEFAULT_STORE_ID = 0;
    protected $_defaultValues = array();
    protected $_storeValuesFlags = array();
    protected $_lockedAttributes = array();
    protected $_isDeleteable = true;
    protected $_isReadonly = false;

    public function lockAttribute($attributeCode)
    {
        $this->_lockedAttributes[$attributeCode] = true;
        return $this;
    }

    public function unlockAttribute($attributeCode)
    {
        if ($this->isLockedAttribute($attributeCode)) {
            unset($this->_lockedAttributes[$attributeCode]);
        }

        return $this;
    }

    public function unlockAttributes()
    {
        $this->_lockedAttributes = array();
        return $this;
    }

    public function getLockedAttributes()
    {
        return array_keys($this->_lockedAttributes);
    }

    public function hasLockedAttributes()
    {
        return !empty($this->_lockedAttributes);
    }

    public function isLockedAttribute($attributeCode)
    {
        return isset($this->_lockedAttributes[$attributeCode]);
    }

    public function setData($key, $value = null)
    {
        if ($this->hasLockedAttributes()) {
            if (is_array($key)) {
                 foreach ($this->getLockedAttributes() as $attribute) {
                     if (isset($key[$attribute])) {
                         unset($key[$attribute]);
                     }
                 }
            } elseif ($this->isLockedAttribute($key)) {
                return $this;
            }
        } elseif ($this->isReadonly()) {
            return $this;
        }

        return parent::setData($key, $value);
    }

    public function unsetData($key = null)
    {
        if ((!is_null($key) && $this->isLockedAttribute($key)) ||
            $this->isReadonly()) {
            return $this;
        }

        return parent::unsetData($key);
    }

    public function getResourceCollection()
    {
        $collection = parent::getResourceCollection()
            ->setStoreId($this->getStoreId());
        return $collection;
    }

    public function loadByAttribute($attribute, $value, $additionalAttributes = '*')
    {
        $collection = $this->getResourceCollection()
            ->addAttributeToSelect($additionalAttributes)
            ->addAttributeToFilter($attribute, $value)
            ->setPage(1,1);

        foreach ($collection as $object) {
            return $object;
        }
        return false;
    }

    public function getStore()
    {
        return Mage::app()->getStore($this->getStoreId());
    }

    public function getWebsiteStoreIds()
    {
        return $this->getStore()->getWebsite()->getStoreIds(true);
    }

    public function setAttributeDefaultValue($attributeCode, $value)
    {
        $this->_defaultValues[$attributeCode] = $value;
        return $this;
    }

    public function getAttributeDefaultValue($attributeCode)
    {
        return array_key_exists($attributeCode, $this->_defaultValues) ? $this->_defaultValues[$attributeCode] : false;
    }

    public function setExistsStoreValueFlag($attributeCode)
    {
        $this->_storeValuesFlags[$attributeCode] = true;
        return $this;
    }

    public function getExistsStoreValueFlag($attributeCode)
    {
        return array_key_exists($attributeCode, $this->_storeValuesFlags);
    }

    protected function _beforeSave()
    {
        $this->unlockAttributes();
        return parent::_beforeSave();
    }

    public function isDeleteable()
    {
        return $this->_isDeleteable;
    }

    public function setIsDeleteable($value)
    {
        $this->_isDeleteable = (bool) $value;
        return $this;
    }

    public function isReadonly()
    {
        return $this->_isReadonly;
    }

    public function setIsReadonly($value)
    {
        $this->_isReadonly = (bool)$value;
        return $this;
    }

}
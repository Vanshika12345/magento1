<?php

class Ccc_Vendor_Model_Form extends Mage_Eav_Model_Form
{
    protected $_moduleName = 'vendor';

    protected $_entityTypeCode = 'vendor';

    protected function _getFormAttributeCollection()
    {
        return parent::_getFormAttributeCollection()
            ->addFieldToFilter('attribute_code', array('neq' => 'created_at'));
    }
}


?>
<?php

class Ccc_Vendor_Block_Product_Attribute_Group_Edit extends Mage_Core_Block_Template
{
	public function getGroupData()
	{
		return Mage::registry('group_data');
	}

	public function getBackUrl()
	{
		return $this->getUrl('*/*/');
	}
}

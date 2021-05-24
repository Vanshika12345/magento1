<?php
$installer = $this;

$installer->startSetup();

$installer->addAttribute(Ccc_Vendor_Model_Product::ENTITY, 'vendor_status', [
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => '',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
]);

$installer->addAttribute(Ccc_Vendor_Model_Product::ENTITY, 'admin_status', [
	'group' => 'General',
	'input' => 'text',
	'type' => 'varchar',
	'label' => '',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
]);

$installer->addAttribute(Ccc_Vendor_Model_Product::ENTITY, 'vendor_id', [
	'group' => 'General',
	'input' => 'text',
	'type' => 'int',
	'label' => '',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
]);

$installer->addAttribute(Ccc_Vendor_Model_Product::ENTITY, 'product_id', [
	'group' => 'General',
	'input' => 'text',
	'type' => 'int',
	'label' => '',
	'backend' => '',
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'searchable' => 1,
	'filterable' => 0,
	'comparable' => 1,
	'visible_on_front' => 1,
	'visible_in_advanced_search' => 0,
	'is_html_allowed_on_front' => 1,
	'global' => 1,
]);

$installer->endSetup();
?>
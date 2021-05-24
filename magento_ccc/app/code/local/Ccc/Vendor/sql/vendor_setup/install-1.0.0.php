<?php

$installer = $this;
$installer->startSetup();
$installer->run( 
    "DROP TABLE IF EXISTS `{$installer->getTable('vendor_int')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_varchar')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_datetime')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_decimal')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_text')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_char')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_eav_attribute')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor')}`;
    DELETE FROM `eav_entity_type` WHERE `entity_type_code` IN('vendor');
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_entity_int')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_entity_varchar')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_entity_datetime')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_entity_decimal')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_entity_text')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_entity_gallery')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_eav_attribute')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_entity')}`;
    DROP TABLE IF EXISTS `{$installer->getTable('vendor_product_group')}`;
    DELETE FROM `eav_entity_type` WHERE `entity_type_code` IN('vendor_product');
    "
    );

$installer->addEntityType(Ccc_Vendor_Model_Resource_Vendor::ENTITY, [
	'entity_model' => 'vendor/vendor',
	'attribute_model' => 'vendor/attribute',
	'table' => 'vendor/vendor',
	'increment_per_store' => '0',
	'additional_attribute_table' => 'vendor/eav_attribute',
	'entity_attribute_collection' => 'vendor/vendor_attribute_collection',
]);

$installer->createEntityTables('vendor');
//$installer->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
	->getAttributeSetId('vendor', 'Default');

$installer->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'vendor'");

$installer->endSetup();
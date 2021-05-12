<?php


$this->startSetup();

$this->addEntityType(Ccc_Practice8_Model_Resource_Practice8::ENTITY,[

	'entity_model' => 'practice8/practice8',
	'attribute_model' => 'practice8/attribute',
	'table' => 'practice8/practice8',
	'increment_per_store' => '0',
	'additional_attribute_table' => 'practice8/eav_attribute',
	'entity_attribute_collection' => 'practice8/practice8_attribute_collection',
]);

$this->createEntityTables('practice8');
$this->installEntities();
$this->endSetup();

?>
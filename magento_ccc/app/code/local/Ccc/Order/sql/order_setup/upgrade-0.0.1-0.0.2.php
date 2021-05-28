<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('order/cart_address'))
	->addColumn('cart_address_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
		'primary' => true,
		'identity' => true,
		'nullable' => false
	],'cartAddressId')
	->addColumn('cart_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
		'nullable' => false
	],'cartId')
	->addColumn('address_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
		'nullable' => true
	],'addressId')
	->addColumn('address_type',Varien_Db_Ddl_Table::TYPE_TINYINT,null,[
		'nullable' => false
	],'addressType')
	->addColumn('street',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,[
		'nullable' => false
	],'street')
	->addColumn('city',Varien_Db_Ddl_Table::TYPE_VARCHAR,80,[
		'nullable' => false
	],'city')
	->addColumn('region',Varien_Db_Ddl_Table::TYPE_VARCHAR,80,[
		'nullable' => false
	],'region')
	->addColumn('country_id',Varien_Db_Ddl_Table::TYPE_VARCHAR,80,[
		'nullable' => false
	],'country_id')
	->addColumn('postcode',Varien_Db_Ddl_Table::TYPE_INTEGER,6,[
		'nullable' => false
	],'postcode')
	->addColumn('same_as_billing',Varien_Db_Ddl_Table::TYPE_TINYINT,null,[
		'nullable' => true
	],'sameAsBilling');

$installer->getConnection()->createTable($table);
$installer->endSetup();	
?>
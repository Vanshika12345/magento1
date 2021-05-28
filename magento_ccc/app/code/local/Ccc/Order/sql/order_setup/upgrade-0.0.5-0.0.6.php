<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
	->newTable($installer->getTable('order/order_address'))
	->addColumn('order_address_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, 20, [
			'identity' => true,
			'nullable' => false,
			'primary' => true,
		], 'Order Address Id'
	)
	->addColumn('order_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, 20, [
			'nullable' => false,
		], 'Order Id'
	)
	->addColumn('addressId',
		Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
			'nullable' => false,
		], 'Address Id'
	)
	->addColumn('address_type',
		Varien_Db_Ddl_Table::TYPE_SMALLINT, null, [
			'nullable' => false,
		], 'Address Type'
	)
	->addColumn('street',
		Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, [
			'nullable' => false,
		], 'Street'
	)
	->addColumn('city',
		Varien_Db_Ddl_Table::TYPE_VARCHAR, 30, [
			'nullable' => false,
		], 'City'
	)
	->addColumn('region',
		Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, [
			'nullable' => false,
		], 'Region'
	)
	->addColumn('country_id',
		Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, [
			'nullable' => false,
		], 'Country Id'
	)
	->addColumn('postcode',
		Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
			'nullable' => false,
		], 'Postcode'
	)
	->addColumn('same_as_billing',
		Varien_Db_Ddl_Table::TYPE_SMALLINT, null, [
			'nullable' => false,
		], 'Same As Billing'
	);

$installer->getConnection()->createTable($table);
$installer->endSetup();	
?>
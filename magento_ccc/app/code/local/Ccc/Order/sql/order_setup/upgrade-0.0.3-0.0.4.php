<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
	->newTable($installer->getTable('order/order'))
	->addColumn('order_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, 20, [
			'identity' => true,
			'nullable' => false,
			'primary' => true,
		], 'Order Id'
	)
	->addColumn('customer_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
			'nullable' => false,
		], 'Customer Id'
	)
	->addColumn('discount',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, null, [
			'nullable' => true,
		], 'Discount'
	)
	->addColumn('total',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, null, [
			'nullable' => false,
		], 'Total'
	)
	->addColumn('payment_code',
		Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
			'nullable' => false,
		], 'Payment Method Code'
	)
	->addColumn('shipment_code',
		Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
			'nullable' => false,
		], 'Shipment Method Code'
	)
	->addColumn('shipping_amount',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, null, [
			'nullable' => false,
		], 'Shipping Amount'
	)
	->addColumn('created_at',
		Varien_Db_Ddl_Table::TYPE_DATETIME, null, [
			'nullable' => true,
		]
	)
	->addForeignKey($installer->getFkName('order','customer_id','customer_entity','entity_id'),'customer_id','customer_entity','entity_id',Varien_Db_Ddl_Table::ACTION_CASCADE,Varien_Db_Ddl_Table::ACTION_CASCADE);

$installer->getConnection()->createTable($table);
$installer->endSetup();

?>
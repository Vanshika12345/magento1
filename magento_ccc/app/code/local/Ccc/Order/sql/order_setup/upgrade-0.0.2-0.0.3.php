<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getconnection()
	->newTable($installer->getTable('order/cart_item'))
	->addColumn('cart_item_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, 20, [
			'identity' => true,
			'nullable' => false,
			'primary' => true,
		], 'Cart Item Id'
	)
	->addColumn('cart_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, 20, [
			'nullable' => false,
		], 'Cart Id'
	)
	->addColumn('product_id',
		Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
			'nullable' => false,
		], 'Product Id'
	)
	->addColumn('quantity',
		Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
			'nullable' => false,
		], 'Quantity'
	)
	->addColumn('base_price',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, null, [
			'nullabe' => true,
		], 'Base Price'
	)
	->addColumn('price',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, null, [
			'nullable' => false,
		], 'Price'
	)
	->addColumn('discount',
		Varien_Db_Ddl_Table::TYPE_DECIMAL, null, [
			'nullable' => true,
		], 'Discount'
	)
	->addColumn('created_at',
		Varien_Db_Ddl_Table::TYPE_DATETIME, null, [
			'nullable' => true,
		]
	);

$installer->getconnection()->createTable($table);
$installer->endSetup();
?>
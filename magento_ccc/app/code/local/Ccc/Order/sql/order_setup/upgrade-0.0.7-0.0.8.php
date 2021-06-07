<?php

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('order/order_status'))
	->addColumn('status_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
		'nullable' => false,
		'primary' => true,
		'identity' => true
	],'Status id')
	->addColumn('order_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
		'nullable' =>false
	],'Order Id')
	->addColumn('status',Varien_Db_Ddl_Table::TYPE_VARCHAR,32,[
		'nullable' => false
	],'Status')
	->addColumn('comment',Varien_Db_Ddl_Table::TYPE_TEXT,255,[
		'nullable' => false
	],'Comment')
	->addColumn('created_date',Varien_Db_Ddl_Table::TYPE_DATETIME,null,[
		'nullable' => false
	],'Created Date')
	->addForeignKey($installer->getFkName('order/order_status','order_id','order/order','order_id'),'order_id',$installer->getTable('order/order'),'order_id',Varien_Db_Ddl_Table::ACTION_CASCADE,Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($table);
$installer->endSetup();	
?>
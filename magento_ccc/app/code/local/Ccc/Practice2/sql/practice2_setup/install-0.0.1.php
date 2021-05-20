<?php

$installer = $this;
$installer->startSetup();


$table = $installer->getConnection()
		->newTable($installer->getTable('practice2/practice2'))
		->addColumn('practice2_id',
			Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
				'identity' => true,
				'primary' => true,
				'nullable' => false
			], 'Id'
		)	
		->addColumn('title',
			Varien_Db_Ddl_Table::TYPE_TEXT,null,[
				'nullable' => false
			],'title'
		)
		->addColumn('createdAt',
			Varien_Db_Ddl_Table::TYPE_TIMESTAMP,null,[
				'nullable' => false
			],'createdAt'
		);

$installer->getConnection()->createTable($table);	
$installer->endSetup();	
?>
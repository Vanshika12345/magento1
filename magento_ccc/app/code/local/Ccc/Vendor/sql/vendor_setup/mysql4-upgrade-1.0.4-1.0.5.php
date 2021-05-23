<?php 
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
			->newTable($installer->getTable('vendor/vendor_group'))
			->addColumn('vendor_group_id',
				Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
					'identity' => true,
					'primary' => true,
					'nullable' => false
				],'vendor_group_id'
			)
			->addColumn('group_id',
				Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
					'nullable' => false
				],'Group_ID'
			)
			->addColumn('entity_id',
				Varien_Db_Ddl_Table::TYPE_INTEGER,null,[
					'nullable' => false
				],'Entity_ID'
			)
			->addColumn('group_name',
				Varien_Db_Ddl_Table::TYPE_TEXT,30,[
					'nullable' => false
				],'Group_Name'	
			)
			->addForeignKey(
        		$installer->getFkName(
            		'vendor/vendor_group',
            		'entity_id',
           			'vendor/vendor',
            		'entity_id'
        	),
        'entity_id', $installer->getTable('vendor/vendor'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
		->addForeignKey(
			$installer->getFkName(
				'vendor/vendor_group',
				'group_id',
				'eav/attribute_group',
				'attribute_group_id'
			),
			'group_id',$installer->getTable('eav/attribute_group'),'attribute_group_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE,Varien_Db_Ddl_Table::ACTION_CASCADE)
		->setComment('vendor Group Table');
$installer->getConnection()->createTable($table);
$installer->endSetup();
<?php

namespace PiraGo\SizeChart\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

            if (!$installer->tableExists('sizechart_rules')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('sizechart_rules')
                )
                    ->addColumn(
                        'rule_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true,
                        ],
                        'Rule ID'
                    )
                    ->addColumn(
                        'name',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'Name'
                    )
                    ->addColumn(
                        'display_type',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Display type'
                    )
                    ->addColumn(
                        'rule_discription',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        '64k',
                        [],
                        'Discription'
                    )
                    ->addColumn(
                        'priority',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        255,
                        [],
                        'Post Tags'
                    )
                    ->addColumn(
                        'status',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        1,
                        [],
                        'Rule Status'
                    )
                    ->addColumn(
                        'url_image',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        [],
                        'Image Url'
                    )
                    ->addColumn(
                        'created_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                        'Created At'
                    )->addColumn(
                        'updated_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                        'Updated At')
                    ->setComment('Post Table');
                $installer->getConnection()->createTable($table);

        }
        $installer->endSetup();
    }
}
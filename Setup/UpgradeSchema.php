<?php

namespace PiraGo\SizeChart\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('sizechart_rules'),
                'template_html',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Template HTML',
                    'after' => 'rule_discription'
                ]
            );

            $installer->getConnection()->addColumn(
                $installer->getTable('sizechart_rules'),
                'template_css',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Template CSS',
                    'after' => 'rule_discription'
                ]
            );

        }
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('sizechart_rules'),
                'store_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Store Id',
                    'after' => 'rule_discription'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.4', '<')) {

            // get table customer_entity
            $eavTable = $setup->getTable('sizechart_rules');

            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($eavTable) == true) {
                $connection = $setup->getConnection();

                // del_flg = column name which you want to delete
                $connection->dropColumn($eavTable, 'store_id');
            }
        }

        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('sizechart_rules'),
                'store_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'comment' => 'Store Id',
                    'after' => 'rule_discription'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.6', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('sizechart_rules'),
                'atr_size',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'comment' => 'Attribute Code',
                    'after' => 'rule_discription'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.7', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('sizechart_rules'),
                'conditions_serialized',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'comment' => 'Conditions Serialized',
                    'after' => 'rule_discription'
                ]
            );
        }




        $installer->endSetup();
    }
}
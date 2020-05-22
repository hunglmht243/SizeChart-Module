<?php

namespace PiraGo\SizeChart\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $_ruleFactory;

    public function __construct(\PiraGo\SizeChart\Model\RuleFactory $ruleFactory)
    {
        $this->_ruleFactory = $ruleFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $data = [
                'name'         => "women",
                'display_type' => "This articlure ",
                'priority'      => 12,
                'status'       => 1
            ];
            $rule = $this->_ruleFactory->create();
            $rule->addData($data)->save();
        }
    }
}
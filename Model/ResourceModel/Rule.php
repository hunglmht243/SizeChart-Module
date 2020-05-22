<?php
namespace PiraGo\SizeChart\Model\ResourceModel;


class Rule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{


    protected function _construct()
    {
        $this->_init('sizechart_rules', 'rule_id');
    }

}
<?php
namespace PiraGo\SizeChart\Model\ResourceModel\Rule;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'rule_id';


    protected function _construct()
    {
        $this->_init('PiraGo\SizeChart\Model\Rule', 'PiraGo\SizeChart\Model\ResourceModel\Rule');
    }

}
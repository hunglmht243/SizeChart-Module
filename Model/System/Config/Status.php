<?php
namespace PiraGo\SizeChart\Model\System\Config;
class Status implements \Magento\Framework\Option\ArrayInterface
{


//Below function is supposed to return options.
    public function toOptionArray()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collec = $objectManager->create('PiraGo\SizeChart\Model\ResourceModel\Rule\CollectionFactory');
        $collecc = $collec->create();
        $arr = [];
        foreach ($collecc->getData() as $rule) {
            $key = $rule['rule_id'];
            $value = $rule['name'];
            $arr[$key] = $value;
        }
        return $arr;
//        return ['0'=>'men', '1'=>'women'] ;
    }
}
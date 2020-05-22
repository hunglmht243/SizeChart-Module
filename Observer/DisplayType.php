<?php

namespace PiraGo\SizeChart\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class DisplayType implements ObserverInterface
{
    protected $ruleFactory;
    protected $_registry;
    protected $_request;
    protected $helpData;
    protected $storeManager;


    public function __construct(
        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \PiraGo\SizeChart\Helper\Data $helpData,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->_registry = $registry;
        $this->_request = $request;
        $this->ruleFactory = $ruleFactory;
        $this->helpData = $helpData;
        $this->storeManager = $storeManager;
    }

    public function execute(Observer $observer)
    {
        if ($this->_request->getFullActionName() == 'catalog_product_view') {

            $product = $this->_registry->registry('current_product');
//            var_dump($product->getCategoryIds());
//            die('aa');
            $rule = $this->ruleFactory->create();
            //$rule->load(20);
            $storeId = $this->storeManager->getStore()->getStoreId();
            $collection = $rule->getCollection();
            $rule2 = $this->ruleFactory->create()->setPriority("100");
            foreach ($collection as $rule1) {
                $storeStr = $rule1->getStoreId();
                if (!((strpos($storeStr, $storeId) === false) && (strpos($storeStr, '0') === false)) &&
                    ($rule1->getConditions()->validate($product)) &&
                    ($rule1->getPriority() < $rule2->getPriority())) {
                    $rule2 = $rule1;
                }
            }
            //die($this->_registry->registry('current_product')->getName());
            if ($rule2->getData('status') == '1') {
                if (strpos($rule2->getDisplayType(), 'Tab') !== false) {
                    $this->_registry->register('tab', '1');
                }
                if (strpos($rule2->getDisplayType(), 'Inline') !== false) {
                    $this->_registry->register('inline', '1');
                }

                $this->_registry->register('ruleId', $rule2->getRuleId());
                $html = $rule2->getData('template_html');
                $css = $rule2->getData('template_css');
                $front = $html . '<br>' . '<style> ' . $css . ' </style>';
                $this->_registry->register('front', $front);
            }


        }
    }

}
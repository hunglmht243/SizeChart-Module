<?php

namespace PiraGo\SizeChart\Controller\Adminhtml\Rule;

class NewConditionHtml extends \Magento\Backend\App\Action
{
    /**
     * New condition html action
     *
     * @return void
     */
//    protected $pageFactory=false;
//    protected $_ruleFactory;
//
//
//    public function ___construct(
//        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory
//
//    )
//    {
//        $this->_ruleFactory = $ruleFactory;
//    }
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $typeArr = explode('|', str_replace('-', '/', $this->getRequest()->getParam('type')));
        $type = $typeArr[0];
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/log02.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info($this->getRequest()->getParams());
        $model = $this->_objectManager->create(
            $type
        )->setId(
            $id
        )->setType(
            $type
        )->setRule(
            $this->_objectManager->create(\PiraGo\SizeChart\Model\Rule::class)
        )->setPrefix(
            'conditions'
        );
        if (!empty($typeArr[1])) {
            $model->setAttribute($typeArr[1]);
        }

        if ($model instanceof \Magento\Rule\Model\Condition\AbstractCondition) {
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $html = $model->asHtmlRecursive();
        } else {
            $html = '';
        }
        $this->getResponse()->setBody($html);
    }
}
<?php

namespace PiraGo\SizeChart\Controller\Adminhtml\Api;

use \Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class GetTemplate extends \Magento\Backend\App\Action
{
    protected $_ruleFactory;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory,
        JsonFactory $resultJsonFactory

    ) {
        $this->_ruleFactory = $ruleFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/log01.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        exit('aaa');
        $rule = $this->_ruleFactory->create();
        $id = $this->getRequest()->getPost('ruleID');
        $getRule = $rule->load($id);
        $html = $getRule->getData('template_html');
        $css = $getRule->getData('template_css');

        $result = $this->resultJsonFactory->create();
        $data = $result->setData([
            'status' => "ok",
            'html' => $html,
            'css' => $css
        ]);
        return $data;
    }

}
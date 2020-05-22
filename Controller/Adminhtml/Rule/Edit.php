<?php
namespace PiraGo\SizeChart\Controller\Adminhtml\Rule;

class Edit extends \Magento\Backend\App\Action
{

    protected $_resultPageFactory;
    protected $coreRegistry = null;

    public function __construct(
//        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
//        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }


    public function execute()
    {
//        $rule = $this->ruleFactory->create();
////        $this->coreRegistry->register(
////            'current_rule',
////            $rule
////        );
//        $id = (int)$this->getRequest()->getParam('id');
//
//        if (!$id && $this->getRequest()->getParam('rule_id')) {
//            $id = (int)$this->getRequest()->getParam('rule_id');
//        }
//
//        if ($id) {
//            $this->coreRegistry->registry('current_rule')->load($id);
//        }
//        $rule->getConditions()->setJsFormObject('rule_conditions_fieldset');
//        $this->coreRegistry->register('current_rule', $rule);
        $resultPage = $this->_resultPageFactory->create();
            //echo $this->getRequest()->getParams()->getData();die();
        return $resultPage;
    }
}

<?php
namespace PiraGo\SizeChart\Controller\Adminhtml\Rule;

class Delete extends \Magento\Backend\App\Action
{
    protected $pageFactory=false;
    protected $_ruleFactory;


    public function __construct(
        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory,
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory

    )
    {   parent::__construct($context);

        $this->_pageFactory = $pageFactory;
        $this->_ruleFactory = $ruleFactory;
    }

    public function execute()
    {
        $rule = $this->_ruleFactory->create();
//        echo '<pre>';
//        print_r($this->getRequest()->getParams());
//        echo '<pre>';die();
        $id= $this->getRequest()->getParams()['id'];
        $rule->load($id)->delete()->save();
            $this->messageManager->addSuccess('xóa thành công');

                return $this->_redirect('*/*');
    }
}
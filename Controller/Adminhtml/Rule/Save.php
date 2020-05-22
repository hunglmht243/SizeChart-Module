<?php

namespace PiraGo\SizeChart\Controller\Adminhtml\Rule;

class Save extends \Magento\Backend\App\Action
{
    protected $ruleFactory;
    protected $_resultPageFactory = false;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->ruleFactory = $ruleFactory;
        $this->_resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        if (!$this->getRequest()->getPostValue()) {
            $this->_redirect('pirago_sizechart/*/');
        }
        $model = $this->ruleFactory->create();
//        $this->_eventManager->dispatch(
//            'adminhtml_controller_pirago_sizechart_prepare_save',
//            ['request' => $this->getRequest()]
//        );
        $data = $this->getRequest()->getPostValue();


        $params = $this->getRequest()->getParams();
        $storeId = implode(',', $params['store_id']);
        $displayType = implode(',', $params['display_type']);
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $model->load($id);
        }
        $model->addData([
            'store_id' => $storeId,
            'display_type' => $displayType,
        ]);

        $data = $this->prepareData($data);
        $model->loadPost($data);
        $model->save();
        $this->messageManager->addSuccessMessage(__('You saved the rule.'));
        if ($this->getRequest()->getParam('back')) {
            if (!$id) {
                return $this->_redirect('*/*/edit', ['id' => $model->getId()]);
            } else {
                return $this->_redirect('*/*/edit', ['id' => $id]);
            }

        }
        return $this->_redirect('*/*');

    }

    /**
     * Prepares specific data
     *
     * @param array $data
     * @return array
     */
    protected function prepareData($data)
    {

        if (isset($data['rule']['conditions'])) {
            $data['conditions'] = $data['rule']['conditions'];
        }

        unset($data['rule']);
        unset($data['store_id']);
        unset($data['display_type']);
        return $data;
    }
}

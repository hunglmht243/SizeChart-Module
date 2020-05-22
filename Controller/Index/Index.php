<?php
namespace PiraGo\SizeChart\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_storeManager;
    protected $_systemStore;
    protected $_collectionFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Model\System\Store $systemStore,
        \PiraGo\SizeChart\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
//        \Magento\Framework\View\Result\PageFactory $pageFactory
    )
    {
//        $this->_pageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->_systemStore = $systemStore;
        $this->_collectionFactory = $collectionFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        echo "aa";
        //$method = $this->_storeManager->getStore()->getId();

        //$collec->load('3','rule_id');
        exit();
        //return $this->_pageFactory->create();
    }
}
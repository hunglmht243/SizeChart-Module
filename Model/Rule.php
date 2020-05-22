<?php

namespace PiraGo\SizeChart\Model;

use Magento\Quote\Model\Quote\Address;
use Magento\Rule\Model\AbstractModel;

class Rule extends AbstractModel
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'vendor_rules';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getRule() in this case
     *
     * @var string
     */
    protected $_eventObject = 'rule';

    /** @var \Magento\SalesRule\Model\Rule\Condition\CombineFactory */
    protected $condCombineFactory;

    /** @var \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory */
    protected $condProdCombineF;

    /**
     * Store already validated addresses and validation results
     *
     * @var array
     */
    protected $validatedAddresses = [];

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\SalesRule\Model\Rule\Condition\CombineFactory $condCombineFactory
     * @param \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory $condProdCombineF
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\CatalogRule\Model\Rule\Condition\CombineFactory $condCombineFactory,
        \Magento\CatalogRule\Model\Rule\Condition\ProductFactory $condProdCombineF,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->condCombineFactory = $condCombineFactory;
        $this->condProdCombineF = $condProdCombineF;
        parent::__construct($context, $registry, $formFactory, $localeDate, $resource, $resourceCollection, $data);
    }

    /**
     * Set resource model and Id field name
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('PiraGo\SizeChart\Model\ResourceModel\Rule');
        $this->setIdFieldName('rule_id');
    }

    /**
     * Get rule condition combine model instance
     *
     * @return \Magento\SalesRule\Model\Rule\Condition\Combine
     */
    public function getConditionsInstance()
    {
        return $this->condCombineFactory->create();
    }

    /**
     * Get rule condition product combine model instance
     *
     * @return \Magento\SalesRule\Model\Rule\Condition\Product\Combine
     */
    public function getActionsInstance()
    {
        return $this->condProdCombineF->create();
    }
}
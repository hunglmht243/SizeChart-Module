<?php
namespace PiraGo\SizeChart\Block;
//use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Category;

//die('aa');
class SizeChart1 extends \Magento\Catalog\Block\Product\View
{
    protected $ruleFactory;
    protected $helpData;
    protected $storeManager;
    protected $_registry;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory,
        \PiraGo\SizeChart\Helper\Data $helpData,
        array $data = []
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->helpData = $helpData;
        $this->storeManager = $storeManager;
        $this->_registry = $registry;
        parent::__construct(
            $context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat,
            $customerSession, $productRepository, $priceCurrency,
            $data
        );
    }

    public function getPath(){
        if ($this->getRule()) {
            if (strpos($this->getType(), 'Popup') !== false) {
                $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'upload/' . $this->laygiatri();
                return $mediaUrl;
            }
        }
        return false;
   }
    public function laygiatri(){
        return $this->helpData->getGeneralConfig('icon');
    }

    public function getType()
    {
        if ($this->getRule()) {
            //$this->_registry->register('tabb','1');
            return $this->getRule()->getData('display_type');
        }
        return false;

    }

    public function getRule()
    {
        $id = $this->_registry->registry('ruleId');
        if ($id) {
            $rule = $this->ruleFactory->create();
            $rule->load($id);
            return $rule;
        }
        return false;

    }

    public function getFront()
    {
        if ($this->getRule() !== false) {
//            if (strpos($this->getType(), 'Tab') !== false){
            $html = $this->getRule()->getData('template_html');
            $css = $this->getRule()->getData('template_css');
            return $html . '<br>' . '<style> ' . $css . ' </style>';
//        }
        }
        return false;
    }

    public function getTestt()
    {

        return 'aa';
    }

}
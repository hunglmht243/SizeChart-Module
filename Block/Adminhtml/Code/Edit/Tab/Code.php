<?php
namespace PiraGo\SizeChart\Block\Adminhtml\Code\Edit\Tab;
use Magento\Store\Model\ScopeInterface;
use PiraGo\SizeChart\Model\System\Config\Status;

class Code extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    protected $helperData;
    protected $_ruleFactory;
    protected $_status;
    protected $_systemStore;
    public function __construct(

        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory,
        \PiraGo\SizeChart\Helper\Data $helperData,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        Status $status,
        array $data = []
    )
    {

        $this->_ruleFactory = $ruleFactory;
        $this->helperData = $helperData;
        $this->_status = $status;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $rule = $this->_ruleFactory->create();
        $fieldset = $form->addFieldset('rule_form_1', ['legend' => __('Information')]);
        if ($this->getRequest()->getParam('id') == null) {
            $fieldset->addField(
                'name',
                'text',
                [
                    'label' => 'Name',
                    'name' => 'name',
                    'required' => 'true'
                ]
            );
            $fieldset->addField(
                'description',
                'text',
                [
                    'label' => 'Description',
                    'name' => 'rule_discription'
                ]
            );
            $fieldset->addField(
                'active',
                'select',
                [
                    'label' => 'Active',
                    'name' => 'status',
                    'options' => ['1' => __('Yes'), '0' => __('No')]
                ]
            );
            $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'store_id',
                    'label' => __('Store Views'),
                    'title' => __('Store Views'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true),
                ]
            );
            $fieldset->addField(
                'priority',
                'text',
                [
                    'label' => 'Priority',
                    'name' => 'priority',
                    'required' => 'true'
                ]
            );


        } else {
            $id = $this->getRequest()->getParam('id');
            $thisRule = $rule->load($id);
            $fieldset->addField(
                'id',
                'hidden',
                [
                    'label' => 'Id',
                    'name' => 'id',
                    'value' => $id,
                    //'disabled' => 'true'

                ]
            );
            $name = $thisRule->getData('name');
            $fieldset->addField(
                'name',
                'text',
                [
                    'label' => 'Name',
                    'name' => 'name',
                    'required' => 'true',
                    'value' => $name
                ]
            );
            $description = $thisRule->getData('rule_discription');
            $fieldset->addField(
                'description',
                'text',
                [
                    'label' => 'Description',
                    'name' => 'rule_discription',
                    'value' => $description
                ]
            );
            $status = $thisRule->getData('status');
            $fieldset->addField(
                'active',
                'select',
                [
                    'label' => 'Active',
                    'name' => 'status',
                    'options' => ['1' => __('Yes'), '0' => __('No')],
                    'value' => $status
                ]
            );
            $storeId = $thisRule->getData('store_id');
            $storeId = explode(',', $storeId);
            $storeId = '["' . implode('", "', $storeId) . '"]';
            $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'store_id',
                    'label' => __('Store Views'),
                    'title' => __('Store Views'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true),
                    'after_element_html' => '   <script type="text/javascript">
                                        require([\'jquery\', \'jquery/ui\'], function($){
                                            $(document).ready( function() {
                                                 var array = ' . $storeId . ';
                                                 //console.log(array);
//                                                 var a=[1,2];
//                                                 console.log(a);["Popup","Tab"]
                                                 $("#store_id").val(array);                                                                         
                                                                          
                                                         });
                                                });
                                                      
                                                </script>

                                                '
                ]
            );
            $priority = $thisRule->getData('priority');
            $fieldset->addField(
                'priority',
                'text',
                [
                    'label' => 'Priority',
                    'name' => 'priority',
                    'required' => 'true',
                    'value' => $priority
                ]
            );


        }


        $this->setForm($form);
        return parent::_prepareForm();
    }


    public function getTabLabel()
    {
        return __('General Information');
    }

    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}

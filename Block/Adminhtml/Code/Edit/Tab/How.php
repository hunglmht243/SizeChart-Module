<?php
namespace PiraGo\SizeChart\Block\Adminhtml\Code\Edit\Tab;
use Magento\Store\Model\ScopeInterface;

class How extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    protected $helperData;
    protected $_ruleFactory;
    protected $_systemStore;
    public function __construct(

        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory,
        \PiraGo\SizeChart\Helper\Data $helperData,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    )
    {

        $this->_ruleFactory = $ruleFactory;
        $this->helperData = $helperData;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $rule = $this->_ruleFactory->create();
        $fieldset = $form->addFieldset('rule_form_4', ['legend' => __('How Size Chart will be shown')]);
        if ($this->getRequest()->getParam('id') == null) {
            $fieldset->addField(
                'display_type',
                'multiselect',
                [
                    'name'     => 'display_type',
                    'label'    => __('Store Views'),
                    'title'    => __('Store Views'),
                    'values'   => [
                        ['value' => 'Popup', 'label' => 'Popup'],
                        ['value' => 'Inline', 'label' => 'Inline: Under Add to Cart Button'],
                        ['value' => 'Tab', 'label' => 'Product Tab']
                    ],
//                    'after_element_html' => '   <script type="text/javascript">
//                                                      jQuery(document).ready(function() {
//                                                        jQuery("#display_type").change(function() {
//                                                            if (jQuery(this).val()!==0){
//                                                                jQuery("#atr_size").attr("type","hidden");
//                                                            }
//                                                        })
//                                                        });
//                                                </script>
//
//                                                '
                ]
            );
            $fieldset->addField(
                'atr_size',
                'text',
                [
                    'label' =>'Attribute Code',
                    'name' => 'atr_size',
                    'required' => 'true'
                ]
            );


        } else {
            $id = $this->getRequest()->getParam('id');
            $thisRule = $rule->load($id);
            $displayTypee = $thisRule->getData('display_type');
            $displayType = explode(',', $displayTypee);
            $display = '["' . implode('", "', $displayType) . '"]';
            $fieldset->addField(
                'display_type',
                'multiselect',
                [
                    'name' => 'display_type',
                    'label' => __('Store Views'),
                    'title' => __('Store Views'),
                    'values' => [
                        ['value' => 'Popup', 'label' => 'Popup'],
                        ['value' => 'Inline', 'label' => 'Inline: Under Add to Cart Button'],
                        ['value' => 'Tab', 'label' => 'Product Tab']
                    ],
                    'after_element_html' => '   <script type="text/javascript">
                                        require([\'jquery\', \'jquery/ui\'], function($){
                                            $(document).ready( function() {
                                                 var array = ' . $display . ';
                                                 //console.log(array);
//                                                 var a=[1,2];
//                                                 console.log(a);["Popup","Tab"]
                                                 $("#display_type").val(array);                                                                         
                                                                          
                                                         });
                                                });
                                                      
                                                </script>

                                                '
                ]
            );
            $atrSize = $thisRule->getData('atr_size');
            $fieldset->addField(
                'atr_size',
                'text',
                [
                    'label' => 'Attribute Code',
                    'name' => 'atr_size',
                    'required' => 'true',
                    'value' => $atrSize
                ]
            );


        }


        $this->setForm($form);
        return parent::_prepareForm();
    }


    public function getTabLabel()
    {
        return __('How To Show');
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

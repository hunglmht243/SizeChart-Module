<?php
namespace PiraGo\SizeChart\Block\Adminhtml\Code\Edit\Tab;
use Magento\Store\Model\ScopeInterface;
use Magento\Cms\Model\Wysiwyg\Config;
class What extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    protected $helperData;
    protected $_ruleFactory;
    protected $_wysiwygConfig;
    protected $_status;
    public function __construct(

        \PiraGo\SizeChart\Model\RuleFactory $ruleFactory,
        \PiraGo\SizeChart\Helper\Data $helperData,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        Config $wysiwygConfig,
        \PiraGo\SizeChart\Model\System\Config\Status $status,
        array $data = []
    )
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_ruleFactory = $ruleFactory;
        $this->helperData = $helperData;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $wysiwygConfig = $this->_wysiwygConfig->getConfig();

        $form = $this->_formFactory->create();
        $rule = $this->_ruleFactory->create();
        $fieldset = $form->addFieldset('rule_form_2', ['legend' => __('Size Chart Template')]);
        if ($this->getRequest()->getParam('id') == null) {
            $fieldset->addField(
                'template_html',
                'editor',
                [
                    'name' => 'template_html',
                    'label' => __('Template HTML'),
                    'required' => true,
                    'config' => $wysiwygConfig
                ]
            );
            $fieldset->addField(
                'template_css',
                'textarea',
                [
                    'name' => 'template_css',
                    'label' => 'Template CSS',
                ]
            );
            $url = $this->getUrl('pirago/api/gettemplate');
            $fieldset->addField(
                'template',
                'select',
                [
                    'label' => 'Template',
                    'name' => 'rule',
                    'options' => $this->_status->toOptionArray(),
//                    'component' => 'PiraGo/SizeChart/js/form/element/options',
                    'after_element_html' => '<button type="button" onclick="f()">Load</button>
                                                <script type="text/javascript">
                                                      function f() {                                                          
                                                        var ruleID= jQuery("#template").val();
                                                       
                                                          jQuery.ajax({
                                                             url: "' . $url . '",
                                                             type: "POST",
                                                             data: {ruleID: ruleID},
                                                             //dataType: "json",
                                                             success: function (response) {
                                                                //console.log(response);
                                                                //var jsonn= response.reponseJSON;
                                                                tinyMCE.get("template_html").setContent(response.html);
                                                                jQuery("#template_css").val(response.css);

                                                             }
                                                          });
                                                      };                                                   
        
                                                </script>
                                                
                                                '
                ]
            );


        } else {
            $id = $this->getRequest()->getParam('id');
            $thisRule = $rule->load($id);
            $html = $thisRule->getData('template_html');
            $fieldset->addField(
                'template_html',
                'editor',
                [
                    'name' => 'template_html',
                    'label' => __('Template HTML'),
                    'required' => true,
                    'config' => $wysiwygConfig,
                    'value' => $html
                ]
            );
            $css = $thisRule->getData('template_css');
            $fieldset->addField(
                'template_css',
                'textarea',
                [
                    'name' => 'template_css',
                    'label' => 'Template CSS',
                    'value' => $css
                ]
            );
            $url = $this->getUrl('pirago/api/gettemplate');
            $fieldset->addField(
                'template',
                'select',
                [
                    'value' => $id,
                    'label' => 'Template',
                    'name' => 'rule',
                    'options' => $this->_status->toOptionArray(),
//                    'component' => 'PiraGo/SizeChart/js/form/element/options',
                    'after_element_html' => '<button type="button" onclick="f()">Load</button>
                                                <script type="text/javascript">
                                                      function f() {                                                          
                                                        var ruleID= jQuery("#template").val();
                                                       
                                                          jQuery.ajax({
                                                             url: "' . $url . '",
                                                             type: "POST",
                                                             data: {ruleID: ruleID},
                                                             //dataType: "json",
                                                             success: function (response) {
                                                                //console.log(response);
                                                                //var jsonn= response.reponseJSON;
                                                                tinyMCE.get("template_html").setContent(response.html);
                                                                jQuery("#template_css").val(response.css);

                                                             }
                                                          });
                                                      };                                                   
        
                                                </script>
                                                
                                                '
                ]
            );
        }


        $this->setForm($form);
        return parent::_prepareForm();
    }


    public function getTabLabel()
    {
        return __('What To Show');
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

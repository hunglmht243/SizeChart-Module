<?php
namespace PiraGo\SizeChart\Block\Adminhtml\Code;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'PiraGo_SizeChart';
        $this->_controller = 'adminhtml_code'; //đường dẫn block controller
        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Rule'));
//        $this->buttonList->update('delete','onclick', 'deleteConfirm(\'' . __(
//                'Are you sure you want to do this?'
//            ) . '\', \'' . $this->getDeleteUrl() . '\', {data: {}})');
        $this->buttonList->add(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            1
        );
    }

}

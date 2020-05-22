<?php

namespace PiraGo\SizeChart\Block;


class Inline extends \Magento\Framework\View\Element\Template
{


    protected $_coreRegistry = null;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getFront()
    {
        $inline = $this->_coreRegistry->registry('inline');
        if ($inline == '1') {
            return $this->_coreRegistry->registry('front');
        }
        return false;
    }

}

<?php
namespace PiraGo\SizeChart\Block\Adminhtml\Code\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('sizechart_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Size Chart rule Information aaa'));
    }

//    protected function _beforeToHtml()
//    {
//        //other tabs
//        $this->addTab(
//            'what_to_show',
//            [
//                'label' => __('General'),
//                'title' => __('General'),
//                'content' => $this->getLayout()->createBlock(
//                    'PiraGo\SizeChart\Block\Adminhtml\Code\Edit\Tab\What'
//                )->toHtml(),
//                'active' => true
//            ]
//        );
//        $this->addTab(
//            'where_to_show',
//            [
//                'label' => __('General'),
//                'title' => __('General'),
//                'content' => $this->getLayout()->createBlock(
//                    'PiraGo\SizeChart\Block\Adminhtml\Code\Edit\Tab\Where'
//                )->toHtml(),
//                'active' => true
//            ]
//        );
//        $this->addTab(
//            'how_to_show',
//            [
//                'label' => __('General'),
//                'title' => __('General'),
//                'content' => $this->getLayout()->createBlock(
//                    'PiraGo\SizeChart\Block\Adminhtml\Code\Edit\Tab\How'
//                )->toHtml(),
//                'active' => true
//            ]
//        );
//
//        return parent::_beforeToHtml();
//    }

//    public  function showHello($text1,$text2){
//        echo $text1.$text2;die();
//    }
}

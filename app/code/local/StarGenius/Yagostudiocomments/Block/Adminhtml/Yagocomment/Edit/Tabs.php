<?php
/**
 * StarGenius_Yagostudiocomments extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_Yagostudiocomments
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * YagoComment admin edit tabs
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudiocomments
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudiocomments_Block_Adminhtml_Yagocomment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('yagocomment_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('stargenius_yagostudiocomments')->__('YagoComment'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return StarGenius_Yagostudiocomments_Block_Adminhtml_Yagocomment_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_yagocomment',
            array(
                'label'   => Mage::helper('stargenius_yagostudiocomments')->__('YagoComment'),
                'title'   => Mage::helper('stargenius_yagostudiocomments')->__('YagoComment'),
                'content' => $this->getLayout()->createBlock(
                    'stargenius_yagostudiocomments/adminhtml_yagocomment_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_yagocomment',
                array(
                    'label'   => Mage::helper('stargenius_yagostudiocomments')->__('Store views'),
                    'title'   => Mage::helper('stargenius_yagostudiocomments')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'stargenius_yagostudiocomments/adminhtml_yagocomment_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve yagocomment entity
     *
     * @access public
     * @return StarGenius_Yagostudiocomments_Model_Yagocomment
     * @author Ultimate Module Creator
     */
    public function getYagocomment()
    {
        return Mage::registry('current_yagocomment');
    }
}

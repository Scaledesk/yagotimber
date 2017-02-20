<?php
/**
 * StarGenius_Yagostudio extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_Yagostudio
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Yagostudio comment admin edit tabs
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Comment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('yagostudio_comment_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('stargenius_yagostudio')->__('Yagostudio Comment'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_yagostudio_comment',
            array(
                'label'   => Mage::helper('stargenius_yagostudio')->__('Yagostudio comment'),
                'title'   => Mage::helper('stargenius_yagostudio')->__('Yagostudio comment'),
                'content' => $this->getLayout()->createBlock(
                    'stargenius_yagostudio/adminhtml_yagostudio_comment_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_yagostudio_comment',
                array(
                    'label'   => Mage::helper('stargenius_yagostudio')->__('Store views'),
                    'title'   => Mage::helper('stargenius_yagostudio')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'stargenius_yagostudio/adminhtml_yagostudio_comment_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve comment
     *
     * @access public
     * @return StarGenius_Yagostudio_Model_Yagostudio_Comment
     * @author Ultimate Module Creator
     */
    public function getComment()
    {
        return Mage::registry('current_comment');
    }
}

<?php
/**
 * StarGenius_AskAnExpert extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_AskAnExpert
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Question admin edit tabs
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author      Ultimate Module Creator
 */
class StarGenius_AskAnExpert_Block_Adminhtml_Questions_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('questions_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('stargenius_askanexpert')->__('Question'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return StarGenius_AskAnExpert_Block_Adminhtml_Questions_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_questions',
            array(
                'label'   => Mage::helper('stargenius_askanexpert')->__('Question'),
                'title'   => Mage::helper('stargenius_askanexpert')->__('Question'),
                'content' => $this->getLayout()->createBlock(
                    'stargenius_askanexpert/adminhtml_questions_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'form_meta_questions',
            array(
                'label'   => Mage::helper('stargenius_askanexpert')->__('Meta'),
                'title'   => Mage::helper('stargenius_askanexpert')->__('Meta'),
                'content' => $this->getLayout()->createBlock(
                    'stargenius_askanexpert/adminhtml_questions_edit_tab_meta'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_questions',
                array(
                    'label'   => Mage::helper('stargenius_askanexpert')->__('Store views'),
                    'title'   => Mage::helper('stargenius_askanexpert')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'stargenius_askanexpert/adminhtml_questions_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve question entity
     *
     * @access public
     * @return StarGenius_AskAnExpert_Model_Questions
     * @author Ultimate Module Creator
     */
    public function getQuestions()
    {
        return Mage::registry('current_questions');
    }
}

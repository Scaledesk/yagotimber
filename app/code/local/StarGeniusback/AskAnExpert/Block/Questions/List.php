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
 * Question list block
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author Ultimate Module Creator
 */
class StarGenius_AskAnExpert_Block_Questions_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $questionss = Mage::getResourceModel('stargenius_askanexpert/questions_collection')
                         ->addStoreFilter(Mage::app()->getStore())
                         ->addFieldToFilter('status', 1);
        $questionss->setOrder('name', 'asc');
        $this->setQuestionss($questionss);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return StarGenius_AskAnExpert_Block_Questions_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'stargenius_askanexpert.questions.html.pager'
        )
        ->setCollection($this->getQuestionss());
        $this->setChild('pager', $pager);
        $this->getQuestionss()->load();
        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}

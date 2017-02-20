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
 * Question widget block
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author      Ultimate Module Creator
 */
class StarGenius_AskAnExpert_Block_Questions_Widget_View extends Mage_Core_Block_Template implements
    Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'stargenius_askanexpert/questions/widget/view.phtml';

    /**
     * Prepare a for widget
     *
     * @access protected
     * @return StarGenius_AskAnExpert_Block_Questions_Widget_View
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $questionsId = $this->getData('questions_id');
        if ($questionsId) {
            $questions = Mage::getModel('stargenius_askanexpert/questions')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($questionsId);
            if ($questions->getStatus()) {
                $this->setCurrentQuestions($questions);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }
}

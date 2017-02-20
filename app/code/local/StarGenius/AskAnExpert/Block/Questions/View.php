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
 * Question view block
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author      Ultimate Module Creator
 */
class StarGenius_AskAnExpert_Block_Questions_View extends Mage_Core_Block_Template
{
    /**
     * get the current question
     *
     * @access public
     * @return mixed (StarGenius_AskAnExpert_Model_Questions|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentQuestions()
    {
        return Mage::registry('current_questions');
    }
}

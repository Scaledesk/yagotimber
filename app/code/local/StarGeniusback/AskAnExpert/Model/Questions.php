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
 * Question model
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author      Ultimate Module Creator
 */
class StarGenius_AskAnExpert_Model_Questions extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'stargenius_askanexpert_questions';
    const CACHE_TAG = 'stargenius_askanexpert_questions';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'stargenius_askanexpert_questions';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'questions';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('stargenius_askanexpert/questions');
    }

    /**
     * before save question
     *
     * @access protected
     * @return StarGenius_AskAnExpert_Model_Questions
     * @author Ultimate Module Creator
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * get the url to the question details page
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getQuestionsUrl()
    {
        if ($this->getUrlKey()) {
            $urlKey = '';
            if ($prefix = Mage::getStoreConfig('stargenius_askanexpert/questions/url_prefix')) {
                $urlKey .= $prefix.'/';
            }
            $urlKey .= $this->getUrlKey();
            if ($suffix = Mage::getStoreConfig('stargenius_askanexpert/questions/url_suffix')) {
                $urlKey .= '.'.$suffix;
            }
            return Mage::getUrl('', array('_direct'=>$urlKey));
        }
        return Mage::getUrl('stargenius_askanexpert/questions/view', array('id'=>$this->getId()));
    }

    /**
     * check URL key
     *
     * @access public
     * @param string $urlKey
     * @param bool $active
     * @return mixed
     * @author Ultimate Module Creator
     */
    public function checkUrlKey($urlKey, $active = true)
    {
        return $this->_getResource()->checkUrlKey($urlKey, $active);
    }

    /**
     * get the question Question Asked
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getQuestionasked()
    {
        $questionasked = $this->getData('questionasked');
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($questionasked);
        return $html;
    }

    /**
     * get the question Expert Reply
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getExpertreply()
    {
        $expertreply = $this->getData('expertreply');
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($expertreply);
        return $html;
    }

    /**
     * save question relation
     *
     * @access public
     * @return StarGenius_AskAnExpert_Model_Questions
     * @author Ultimate Module Creator
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        $values['in_rss'] = 1;
        return $values;
    }
    
}

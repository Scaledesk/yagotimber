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
 * YagoComment model
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudiocomments
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudiocomments_Model_Yagocomment extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'stargenius_yagostudiocomments_yagocomment';
    const CACHE_TAG = 'stargenius_yagostudiocomments_yagocomment';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'stargenius_yagostudiocomments_yagocomment';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'yagocomment';

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
        $this->_init('stargenius_yagostudiocomments/yagocomment');
    }

    /**
     * before save yagocomment
     *
     * @access protected
     * @return StarGenius_Yagostudiocomments_Model_Yagocomment
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
     * get the yagocomment Comment Content
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getCommentContent()
    {
        $comment_content = $this->getData('comment_content');
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($comment_content);
        return $html;
    }

    /**
     * save yagocomment relation
     *
     * @access public
     * @return StarGenius_Yagostudiocomments_Model_Yagocomment
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
        return $values;
    }
    
}

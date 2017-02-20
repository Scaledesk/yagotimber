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
 * Yagostudio comment list block
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author Ultimate Module Creator
 */
class StarGenius_Yagostudio_Block_Yagostudio_Comment_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $yagostudio = $this->getYagostudio();
        $comments = Mage::getResourceModel('stargenius_yagostudio/yagostudio_comment_collection')
            ->addFieldToFilter('yagostudio_id', $yagostudio->getId())
            ->addStoreFilter(Mage::app()->getStore())
             ->addFieldToFilter('status', 1);
        $comments->setOrder('created_at', 'asc');
        $this->setComments($comments);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Yagostudio_Comment_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'stargenius_yagostudio.yagostudio.html.pager'
        )
        ->setCollection($this->getComments());
        $this->setChild('pager', $pager);
        $this->getComments()->load();
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
    /**
     * get the current yagostudio
     *
     * @access protected
     * @return StarGenius_Yagostudio_Model_Yagostudio
     * @author Ultimate Module Creator
     */
    public function getYagostudio()
    {
        return Mage::registry('current_yagostudio');
    }
}

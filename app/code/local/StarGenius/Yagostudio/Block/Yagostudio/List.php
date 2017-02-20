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
 * Yagostudio list block
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author Ultimate Module Creator
 */
class StarGenius_Yagostudio_Block_Yagostudio_List extends Mage_Core_Block_Template
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
        $yagostudios = Mage::getResourceModel('stargenius_yagostudio/yagostudio_collection')
                         ->addStoreFilter(Mage::app()->getStore())
                         ->addFieldToFilter('status', 1);
        $yagostudios->setOrder('designer_name', 'asc');
        $this->setYagostudios($yagostudios);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Yagostudio_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'stargenius_yagostudio.yagostudio.html.pager'
        )
        ->setCollection($this->getYagostudios());
        $this->setChild('pager', $pager);
        $this->getYagostudios()->load();
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

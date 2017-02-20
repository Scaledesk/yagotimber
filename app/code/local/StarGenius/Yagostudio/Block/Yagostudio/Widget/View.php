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
 * Yagostudio widget block
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Block_Yagostudio_Widget_View extends Mage_Core_Block_Template implements
    Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'stargenius_yagostudio/yagostudio/widget/view.phtml';

    /**
     * Prepare a for widget
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Yagostudio_Widget_View
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $yagostudioId = $this->getData('yagostudio_id');
        if ($yagostudioId) {
            $yagostudio = Mage::getModel('stargenius_yagostudio/yagostudio')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($yagostudioId);
            if ($yagostudio->getStatus()) {
                $this->setCurrentYagostudio($yagostudio);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }
}

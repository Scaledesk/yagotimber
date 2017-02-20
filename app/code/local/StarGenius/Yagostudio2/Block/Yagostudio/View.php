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
 * Yagostudio view block
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Block_Yagostudio_View extends Mage_Core_Block_Template
{
    /**
     * get the current yagostudio
     *
     * @access public
     * @return mixed (StarGenius_Yagostudio_Model_Yagostudio|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentYagostudio()
    {
        return Mage::registry('current_yagostudio');
    }
}

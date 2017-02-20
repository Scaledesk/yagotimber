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
 * Yagostudio helper
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Helper_Yagostudio extends Mage_Core_Helper_Abstract
{

    /**
     * get the url to the yagostudios list page
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getYagostudiosUrl()
    {
        if ($listKey = Mage::getStoreConfig('stargenius_yagostudio/yagostudio/url_rewrite_list')) {
            return Mage::getUrl('', array('_direct'=>$listKey));
        }
        return Mage::getUrl('stargenius_yagostudio/yagostudio/index');
    }

    /**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getUseBreadcrumbs()
    {
        return Mage::getStoreConfigFlag('stargenius_yagostudio/yagostudio/breadcrumbs');
    }
}

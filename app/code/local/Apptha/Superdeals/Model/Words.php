<?php

/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_Marketplace
 * @version     1.2.3
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2014 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 * 
 */

class Apptha_Superdeals_Model_Words 
{
    /*
     * Notify mail details by getting number of days 
     */
    public function toOptionArray() 
    {
        return array(
            array('value' => 1, 'label' => Mage::helper('superdeals')->__('1 Day')),
            array('value' => 2, 'label' => Mage::helper('superdeals')->__('2 Days')),
            array('value' => 3, 'label' => Mage::helper('superdeals')->__('3 Days')),
            array('value' => 4, 'label' => Mage::helper('superdeals')->__('4 Days')),
        );
    }

}

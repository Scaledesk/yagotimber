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

/**
 * View order details page functionality
 */
class Apptha_Marketplace_Block_Order_Vieworder extends Mage_Core_Block_Template {

    /**
     * Function to get particular order information
     * 
     * Passed the order id to get that order information
     * @param $orderId
     * 
     * Return order details
     * @return array
     */
    function viewOrder($orderId) {
        $order = Mage::getModel('marketplace/commission')->getCollection();
        $order->addFieldToSelect('*');
        $order->addFieldToFilter('seller_id', Mage::getSingleton('customer/session')->getCustomer()->getId());
        $order->addFieldToFilter('order_id', $orderId);
        return $order;
    }
    
    /**
     * get the order item shippemnt submit url

     * @return String
     */
    public function getShipPostUrl($orderId){
    	return $this->getUrl('marketplace/shipment/savePost',array(
    		'order_id'=>$orderId,
    	));
    }

}
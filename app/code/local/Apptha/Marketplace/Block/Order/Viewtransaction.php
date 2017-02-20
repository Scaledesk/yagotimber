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
 * View transaction details page functionality
 */
class Apptha_Marketplace_Block_Order_Viewtransaction extends Mage_Core_Block_Template {

    protected function _prepareLayout() {
        parent::_prepareLayout();
        $collection = $this->getTransactionhistory();
        $this->setCollection($collection);
        $pager = $this->getLayout()
                ->createBlock('page/html_pager', 'my.pager')
                ->setCollection($collection);
        $pager->setAvailableLimit(array(10 => 10, 20 => 20, 50 => 50));    
        $this->setChild('pager', $pager);
        return $this;
    }

    /**
     * Function to get the Pagination
     * 
     * Return the collection for pagination
     * @return array
     */
    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }

    /**
     * Get transaction details of particular seller
     * 
     * Return the transaction details
     * @return array
     */
    public function getTransactionhistory() {
        $customer = Mage::getSingleton("customer/session")->getCustomer();
        $customerId = $customer->getId();
        $collection = Mage::getModel('marketplace/transaction')->getCollection()->addFieldToFilter('seller_id', $customerId)->addFieldToFilter('paid', 1)->setOrder('id', 'DESC');
        return $collection;
    }

    /**
     * To get the acknowlege url 
     * 
     * Passed the commission id to update the acknowledge date
     * @param int $commission_id
     * 
     * Return the acknowledge action url
     * @return string
     */
    public function getAcknowledge($commissionId) {
        return Mage::getUrl('marketplace/order/acknowledge', array('commissionid' => $commissionId));
    }

}


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

class Apptha_Marketplace_Block_Adminhtml_Commission_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    /**
     * Construct the inital display of grid information
     * Setting the Block files group for this grid
     * Setting the Setting the Object id
     * Setting the Controller file for this grid     
     */
    public function __construct() {
        parent::__construct();
        $this->_removeButton('reset');
        $this->_removeButton('delete');
        $this->_objectId = 'id';
        $this->_blockGroup = 'marketplace';
        $this->_controller = 'adminhtml_commission';
    }

    /**
     * Display header text information
     * 
     * Return the header text
     * return varchar    
     */
    public function getHeaderText() {
        $seller_id = $this->getRequest()->getParam('id');
        $collection = Mage::getModel('marketplace/sellerprofile')->load($seller_id, 'seller_id');
        $seller_title = $collection['store_title'];
        if (!empty($seller_title)) {
            return $this->__('Payment Details of ' . $seller_title);
        } else {
            return $this->__('Payment Details');
        }
    }

}

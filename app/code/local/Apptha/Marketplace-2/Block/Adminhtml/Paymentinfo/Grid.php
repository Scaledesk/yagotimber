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
 */
class Apptha_Marketplace_Block_Adminhtml_Paymentinfo_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Construct the inital display of grid information
     * Set the default sort for collection 
     * Set the sort order as "DESC"
     * 
     * Return array of data to display order information
     * @return array
     */
    public function __construct() {
        parent::__construct();
        $this->setId('paymentinfoGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Function to get commission payment collection
     * 
     * Return the seller commission payment information
     * return array
     */
    protected function _prepareCollection() {
        $seller_id = $this->getRequest()->getParam('id');
        $collection = Mage::getModel('marketplace/transaction')
                ->getCollection()
                ->addFieldToFilter('seller_id', $seller_id)
                ->addFieldToFilter('paid', 1);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Function to display fields with data
     * 
     * Display information about payment  
     * @return void
     */
    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('marketplace')->__('Transaction ID'),
            'width' => '100px',
            'index' => 'id',
        ));
        $this->addColumn('order_id', array(
            'header' => Mage::helper('marketplace')->__('Order ID'),
            'width' => '100px',
            'index' => 'order_id',
        ));
        $this->addColumn('seller_commission', array(
            'header' => Mage::helper('marketplace')->__('Seller Amount'),
            'width' => '100px',
            'index' => 'seller_commission',
        ));
        $this->addColumn('admin_commission', array(
            'header' => Mage::helper('marketplace')->__('Admin Commission'),
            'width' => '100px',
            'index' => 'admin_commission',
        ));
        $this->addColumn('paid_date', array(
            'header' => Mage::helper('customer')->__('Paid On'),
            'width' => '100px',
            'align' => 'center',
            'index' => 'paid_date',
            'gmtoffset' => true
        ));
        $this->addColumn('acknowledge_date', array(
            'header' => Mage::helper('customer')->__('Acknowledge On'),
            'align' => 'center',
            'width' => '100px',
            'index' => 'acknowledge_date',
            'gmtoffset' => true
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('customer')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('customer')->__('Excel XML'));
        return parent::_prepareColumns();
    }

    /**
     * Function for link url
     * 
     * Not redirect to any page
     * return void
     */
    public function getRowUrl($row) {
        return false;
    }

}


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

/**
 * View order information
 */
class Apptha_Marketplace_Block_Adminhtml_Orderview_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Construct the inital display of grid information
     * Set the default sort for collection 
     * Set the sort order as "DESC"
     * 
     * Return array of data to view order information
     * @return array
     */
    public function __construct() {
        parent::__construct();
        $this->setId('orderviewGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Function to get order collection
     * 
     * Return the seller product's order information
     * return array
     */
    protected function _prepareCollection() {
        $orders = Mage::getModel('marketplace/commission')->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('order_status', array('eq' => 'complete'))
                ->addFieldToFilter('status', array('eq' => 1))
                ->setOrder('order_id', 'desc');
        $this->setCollection($orders);
        return parent::_prepareCollection();
    }

    /**
     * Function to display fields with data
     * 
     * Display information about orders 
     * @return void
     */
    protected function _prepareColumns() {
    	$store = Mage::app()->getStore();
        $this->addColumn('selleremail', array(
            'header' => Mage::helper('sales')->__('Seller detail'),
            'width' => '150px',
            'index' => 'seller_id',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'Apptha_Marketplace_Block_Adminhtml_Renderersource_Ordersellerdetails'
        ));
        $this->addColumn('increment_id', array(
            'header' => Mage::helper('sales')->__('Order #'),
            'width' => '100px',
            'index' => 'increment_id'
        ));
        $this->addColumn('productdetail', array(
            'header' => Mage::helper('marketplace')->__('Product details'),
            'width' => '150px',
            'index' => 'id',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'Apptha_Marketplace_Block_Adminhtml_Renderersource_OrderProductdetails'
        ));
        $this->addColumn('product_amt', array(
            'header' => Mage::helper('sales')->__('Product Price'),
            'align' => 'right',
            'index' => 'product_amt',
            'width' => '80px',
            'type' => 'price',
        	'currency_code' => $store->getBaseCurrency()->getCode(),
            'currency' => 'order_currency_code',
        ));
        $this->addColumn('seller_amount', array(
            'header' => Mage::helper('sales')->__('Seller\'s Earned Amount'),
            'align' => 'right',           
            'index' => 'seller_amount',
            'width' => '80px',
            'type' => 'price',
        	'currency_code' => $store->getBaseCurrency()->getCode(),
            'currency' => 'order_currency_code',
        ));

        $this->addColumn('commission_fee', array(
            'header' => Mage::helper('sales')->__('Commission Fee'),
            'align' => 'right',
            'index' => 'commission_fee',
        	'width' => '80px',
        	'type' => 'price',
        	'currency_code' => $store->getBaseCurrency()->getCode(),
        	'currency' => 'order_currency_code',
        ));
        $this->addColumn('order_created_at', array(
            'header' => Mage::helper('marketplace')->__('Order At'),
            'align' => 'center',
            'width' => '200px',
            'index' => 'order_id',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'Apptha_Marketplace_Block_Adminhtml_Renderersource_Orderdate'
        ));
        /**
         * Credit Action
         */
        $this->addColumn('action', array(
            'header' => Mage::helper('marketplace')->__('Actions'),
            'align' => 'center',
            'width' => '100px',
            'index' => 'id',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'Apptha_Marketplace_Block_Adminhtml_Renderersource_Ordercredit'
        ));
        /**
         * Payment status
         */
        $this->addColumn('payment_status', array(
            'header' => Mage::helper('marketplace')->__('Ack Status'),
            'align' => 'center',
            'width' => '100px',
            'index' => 'payment_status',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'Apptha_Marketplace_Block_Adminhtml_Renderersource_Receivedstatus'
        ));
        /**
         * Acknowledge Date
         */
        $this->addColumn('acknowledge_date', array(
            'header' => Mage::helper('marketplace')->__('Ack On'),
            'align' => 'center',
            'width' => '100px',
            'index' => 'acknowledge_date',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'Apptha_Marketplace_Block_Adminhtml_Renderersource_Acknowledgedate'
        ));
        /**
         * View Action
         */
        $this->addColumn('view', array(
            'header' => Mage::helper('marketplace')->__('View'),
            'type' => 'action',
            'getter' => 'getOrderId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('marketplace')->__('View'),
                    'url' => array('base' => 'adminhtml/sales_order/view/'),
                    'field' => 'order_id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));
        return parent::_prepareColumns();
    }

    /**
     * Function for Mass action(credit payment to seller)
     * 
     * Will change the credit order status of the seller
     * return void
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('marketplace');
        $this->getMassactionBlock()->addItem('credit', array(
            'label' => Mage::helper('marketplace')->__('Credit'),
            'url' => $this->getUrl('*/*/masscredit'),
        ));
        return $this;
    }

    /**
     * Function for link url
     * 
     * Not redirected to any page
     * return void
     */
    public function getRowUrl($row) {
        return false;
    }

}


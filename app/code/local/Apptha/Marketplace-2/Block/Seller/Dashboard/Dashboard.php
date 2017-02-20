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
 * This file is used to display seller dashboard with functionalities like Total sales, Average orders,
 * Last five orders, Most viewed products and Sales report
 */
class Apptha_Marketplace_Block_Seller_Dashboard_Dashboard extends Mage_Core_Block_Template
{  
    /**
     * Function to get profile url
     * 
     * Return the seller profile url
     * @return string
     */
    function profileUrl()
    {     
        return  Mage::getUrl('marketplace/seller/addprofile');
    }
   /**
    * Function to get most viewed product information
    * 
    * Return the Most viewed products as array
    * @return array
    */
   public function mostViewed($id){
       $storeId    = Mage::app()->getStore()->getId();
       $products   = Mage::getResourceModel('reports/product_collection')
                    ->addOrderedQty()
                    ->addAttributeToSelect('*')           
                    ->setStoreId($storeId)
                    ->addStoreFilter($storeId)
                    ->addViewsCount()
                    ->addAttributeToFilter('visibility', array(
                    		Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                    		Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_SEARCH
                    ))
                   ->addFieldToFilter("seller_id",$id);
                    
        $products->setPageSize(5)->setCurPage(1);
        return $products;       
   }
   /**
    * Getting sales report collection
    * 
    * Passed the From date as $dbFrom to sort the sales orders 
    * @param int $dbFrom
    * 
    * Passed the To date as $dbTo to sort the sales orders 
    * @param int $dbTo
    * 
    * Passed the seller id as $id to get particular seller orders 
    * @param int $id
    * 
    * Return commission collection as array
    * @return array
    * 
    */ 
    public function advancedSalesReportCollection($dbFrom,$dbTo,$id) {  
        $collection = Mage::getModel('marketplace/commission')->getCollection()                      
                        ->addFieldToFilter('seller_id',$id)
                        ->addFieldToFilter('created_at', array('from' =>$dbFrom, 'to'=>$dbTo));        
        return $collection;
    } 
    /**
     * Total Orders for a seller
     */
    public function getTotalOrders($id){
    	$collection = Mage::getModel('marketplace/commission')->getCollection()
    	->addFieldToFilter('seller_id',$id);
    	return count($collection);
    } 
    /**
     * Complete status order
     */
    public function getCompleteStatus($id){
    	$collection = Mage::getModel('marketplace/commission')->getCollection()
    	->addFieldToFilter('seller_id',$id)
    	->addFieldToFilter('order_status','complete');
    	return count($collection);
    }
    /**
     * Pending status order
     */
    public function getPendingStatus($id){
    	$collection = Mage::getModel('marketplace/commission')->getCollection()
    	->addFieldToFilter('seller_id',$id)
    	->addFieldToFilter('order_status','pending');
    	return count($collection);
    }
    /**
     * Processing status order
     */
    public function getProcessingStatus($id){
    	$collection = Mage::getModel('marketplace/commission')->getCollection()
    	->addFieldToFilter('seller_id',$id)
    	->addFieldToFilter('order_status','processing');
    	return count($collection);
    }
    /**
     * Cancelled status order
     */
    public function getCancelledStatus($id){
    	$collection = Mage::getModel('marketplace/commission')->getCollection()
    	->addFieldToFilter('seller_id',$id)
    	->addFieldToFilter('order_status','canceled');
    	return count($collection);
    }
    /**
     * Refunded status order
     */
    public function getRefundedStatus($id){
    	$collection = Mage::getModel('marketplace/commission')->getCollection()
    	->addFieldToFilter('seller_id',$id)
    	->addFieldToFilter('order_status','closed');
    	return count($collection);
    }
    /**
     * Onhold status order
     */
    public function getOnholdStatus($id){
    	$collection = Mage::getModel('marketplace/commission')->getCollection()
    	->addFieldToFilter('seller_id',$id)
    	->addFieldToFilter('order_status','holded');
    	return count($collection);
    }
} 




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
class Apptha_Marketplace_Block_Linkseller extends Mage_Core_Block_Template
{
	/*
	 * Function to get the seller profile data
	 *  
	 * Passed the seller id as $sellerId to get particular seller info 
     * @param int $sellerId
     * 
     * Return store title of the seller as $StoreTitle
     * @return varchar
	 */  
    function sellerdisplay($sellerId)
    {
       $collection   = Mage::getModel('marketplace/sellerprofile')->load($sellerId,'seller_id');
       return  $collection;               
    }
    /*
     * Function to get show profile information
    *
    * Passed the seller id as $sellerId to get particular seller info
    * @param int $sellerId
    *
    * Return store profile of the seller as $StoreProfile
    * @return int
    */
    
    function sellerprofiledisplay($sellerId)
    {
       $collection    = Mage::getModel('marketplace/sellerprofile')->load($sellerId,'seller_id');
       $StoreProfile = $collection->getShowProfile();
       return  $StoreProfile;               
    }
    /**
     * Function to get the Seller products
     *
     * Return the Seller product collection
     * @return array
     */
    function sellerproduct($sellerid){
    	$collection = Mage::getModel('catalog/product')->getCollection()
    	->addFieldToFilter('seller_id',$sellerid); 
    	return $collection;
    }
    
}


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
 * @version     1.4
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2014 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 * 
 */

/**
 * This file is used display the banner slider in home page
 */
class Apptha_Marketplace_Block_Homepageblocks extends Mage_Core_Block_Template {
	
	/**
	 * Function to get quick view category links
	 *
	 * Return the quick view category collection as array
	 * 
	 * @return array
	 */
	public function getQuickview() {
		$categoryCollection = Mage::getModel ( 'catalog/category' )->getCollection ();
		$categoryCollection->addAttributeToFilter ( 'quick_view', '1' );
		$categoryCollection->addAttributeToFilter ( 'include_in_menu', array (
				'eq' => 1 
		) );
		$categoryCollection->addAttributeToFilter ( 'is_active', array (
				'eq' => '1' 
		) );
		$categoryCollection->addAttributeToSelect ( '*' );
		$categoryCollection->setPageSize ( 10 )->setCurPage ( 1 );
		return $categoryCollection;
	}
	

    /**
     * Function to get product collection
     *      
     * This Function will return the product collection
     * @return array
     */
    public function getProductCollection() {
        $_productCollection = Mage::getResourceModel('catalogsearch/advanced_collection')
				->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
				->addMinimalPrice()
				->addStoreFilter();
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($_productCollection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($_productCollection); 
		$todayDate = date('m/d/y');
		$tomorrow = mktime(0, 0, 0, date('m'), date('d'), date('y'));
		$tomorrowDate = date('m/d/y', $tomorrow); 
		$_productCollection->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate))
				->addAttributeToFilter('special_to_date', array('or'=> array(
			0 => array('date' => true, 'from' => $tomorrowDate),
			1 => array('is' => new Zend_Db_Expr('null')))
			), 'left'); 
        return $_productCollection;
    }

    /**
     * Function to get product parent id
     *      
     * This Function will return the product parent id
     * @return int
     */
    public function getParentId($product) {

        $parentId = '';

        if ($product->getVisibility() != '1') {
            $parentId = $product->getId();
        } else {
            /**
             *  get parent id if the product is not visible                         
             *  this means that the product is associated with a configurable product
             */
            $parentIdArray = $product->loadParentProductIds()->getData('parent_product_ids');
            if (!empty($parentIdArray)) {
                $parentId = $parentIdArray[0];
            }
        }
        return $parentId;
    }
    /**
     * Function to get category listings links
     *
     * Return the category listings links collection as array
     *
     * @return array
     */
    public function getSubCategoryListings() {
    	$categoryCollection = Mage::getModel ( 'catalog/category' )->getCollection ();
    	$categoryCollection->addAttributeToFilter ( 'sub_category_listings', '1' );
    	$categoryCollection->addAttributeToFilter ( 'include_in_menu', array (
    			'eq' => 1
    	) );
    	$categoryCollection->addAttributeToFilter ( 'is_active', array (
    			'eq' => '1'
    	) );
    	$categoryCollection->addAttributeToSelect ( '*' );
    	$categoryCollection->setPageSize ( 10 )->setCurPage ( 1 );
    	return $categoryCollection;
    }
    /**
     * Get sub category collection of the particular category
     * 
     * @return array
     */
    public function getSubCategories($categoryId){
    	$subCatId = array(); 
    	$children = Mage::getModel('catalog/category')->getCategories($categoryId); 
    	foreach($children as $_children){
    		$subCatId[] = $_children->getId();
    	}   	
    	return $subCatId;
    }
    /**
     * Load category information
     * 
     * @return array
     */
	public function loadCategoryInfo($categoryId){	
		$catInfo = Mage::getModel('catalog/category')->load($categoryId);	
		return $catInfo;
	}
	/**
	 * Best seller product Collection
	 * 
	 * @return array
	 */
	public function bestSellerCollection(){
		$storeId = Mage::app()->getStore()->getId();
		$visibility = array(			
				Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,			
				Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG		
		);
		
		$bestProducts = Mage::getResourceModel('reports/product_collection')
						->addOrderedQty()
						->addAttributeToSelect('*')
						->addAttributeToSelect(array('name', 'price', 'small_image'))
						->setStoreId($storeId)
						->addStoreFilter($storeId)
						->addAttributeToFilter('visibility', $visibility)
						->setOrder('ordered_qty', 'desc'); 						
		return $bestProducts;
	}
	/**
	 * Function to get the new products
	 *
	 * Return New product collection as array
	 * @return array
	 */
	public function getNewproduct() {
		$storeId = Mage::app()->getStore()->getId();
		$todayDate = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$collection = Mage::getModel('catalog/product')->getCollection()->addStoreFilter($storeId)
		->addAttributeToSelect('*')
		->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))
		->addAttributeToFilter('news_to_date', array('or' => array(
				0 => array('date' => true, 'from' => $todayDate),
				1 => array('is' => new Zend_Db_Expr('null')))
		), 'left')
		->addAttributeToSort('entity_id', 'desc')
		->addAttributeToFilter('status', array('eq' => 1));
		return $collection;
	}
}
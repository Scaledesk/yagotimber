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
 * This file is used display category listing page
 */
class Apptha_Marketplace_Block_Categorydisplay extends Mage_Core_Block_Template {
	
	/**
	 * Get category collection
	 * 
	 * Return the category data collection
	 * @return array
	 */
	public function getCategory($catId){		
		$categoryData = Mage::getModel('catalog/category')->load($catId);
		return $categoryData;
	}
	/**
	 * Get sub category collection of the particular category
	 *
	 * @return array
	 */
	public function getSubCategories($catId){
		$subCatId = array();
		$children = Mage::getModel('catalog/category')->getCategories($catId);
		foreach($children as $_children){
			$categoryInformation = $this->getCategory($_children->getId());
					$subCatId[] =  $_children->getId();
			
		}		
		return $subCatId;
	}
	/**
	 * Get discounted category display details
	 * 
	 * @return array
	 */
	public function getDiscountedCategory($catId){
		$trendIds = array();
		$subCategoryIds = $this-> getSubCategories($catId);
		if(count($subCategoryIds)>0){
			foreach($subCategoryIds as $_subCategoryIds){
				$categoryData = Mage::getModel('catalog/category')->load($_subCategoryIds);
				if($categoryData->getDiscountedCategoryListings() == 1){
					$trendIds[] =  $categoryData->getId();
				}
			}
			
		}		
		return $trendIds;
	}
}
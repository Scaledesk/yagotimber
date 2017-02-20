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
class Apptha_Marketplace_Block_Seller_Profilepage_Displayseller extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
       $id           = $this->getRequest()->getParam('id');       
       $sellerPage   = Mage::getModel('marketplace/sellerprofile')->collectprofile($id);      
       /**
        * set Meta information for the seller
        */
       $head         = $this->getLayout()->getBlock('head');
                        $head->setTitle($sellerPage->getStoreTitle());
                        $head->setKeywords($sellerPage->getMetaKeyword());
                        $head->setDescription($sellerPage->getMetaDescription()); 
      $displayCollection = $this->categoryProducts();            
                        $this->setCollection($displayCollection);
       $pager        = $this->getLayout()
                        ->createBlock('page/html_pager', 'my.pager')                      
                        ->setCollection($displayCollection); 
                      $pager->setAvailableLimit(array(10 => 10,20 => 20,30=>30,50=>50));
                 $pager->setLimit(20);
       $this->setChild('pager', $pager);
       return $this;     
    }
   /**
     * Function to get the collection according to pagination
     *
     * Return the Seller product collection
     * @return array
     */
    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }
       
   /**
     * Function to get the Seller products
     *
     * Return the Seller product collection
     * @return array
     */
    function sellerproduct($sellerid){
         $collection = Mage::getModel('catalog/product')->getCollection()
                        ->addFieldToFilter('seller_id',$sellerid)
                        ->joinField('category_id',
                            Mage::getConfig()->getTablePrefix().'catalog_category_product',
                            'category_id',
                            'product_id=entity_id',
                            null,
                            'right');
        $value       = $collection->getData('category_id');
        return $value;                 
    }
  
    /**
     * Get category products
     *
     * Return the category product collection
     * @return array
     */
    function categoryProducts(){
        $displayCatProduct = $this->getRequest()->getParam('category_name');
        $sortProduct        = $this->getRequest()->getParam('sorting');
        $id                  = $this->getRequest()->getParam('id');
        $catagoryModel      = Mage::getModel('catalog/category')->load($displayCatProduct);
        $collection          = Mage::getResourceModel('catalog/product_collection');
                                $collection->addCategoryFilter($catagoryModel); //category filter
                                $collection->addAttributeToFilter('status',1); //only enabled product
                                $collection->addAttributeToSelect('*'); //add product attribute to be fetched
                                $collection->addAttributeToFilter('seller_id',$id);
                                $collection->addStoreFilter();         
                                $collection->addAttributeToSort($sortProduct);
        return $collection;
    }
   
    /**
     * Get category Url
     *
     * Return the category link url
     * @return string
     */
    function getCategoryUrl($customerId,$id){
        return  Mage::getUrl('marketplace/seller/categorylist',array('id'=>$id,'cat'=>$customerId));
    }
   
    /**
     * Get url for review form
     *
     * Passed the seller id to get the review collection
     * @param int $id
     * 
     * Customer id is passed to get the particular customer reviews
     * @param int $customerId
     * 
     * Product id is passed to get the particular products reviews
     * @param int $productId
     *
     * Return the average rating of particular seller
     * @return int
     */
    function reviewUrl($customerId,$id,$productId){
        return  Mage::getUrl('marketplace/seller/reviewform',array('id'=>$id,'cus'=>$customerId,'product'=>$productId));
    }
  
    /**
     * Get login url if customer not logged in     
     *
     * Return the customer login url
     * @return string
     */
    function loginUrl(){
        return  Mage::getUrl('customer/account/login/');
    }
 
    /**
     * Get all reviews link
     *
     * Passed the seller id to get the review collection
     * @param int $id
     * 
     * Customer id is passed to get the particular customer reviews
     * @param int $customerId
     * 
     * Product id is passed to get the particular products reviews
     * @param int $productId
     *
     * Return the average rating of particular seller
     * @return int
     */
    function getAllreview($customerId,$id,$productId){
        return  Mage::getUrl('marketplace/seller/allreview',array('id'=>$id,'cus'=>$customerId,'product'=>$productId));
  }
  /**
   * Calculating average rating for each seller
   *
   * Passed the seller id to get the review collection
   * @param int $id
   *
   * Return the average rating of particular seller
   * @return int
   */
  public function averageRatings($id) {
  	/**
  	 *  Review Collection to retrive the ratings of the seller
  	 */
  	$storeId = Mage::app()->getStore()->getId();
  	$reviews = Mage::getModel('marketplace/sellerreview')->getCollection()
  	->addFieldToFilter('seller_id', $id)
  	->addFieldToFilter('status', 1)
  	->addFieldToFilter('store_id', $storeId);
  	/**
  	 *  Calculate average ratings
  	 */
  	$ratings = array();
  	$avg = 0;
  	if (count($reviews) > 0) {
  		foreach ($reviews as $review) {
  			$ratings[] = $review->getRating();
  		}
  		$count = count($ratings);
  		$avg = array_sum($ratings) / $count;
  	}
  	return $avg;
  }
  public function reviewCount($id){
  	/**
  	 *  Review Collection to retrive the ratings of the seller
  	 */
  	$storeId = Mage::app()->getStore()->getId();
  	$reviews = Mage::getModel('marketplace/sellerreview')->getCollection()
  	->addFieldToFilter('seller_id', $id)
  	->addFieldToFilter('status', 1)
  	->addFieldToFilter('store_id', $storeId);
  	return count($reviews);
  }   
  /**
   * Best seller product Collection
   *
   * @return array
   */
  public function bestSellerCollection($sellerId){
  	$storeId = Mage::app()->getStore()->getId();
  	$visibility = array(
  			Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
  			Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
  	);
  
  	$bestProducts = Mage::getResourceModel('reports/product_collection')
  	->addOrderedQty()
  	->addAttributeToSelect('*')
  	->addAttributeToSelect(array('name', 'price', 'small_image','seller_id'))
  	->addAttributeToFilter('seller_id',$sellerId)
  	->setStoreId($storeId)
  	->addStoreFilter($storeId)
  	->addAttributeToFilter('visibility', $visibility)
  	->setOrder('ordered_qty', 'desc');
  	return $bestProducts;
  } 
  /**
   * Contact seller url action
   */
  public function getContactSellerUrl($id){
  	return  Mage::getUrl('marketplace/seller/contactseller',array('id'=>$id));
  }
} 

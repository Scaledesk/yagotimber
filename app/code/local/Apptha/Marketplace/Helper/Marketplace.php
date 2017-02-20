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
 * Function written in this file are globally accessed
 */
class Apptha_Marketplace_Helper_Marketplace extends Mage_Core_Helper_Abstract {

    /**
     * Function to get new product url
     * 
     * This Function will return the redirect url of new product form
     * @return string
     */
    public function getNewProductUrl() {
        return Mage::getUrl('marketplace/product/new');
    }

    /**
     * Functionto get the manage product url
     * 
     * This Function will return the redirect url of manage products
     * @return string
     */
    public function getManageProductUrl() {
        return Mage::getUrl('marketplace/product/manage');
    }

    /**
     * Function to get the manage order url
     * 
     * This Function will return the redirect url of manage orders
     * @return string
     */
    public function getManageOrderUrl() {
        return Mage::getUrl('marketplace/order/manage');
    }

    /**
     * Function to get the add profile url
     * 
     * This Function will return the redirect url of add profile
     * @return string
     */
    public function addprofileUrl() {
        return Mage::getUrl('marketplace/seller/addprofile');
    }

    /**
     * Function to get the become a merchant url
     * 
     * This Function will return the redirect url to become a merchant
     * @return string
     */
    public function becomemerchantUrl() {
        return Mage::getUrl('marketplace/seller/changebuyer');
    }

    /**
     * Function to get link profile url 
     * 
     * Passed the seller id in url to get the seller store name
     * @param int $sellerId
     * 
     * This Function will return the redirect url link to seller profile 
     * @return string
     */
    public function linkprofileUrl($sellerId) {
        return Mage::getUrl('marketplace/seller/displayseller', array('id' => $sellerId));
    }

    /**
     * Function to get link product url
     * 
     * Passed the seller id in url to get the seller store name
     * @param int $sellerId
     * 
     * This Function will return the redirect url
     * @return string
     */
    public function linkproductUrl($sellerId) {
        return Mage::getUrl('marketplace/seller/sellerproduct', array('id' => $sellerId));
    }

    /**
     * Function to get seller registration url
     * 
     * This Function will return the redirect url to seller registration
     * @return string
     */
    public function getregisterUrl() {
        return Mage::getUrl('marketplace/seller/create');
    }

    /**
     * Function to get seller registration url and login url
     * 
     * This Function will return the redirect url seller registration and login
     * @return string
     */
    public function getregister() {
        return Mage::getUrl('marketplace/seller/login');
    }

    /**
     * Function to get the dashboard url
     * 
     * This Function will return the redirect url to dashboard
     * @return string
     */
    public function dashboardUrl() {
        return Mage::getUrl('marketplace/seller/dashboard');
    }

    /**
     * Function to get all seller information
     * 
     * This Function will return the redirect url to view all seller page
     * @return string
     */
    public function getviewallsellerUrl() {
        return Mage::getUrl('marketplace/seller/allseller');
    }

    /**
     * Function to get view order url
     * 
     * Passed the order id in url to get the order details
     * @param int $getOrderId
     * 
     * Passed the product id in url to get the product details
     * @param int $getProductId
     * 
     * This Function will return the redirect url to view order details
     * @return string
     */
    public function getVieworder($getOrderId,$getProductId) {
        return Mage::getUrl('marketplace/order/vieworder', array('orderid' => $getOrderId,'productid' => $getProductId));
    }

    /**
     * Function to get view transaction url
     * 
     * This Function will return the redirect url to view transaction
     * @return string
     */
    public function getViewtransaction() {
        return Mage::getUrl('marketplace/order/viewtransaction');
    }

    /**
     * Function to get the received amount of seller
     * 
     * This funtion will return the Total amount received by the seller from admin
     * @return int
     */
    public function getAmountReceived() {
        $return = '';
        $sellerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        $_collection = Mage::getModel('marketplace/transaction')->getCollection()
                ->addFieldToSelect('seller_commission')
                ->addFieldToFilter('seller_id', $sellerId)
                ->addFieldToFilter('paid', 1);
        $_collection->getSelect()
                ->columns('SUM(	seller_commission) AS seller_commission')
                ->group('seller_id');
        foreach ($_collection as $amount) {
            $return = $amount->getSellerCommission();
        }
        return Mage::helper('core')->currency($return, true, false);
    }

    /**
     * Function to get the remaining amount of seller
     * 
     * This funtion will return the Total remaining amount by admin to seller
     * @return int
     */
    public function getAmountRemaining() {
        $return = '';
        $sellerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        $_collection = Mage::getModel('marketplace/transaction')->getCollection()
                ->addFieldToSelect('seller_commission')
                ->addFieldToFilter('seller_id', $sellerId)
                ->addFieldToFilter('paid', 0);
        $_collection->getSelect()
                ->columns('SUM(	seller_commission) AS seller_commission')
                ->group('seller_id');
        foreach ($_collection as $amount) {
            $return = $amount->getSellerCommission();
        }
        return Mage::helper('core')->currency($return, true, false);
    }

    /**
     * Function to get customer review url
     * 
     * This Function will return the redirect url to customer review
     * @return string
     */
    public function customerreviewUrl() {
        return Mage::getUrl('marketplace/seller/customerreview');
    }

    /**
     * Function to get all review data
     * 
     * Passed the seller id in url to get all review
     * @param int $id
     * 
     * This Function will return all reviews as array format for a particular seller
     * @return array
     */
    function getallreviewdata($id) {       
        $storeId = Mage::app()->getStore()->getId();
        $collection = Mage::getModel('marketplace/sellerreview')
                ->getCollection()
                ->addFieldToFilter('status', 1)
                ->addFieldToFilter('store_id', $storeId)
                ->addFieldToFilter('seller_id', $id);
        return $collection;
    }

    /**
     * Function to get order collection
     * 
     * Filter the order collection by customer id
     * @param int $customerId
     * 
     * This function will return only the order details of particular customer 
     * @return array
     */
    function allowReview($customerId) {
        $orders = Mage::getResourceModel('sales/order_collection')
                ->addFieldToSelect('*')
                ->addFieldToFilter('customer_id', $customerId)
                ->addAttributeToSort('created_at', 'DESC')
                ->setPageSize(5);
        return $orders;
    }

    /**
     * Function to get contact form url
     * 
     * This function will return the contact form url
     * @return string
     */
    public function getContactFormUrl() {
        return Mage::getUrl('marketplace/contact/form');
    }

    /**
     * Function to get the seller rewrite url
     * 
     * Passed the seller id to rewrite the particular seller url
     * @param int $sellerId
     * 
     * This function will return the rewrited url for a particular seller
     * @return string
     */
    public function getSellerRewriteUrl($sellerId) {
        $targetPath = 'marketplace/seller/displayseller/id/' . $sellerId;
        $mainUrlRewrite = Mage::getModel('core/url_rewrite')->load($targetPath, 'target_path');
        $getRequestPath = $mainUrlRewrite->getRequestPath();
        $NewGetRequestPath = Mage::getUrl($getRequestPath);
        return $NewGetRequestPath;
    }

    /**
     * Function to load particular seller information
     * 
     * In this function seller id is passed to get particular seller data
     * @param int $_id
     * 
     * This function will return the particular seller information as array
     * @return array
     */
    public function getSellerCollection($_id) {
        $collection = Mage::getModel('marketplace/sellerprofile')->load($_id, 'seller_id');
        return $collection;
    }

    /**
     * Function to load particular category information
     * 
     * Passed Category Id to get the category information
     * @param int $catId
     * 
     * This function will return the Category information as array
     * @return array
     */
    public function getCategoryData($catId) {
        $collection = Mage::getModel('catalog/category')->load($catId);
        return $collection;
    }

    /**
     * Function to delete product
     * 
     * Product entity id are passed to delete the product
     * @param int $entityIds
     * 
     * This function will return true or false
     * @return bool
     */
    public function deleteProduct($entityIds) {
        Mage::getModel('catalog/product')->setId($entityIds)->delete();
        return true;
    }

    /**
     * Function to get product collection
     * 
     * Product id is passed to get the particular product information
     * @param int $getProductId
     * 
     * This function will display the particular product information as array
     * @return array
     */
    public function getProductInfo($getProductId) {
        $collection = Mage::getModel('catalog/product')->load($getProductId);
        return $collection;
    }

    /**
     * Function to get Commission data
     * 
     * Commission Id is passed to get the particular commission id's data
     * @param int $commissionId
     * 
     * This function will return the commission information as array
     * @return array
     */
    public function getCommissionInfo($commissionId) {
        $collection = Mage::getModel('marketplace/commission')->load($commissionId, 'id');
        return $collection;
    }

    /**
     * Function to get Transaction data
     * 
     * Commission id is passed to get the transaction details
     * @param int $commissionId
     * 
     * This function will return the transaction details as array
     * @return array
     */
    public function getTransactionInfo($commissionId) {
        $collection = Mage::getModel('marketplace/transaction')->load($commissionId, 'commission_id');
        return $collection;
    }

    /**
     * Function to save transaction data
     * 
     * Transaction data is passed as array 
     * @param array $data
     * 
     * This function will return true or false
     * @return bool
     */
    public function saveTransactionData($data) {
        Mage::getModel('marketplace/transaction')->setData($data)->save();
        return true;
    }

    /**
     * Function to save transaction data
     * 
     * Transaction Id is passed to update the transaction information
     * @param int $transactionId
     * 
     * Update the database table and will return void
     * @return void
     */
    public function updateTransactionData($transactionId) {
        $now = Mage::getModel('core/date')->date('Y-m-d H:i:s', time());
        if (!empty($transactionId)) {
            Mage::getModel('marketplace/transaction')
                    ->setPaid(1)
                    ->setPaidDate($now)
                    ->setComment('Paypal Adaptive Payment')
                    ->setId($transactionId)->save();
        }
    }

    /**
     * Function to update commission data
     * 
     * Passed the order status to update in database table
     * @param int $statusOrder
     * 
     * Passed the commission id to update the data in database
     * @param int $commissionId
     * 
     * This function will return true or false
     * @return bool
     */
    public function updateCommissionData($statusOrder, $commissionId) {
        Mage::getModel('marketplace/commission')->setOrderStatus($statusOrder)->setId($commissionId)->save();
        return true;
    }

    /**
     * Function to save commission data
     * 
     * Passed the commission data as array
     * @param array $data
     * 
     * Passed the commission id to save the commission data
     * @param int $commissionId
     * 
     * This function will return true or false
     * @return bool
     */
    public function saveCommissionData($data, $commissionId) {
        Mage::getModel('marketplace/commission')->setData($data)->setId($commissionId)->save();
        return true;
    }

    /**
     * Function to load email template 
     * 
     * Passed the template id to load the email template
     * @param int $templateId
     * 
     * This function will return the email template
     * @return string
     */
    public function loadEmailTemplate($templateId) {
        $emailTemplate = Mage::getModel('core/email_template')->load($templateId);
        return $emailTemplate;
    }

    /**
     * Function to load customer data
     * 
     * Passed the selle id to load a particular seller details
     * @param int $sellerId
     * 
     * This function will return the seller details as array
     * @return array
     */
    public function loadCustomerData($sellerId) {
        $customer = Mage::getModel('customer/customer')->load($sellerId);
        return $customer;
    }

    /**
     * Function to update comment from admin
     * 
     * Passed the comment provided by admin before pay amount to seller
     * @param int $comment
     * 
     * Passed the transaction id to update the comment for that particular transaction
     * @param int $transactionId
     * 
     * This function will return true or false
     * @return bool
     */
    public function updateComment($comment, $transactionId) {
        $now = Mage::getModel('core/date')->date('Y-m-d H:i:s', time());
        if (!empty($transactionId)) {
            Mage::getModel('marketplace/transaction')
                    ->setPaid(1)
                    ->setPaidDate($now)
                    ->setComment($comment)
                    ->setId($transactionId)->save();
            return true;
        }
    }

    /**
     * Function to credit amount to seller
     * 
     * Passed the Commission Id to update the amount credited details
     * @param int $commissionId
     * 
     * This function will return true or false
     * @return bool
     */
    public function updateCredit($commissionId) {
        $collection = Mage::getModel('marketplace/commission')->load($commissionId, 'id');
        $collection->setCredited('1')->save();
        return $collection;
    }

    /**
     * Function to delete a seller review
     * 
     * Seller id is passed to delete the seller review
     * @param int $marketplaceId
     * 
     * This function will return true or false
     * @return bool
     */
    public function deleteReview($marketplaceId) {
        $model = Mage::getModel('marketplace/sellerreview');
        $model->setId($marketplaceId)->delete();
        return true;
    }

    /**
     * Function to approve review
     * 
     * Seller id is passed to approve the seller review
     * @param int $marketplaceId
     * 
     * This function will return true or false
     * @return bool
     */
    public function approveReview($marketplaceId) {
        $model = Mage::getModel('marketplace/sellerreview')->load($marketplaceId);
        $model->setStatus('1')->save();
        return $model;
    }

    /**
     * Function to delete a seller account
     * 
     * Seller id is passed to delete the seller
     * @param int $marketplaceId
     * 
     * This function will return true or false
     * @return bool
     */
    public function deleteSeller($marketplaceId) {
        $marketplace = Mage::getModel('customer/customer')->load($marketplaceId);
        $marketplace->setGroupId ( 1 );
		$marketplace->save ();
        return true;
    }

    /**
     * Function to update approve seller status
     * 
     * Seller id is passed to approve the seller
     * @param int $marketplaceId
     * 
     * This function will return true or false
     * @return bool
     */
    public function approveSellerStatus($marketplaceId) {
        $model = Mage::getModel('customer/customer')->load($marketplaceId);
        $model->setCustomerstatus('1')
                ->save();
        return true;
    }

    /**
     * Function to update disapprove seller status
     * 
     * Seller id is passed to disapprove the seller
     * @param int $marketplaceId
     * 
     * This function will return true or false
     * @return bool
     */
    public function disapproveSellerStatus($marketplaceId) {
        $model = Mage::getModel('customer/customer')->load($marketplaceId);
        $model->setCustomerstatus('2')
                ->save();
        return true;
    }

    /**
     * Function to upload product image
     * @param int $filename 
     * @param array $filesDataArray
     * @return string
     */
    public function uploadImage($filename, $filesDataArray) {
        $imagesPath = array();
        $uploader = new Varien_File_Uploader($filename);
        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
        $uploader->addValidateCallback('catalog_product_image', Mage::helper('catalog/image'), 'validateUploadFile');
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);
        $path = Mage::getBaseDir('media') . DS . 'tmp' . DS . 'catalog' . DS . 'product' . DS;
        $uploader->save($path, $filesDataArray[$filename]['name']);
        $imagesPath = $path . $uploader->getUploadedFileName();

        return $imagesPath;
    }

    /**
     * Function to save image in media gallery
     * 
     * Product images are passed as array
     * @param array $product
     * 
     * This function will return true or false
     * @return bool
     */
    public function mediaGallery($product) {
        $product->save();
        return true;
    }

    /**
     * Function to disallow php files
     * 
     * Uploaded file information are passed as array
     * @param array $uploader
     * 
     * Temporary storage path is passed to store the uploaded file
     * @param string $tmpPath
     * 
     * This function will return true or false
     * @return bool
     */
    public function disAllowUpload($uploader, $tmpPath) {
        $uploader->save($tmpPath);
        return true;
    }

    /**
     * Function to delete existing product custom option
     * 
     * Custom option details will be send as array
     * @param array $opt
     * 
     * This function will return true or false
     * @return bool
     */
    public function deleteCustomOption($opt) {
        $opt->delete();
        return true;
    }

    /**
     * Function to storing downloadable product link data
     * 
     * Downloadable file data are passed as array
     * @param array $linkModel
     * 
     * This function will return true or false
     * @return bool
     */
    public function saveDownLoadLink($linkModel) {
        $linkModel->save();
        return true;
    }

    /**
     * Function to set product instock
     * 
     * Passed the Product is instock or not value
     * @param int $isInStock
     * 
     * This function will return 0 or 1
     * @return bool
     */
    public function productInStock($isInStock) {
        if (isset($isInStock)) {
            return $stock_data['is_in_stock'] = $isInStock;
        } else {
            return $stock_data['is_in_stock'] = 1;
        }
    }
    
    /**
     * Function to get vacation mode url   
     * 
     * This Function will return the redirect url of vacation mode form  
     * @return string
     */
    public function getVacationModeUrl(){
        return Mage::getUrl('marketplace/seller/vacationmode');
    }
     /**
     * Function to get vacation mode savae url   
     * 
     * This Function will return the redirect url of vacation mode save action  
     * @return string
     */
    public function getVacationModeSaveUrl(){
        return Mage::getUrl('marketplace/seller/vacationmodesave');
    }
    
    /**
     * Function to get invoice order url
     * 
     * Passed the order id in url to get the order details
     * @param int $orderId
     * 
     * Passed the product id in url to get the product details
     * @param int $productId
     * 
     * This Function will return the redirect url to view order details
     * @return string
     */
    public function getInvoiceUrl($orderId,$productId) {
        return Mage::getUrl('marketplace/order/invoice', array('orderid' => $orderId,'productid' => $productId));
    }
     /**
     * Function to get manage deals url
     *      
     * This Function will return the redirect url to view deals
     * @return string
     */
    public function getManageDealsUrl(){
        return Mage::getUrl('marketplace/product/managedeals');
    }
    
    /**
     * Function to delete deal price and date for products
     * 
     * Passed the entity id in url to get the product details
     * @param int $entityIds
     * 
     * This Function will delete deal details
     * @return bool
     */
    public function deleteDeal($entityIds){
        Mage::getModel('catalog/product')->load($entityIds)->setSpecialFromDate('')->setSpecialToDate('')->setSpecialPrice('')->save();     
        return true ;        
    }
    /**
     * Function to get view all compare price products url
     * 
     * This Function will return the redirect url of view all compare price products
     * @return string
     */
    public function getComparePriceUrl($productId) {
        return Mage::getUrl('marketplace/product/comparesellerprice',array('id'=>$productId));
    }
    /**
     * Retrieve attribute id for seller shipping
     *
     * This function will return the seller shipping id
     * @return int
     */
	public  function getSellerShipping()
	{
            return Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', 'seller_shipping_option');
	}
	/**
	 * Load particular product info 
	 * 
	 * @param Mage_Catalog_Model_Product $product
	 */
	protected function _loadProduct(Mage_Catalog_Model_Product $product)
	{
		$product->load($product->getId());
	}
	/**
	 * Get the New and Sale Label for a particular product
	 * 
	 * @param Mage_Catalog_Model_Product $product
	 * @return string
	 */
	public function getLabel(Mage_Catalog_Model_Product $product)
	{
		$html = '';
		$this->_loadProduct($product);	
		if ($this->_isNew($product) ) {
			$html .= '<div class="new-label new-right'.'">New</div>';
		}
		if ($this->_isOnSale($product) ) {
			$html .= '<div class="sale-label sale-left">Sale</div>';
		}	
		return $html;
	}
	/**
	 * Checking the from and to date for new and sale product
	 * 
	 * @param unknown $from
	 * @param unknown $to
	 * @return boolean
	 */
	protected function _checkDate($from, $to)
	{
		$date = new Zend_Date();
		$today = strtotime($date->__toString());
		if ($from && $today < $from) {
			return false;
		}
		if ($to && $today > $to) {
			return false;
		}
		if (!$to && !$from) {
			return false;
		}
		return true;
	}
	/**
	 * Check whether a product is set as new 
	 * 
	 * @param unknown $product
	 */
	protected function _isNew($product)
	{
		$from = strtotime($product->getData('news_from_date'));
		$to = strtotime($product->getData('news_to_date'));
		return $this->_checkDate($from, $to);
	}
	/**
	 * check whether a product is set for sale
	 * 
	 * @param unknown $product
	 */
	protected function _isOnSale($product)
	{
		$from = strtotime($product->getData('special_from_date'));
		$to = strtotime($product->getData('special_to_date'));
		return $this->_checkDate($from, $to);
	}
	/**
	 * Get category display url
	 * 
	 * Return the category display url
	 * @return string
	 */
	public function getCategoryDisplayUrl($category){
		$subCatId = array();
		$children = Mage::getModel('catalog/category')->getCategories($category);
		foreach($children as $_children){
			$subCatId[] = $_children->getId();
		}
		if(count($subCatId)>0){
			return Mage::getUrl('marketplace/index/categorydisplay', array('id'=>$category));
		} else {
			$catInfo = Mage::getModel('catalog/category')->load($category);
			return Mage::getBaseUrl().$catInfo->getUrlPath();			
		}		
		
	}
	/**
	 * Resize category images to display
	 * 
	 * Return image url
	 * @return string
	 */
	public function getResizedImage($imagePath,$width, $height = null, $quality = 100) {
		if (!$imagePath)
			return false;
	
		$imageUrl = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "category" . DS . $imagePath;
		if (! is_file ( $imageUrl ))
			return false;
	
		$imageResized = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "product" . DS . "cache" . DS . "cat_resized" . DS .$width. $imagePath;// Because clean Image cache function works in this folder only
		if (! file_exists ( $imageResized ) && file_exists ( $imageUrl ) || file_exists($imageUrl) && filemtime($imageUrl) > filemtime($imageResized)) :
		$imageObj = new Varien_Image ( $imageUrl );
		$imageObj->constrainOnly ( true );
		$imageObj->keepAspectRatio (false);
		$imageObj->keepFrame ( false );
		$imageObj->quality ( $quality );
		$imageObj->resize ( $width, $height );
		$imageObj->save ( $imageResized );
		endif;
	
		if(file_exists($imageResized)){			
			return Mage::getBaseUrl ( 'media' ) ."catalog/product/cache/cat_resized/" .$width. $imagePath;
		}else{
			return $imagePath;
		}
	
	}
	/**
	 * Resize normal images to display
	 *
	 * Return image url
	 * @return string
	 */
	public function getNormalResizedImage($imagePath,$width, $height = null, $quality = 100) {
		if (!$imagePath)
			
			return false;
	
		$imageUrl = Mage::getBaseDir ('skin').DS."frontend".DS."apptha".DS."superstore".DS."images".DS.$imagePath;
		if (! is_file ( $imageUrl ))
			return false;
	
		$imageResized = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "product" . DS . "cache" . DS . "cat_resized" . DS .$width.$imagePath;// Because clean Image cache function works in this folder only
		if (! file_exists ( $imageResized ) && file_exists ( $imageUrl ) || file_exists($imageUrl) && filemtime($imageUrl) > filemtime($imageResized)) :
		$imageObj = new Varien_Image ( $imageUrl );
		$imageObj->constrainOnly ( true );
		$imageObj->keepAspectRatio (false);
		$imageObj->keepFrame ( false );
		$imageObj->quality ( $quality );
		$imageObj->resize ( $width, $height );
		$imageObj->save ( $imageResized );
		endif;
	
		if(file_exists($imageResized)){			
			return Mage::getBaseUrl ( 'media' ) ."catalog/product/cache/cat_resized/".$width.$imagePath;
		}else{			
			return $imagePath;
		}
	
	}
}
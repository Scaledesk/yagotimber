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
 * This file is used to manage order information
 */
class Apptha_Marketplace_OrderController extends Mage_Core_Controller_Front_Action 
{
    /**
     * Retrieve customer session model object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession() {
        return Mage::getSingleton('customer/session');
    }
    /**
     * Load phtml layout file to display order information
     * 
     * @return void
     */
    public function indexAction() {
        if (!$this->_getSession()->isLoggedIn()) {
            Mage::getSingleton('core/session')->addError($this->__('You must have a Seller Account to access this page'));
            $this->_redirect('marketplace/seller/login');
            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Manage orders by sellers
     * 
     * @return void
     */
    public function manageAction() {
        Mage::helper('marketplace')->checkMarketplaceKey();
        if (!$this->_getSession()->isLoggedIn()) {
            Mage::getSingleton('core/session')->addError($this->__('You must have a Seller Account to access this page'));
            $this->_redirect('marketplace/seller/login');
            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }
     /**
      * View full order information by seller
      * 
      * @return void
      */
     public function vieworderAction(){
        Mage::helper('marketplace')->checkMarketplaceKey();
        if (!$this->_getSession()->isLoggedIn()) {
            Mage::getSingleton('core/session')->addError($this->__('You must have a Seller Account to access this page'));
            $this->_redirect('marketplace/seller/login');
            return;
        }
          $this->loadLayout();
          $this->renderLayout();  
      }
     /**
      * View full transaction history by seller
      * 
      * @return void
      */
      function viewtransactionAction(){
        Mage::helper('marketplace')->checkMarketplaceKey();
        if (!$this->_getSession()->isLoggedIn()) {
            Mage::getSingleton('core/session')->addError($this->__('You must have a Seller Account to access this page'));
            $this->_redirect('marketplace/seller/login');
            return;
        }
          $this->loadLayout();
          $this->renderLayout();  
      }
       /**
        * Seller payment acknowledgement
        * 
        * @return void
        */
      function acknowledgeAction(){
        Mage::helper('marketplace')->checkMarketplaceKey();
        if (!$this->_getSession()->isLoggedIn()) {
            Mage::getSingleton('core/session')->addError($this->__('You must have a Seller Account to access this page'));
            $this->_redirect('marketplace/seller/login');
            return;
        } 
          $this->loadLayout();
          $this->renderLayout();
          $commissionId = $this->getRequest()->getParam('commissionid');        
          if($commissionId!=''){
          $collection = Mage::getModel('marketplace/transaction')->changeStatus($commissionId);          
          if($collection==1){
              Mage::getSingleton('core/session')->addSuccess($this->__("Payment received status has been updated")); 
              $this->_redirect('marketplace/order/viewtransaction');
          } else  {
             Mage::getSingleton('core/session')->addError($this->__('Payment received status was not updated'));
             $this->_redirect('marketplace/order/viewtransaction'); 
          }
      }
   }
	/**
     * customer order cancel request
     * 
     * @return void
     */   
   	public function cancelAction(){
   	
   				$data = $this->getRequest()->getPost();
   		
   				/**
                 *  Sending order email 
                 */
                $templateId = (int) Mage::getStoreConfig('marketplace/admin_approval_seller_registration/order_cancel_request_notification_template_selection');
                $adminEmailId = Mage::getStoreConfig('marketplace/marketplace/admin_email_id');
                $toMailId = Mage::getStoreConfig("trans_email/ident_$adminEmailId/email");
                $toName = Mage::getStoreConfig("trans_email/ident_$adminEmailId/name");

                if ($templateId) {
                    $emailTemplate = Mage::helper('marketplace/marketplace')->loadEmailTemplate($templateId);
                } else {
                    $emailTemplate = Mage::getModel('core/email_template')
                            ->loadDefault('marketplace_cancel_order_admin_email_template_selection');
                }
                
                $productCollection = Mage::getModel('catalog/product')
                                    ->getCollection()
                                    ->addAttributeToSelect('*')
                                    ->addUrlRewrite()
                                    ->addAttributeToFilter('entity_id', array('in' => array($data['products'])));
                                    
                $productDetails = "<ul>";
                
                foreach($productCollection as $product){
                	$productDetails .= "<li>";
                	$productDetails .= "<div><a href='{$product->getProductUrl()}'>{$product->getName()}</a><div>";
                	$productDetails .= "</li>";
                }
                
                $productDetails .= "</ul>";
                
                
                $incrementId = Mage::getModel('sales/order')->load($data['order_id'])->getIncrementId();
                
                
                $customer = Mage::getModel('customer/customer')->load($data['customer_id']);
                
                $sellerEmail = $customer->getEmail();
                $sellerName = $customer->getName();
                $recipient = $toMailId;
                $sellerStore = Mage::app()->getStore()->getName();
                $recipientSeller = $sellerEmail;
                $emailTemplate->setSenderName($sellerName);
                $emailTemplate->setSenderEmail($sellerEmail);
                
                $emailTemplateVariables = array(
                					'ownername' => $toName,
                					'productdetails' => $productDetails, 
                					'order_id' => $incrementId,
                					'customer_email' => $sellerEmail, 
                					'customer_firstname' => $sellerName,
                					'reason' => $data['reason']
                );
                
                $emailTemplate->setDesignConfig(array('area' => 'frontend'));
                /**
                 *  Sending email to admin              
                 */
                $emailTemplate->getProcessedTemplate($emailTemplateVariables);
               	$emailSent =  $emailTemplate->send($recipient, $toName, $emailTemplateVariables);
               	
                if($emailSent){
                	
                	Mage::getSingleton('core/session')->addSuccess($this->__("Order cancelation has been requested"));
                	
                	$this->_redirectSuccess();
                	
                }else{
                	
                	Mage::getSingleton('core/session')->addError($this->__("Order cancelation has been not been send please try again"));
                	
                	$this->_redirectError();
                }
   	
   }
   
} 
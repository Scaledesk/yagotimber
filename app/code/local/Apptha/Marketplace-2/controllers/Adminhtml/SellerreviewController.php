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
 * This file is used to maintain seller review details
 */
class Apptha_Marketplace_Adminhtml_SellerreviewController extends Mage_Adminhtml_Controller_action
{

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('marketplace/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Seller Review'));
        return $this;
    } 
    /**
     * Load phtml file layout
     *
     * @return void
     */
    public function indexAction() {             
        $this->_initAction()
        ->renderLayout();
    }
    /**
     * Delete multiple reviews 
     *
     * @return void
     */
    public function massDeleteAction() {
        $marketplaceIds = $this->getRequest()->getParam('marketplace');
        if(!is_array($marketplaceIds)) {
                        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select at least one review'));
        } else {
            try {
                foreach ($marketplaceIds as $marketplaceId) {
                     Mage::helper('marketplace/marketplace')->deleteReview($marketplaceId); 
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($marketplaceIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * Approve customer reviews for sellers
     *
     * @return void
     */
    public function approveAction() {
        if( $this->getRequest()->getParam('id') > 0 ) {
            $id = $this->getRequest()->getParam('id');
                 try {
                         $model      = $collection = Mage::getModel('marketplace/sellerreview')->load($this->getRequest()->getParam('id'));
                                        $model->setStatus('1')
                                        ->save();
                     $customeId      = $model->getCustomerId();
                     $sellerId       = $model->getSellerId();
                     /**
                      * send email
                      */
                     $template_id    = (int)Mage::getStoreConfig('marketplace/seller_review/approve_review');                     
                     $admin_email_id = Mage::getStoreConfig('marketplace/marketplace/admin_email_id'); 
                     $toMailId       = Mage::getStoreConfig("trans_email/ident_$admin_email_id/email");
                     $toName         = Mage::getStoreConfig("trans_email/ident_$admin_email_id/name");
                     if ($template_id) {
                        $emailTemplate = Mage::getModel('core/email_template')->load($template_id);
                      } else {  
                        $emailTemplate = Mage::getModel('core/email_template')
                                          ->loadDefault('marketplace_seller_review_approve_review'); 
                      }
                      /**
                       * Get customer data
                       */ 
                      $customer         = Mage::getModel('customer/customer')->load($customeId);
                      $recipient        = $customer->getEmail(); 
                      $cname            = $customer->getName();
                                            $emailTemplate->setSenderName(ucwords($toName));    
                                            $emailTemplate->setSenderEmail($toMailId);         
                      $emailTemplateVariables = (array('ownername'=>ucwords($toName),'cname'=>ucwords($cname)));           
                                            $emailTemplate->setDesignConfig(array('area' => 'frontend'));
                      $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
                                            $emailTemplate->send($recipient,ucwords($cname),$emailTemplateVariables);
                      /**
                       * Get Seller data
                       */
                      $seller_data       = Mage::getModel('customer/customer')->load($sellerId);
                      $recipient_seller  = $seller_data->getEmail(); 
                      $cname_seller      = $seller_data->getName();
                      $emailTemplateVariables = (array('ownername'=>ucwords($toName),'cname'=>ucwords($cname_seller))); 
                      $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
                                            $emailTemplate->send($recipient_seller,ucwords($cname_seller),$emailTemplateVariables); 
                      /**
                       * end email
                       */
                         Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('marketplace')->__('Review approved successfully.'));
                         $this->_redirect('*/*/');
                 } catch (Exception $e) {
                         Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                         $this->_redirect('*/*/');
                 }
         }
         $this->_redirect('*/*/');
 }
 /**
  * Status as Pending once customer posted the reviews for sellers
  *
  * @return void
  */
  public function pendingAction() {
        if( $this->getRequest()->getParam('id') > 0 ) {
            $id = $this->getRequest()->getParam('id');
                 try {
                         $model = Mage::getModel('marketplace/sellerreview')->load($this->getRequest()->getParam('id'));
                         $model->setStatus('0')
                         ->save();
                         Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('marketplace')->__('Review is Pending.'));
                         $this->_redirect('*/*/');
                 } catch (Exception $e) {
                         Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                         $this->_redirect('*/*/');
                 }
         }
         $this->_redirect('*/*/');
 }
 /**
  * Delete reviews
  *
  * @return void
  */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0 ) {
                try {				
                        /**
                         *  Reset group id
                         */                                                           
                         $model = Mage::getModel('marketplace/sellerreview');
                         $model->setId($this->getRequest()->getParam('id'))->delete(); 
                        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Review successfully deleted'));
                        $this->_redirect('*/*/');
                } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                }
        }
        $this->_redirect('*/*/');
    }
    /**
     * Approve multiple customer reviews for sellers
     *
     * @return void
     */
   public function massApproveAction() {
        $marketplaceIds = $this->getRequest()->getParam('marketplace');
        if(!is_array($marketplaceIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select at least one review'));
        } else {
            try {
                foreach ($marketplaceIds as $marketplaceId) {
                     $model = Mage::helper('marketplace/marketplace')->approveReview($marketplaceId);                  
                     $customeId = $model->getCustomerId();
                     $sellerId = $model->getSellerId();
                     /**
                      * send email
                      */
                            $template_id    = (int)Mage::getStoreConfig('marketplace/seller_review/approve_review');                            
                            $admin_email_id = Mage::getStoreConfig('marketplace/marketplace/admin_email_id'); 
                            $toMailId       = Mage::getStoreConfig("trans_email/ident_$admin_email_id/email");
                            $toName         = Mage::getStoreConfig("trans_email/ident_$admin_email_id/name");
                            if ($template_id) { 
                               $emailTemplate = Mage::helper('marketplace/marketplace')->loadEmailTemplate($template_id);
                             } else {  
                               $emailTemplate = Mage::getModel('core/email_template')
                                                 ->loadDefault('marketplace_seller_review_approve_review'); 
                             }
                            /**
                       * Get customer data
                       */  
                             $customer = Mage::helper('marketplace/marketplace')->loadCustomerData($customeId);
                             $recipient = $customer->getEmail(); 
                             $cname = $customer->getName();
                             $emailTemplate->setSenderName(ucwords($toName));    
                             $emailTemplate->setSenderEmail($toMailId);         
                             $emailTemplateVariables = (array('ownername'=>ucwords($toName),'cname'=>ucwords($cname)));           
                             $emailTemplate->setDesignConfig(array('area' => 'frontend'));
                             $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
                             $emailTemplate->send($recipient,ucwords($cname),$emailTemplateVariables);
                             
                             /**
                       * Get Seller data
                       */
                             $seller_data = Mage::helper('marketplace/marketplace')->loadCustomerData($sellerId);
                             $recipient_seller = $seller_data->getEmail(); 
                             $cname_seller = $seller_data->getName();
                             $emailTemplateVariables = (array('ownername'=>ucwords($toName),'cname'=>ucwords($cname_seller))); 
                             $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
                             $emailTemplate->send($recipient_seller,ucwords($cname_seller),$emailTemplateVariables); 
                             
                           /**
                       * end email
                       */
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'A total of %d record(s) is successfully approved', count($marketplaceIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * change status to pending for multiple customer reviews
     *
     * @return void
     */
    public function massPendingAction() {
        $marketplaceIds = $this->getRequest()->getParam('marketplace');
        if(!is_array($marketplaceIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select at least one review'));
        } else {
            try {
                foreach ($marketplaceIds as $marketplaceId) {
                    Mage::helper('marketplace/marketplace')->approveReview($marketplaceId);                      
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'A total of %d record(s) is pending', count($marketplaceIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}

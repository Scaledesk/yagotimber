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
class Apptha_Marketplace_Adminhtml_ManagesellerController extends Mage_Adminhtml_Controller_action {
	protected function _initAction() {
		$this->loadLayout ()->_setActiveMenu ( 'marketplace/items' )->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Items Manager' ), Mage::helper ( 'adminhtml' )->__ ( 'Seller Manager' ) );
		return $this;
	}
	/**
	 * Load phtml file layout
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->_initAction ()->renderLayout ();
	}
	/**
	 * Edit seller data
	 *
	 * @return void
	 */
	public function editAction() {
		$id = $this->getRequest ()->getParam ( 'id' );
		$model = Mage::getModel ( 'marketplace/marketplace' )->load ( $id );
		if ($model->getId () || $id == 0) {
			$data = Mage::getSingleton ( 'adminhtml/session' )->getFormData ( true );
			if (! empty ( $data )) {
				$model->setData ( $data );
			}
			Mage::register ( 'marketplace_data', $model );
			$this->loadLayout ();
			$this->_setActiveMenu ( 'marketplace/items' );
			$this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Item Manager' ), Mage::helper ( 'adminhtml' )->__ ( 'Seller Manager' ) );
			$this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Item News' ), Mage::helper ( 'adminhtml' )->__ ( 'Seller News' ) );
			$this->getLayout ()->getBlock ( 'head' )->setCanLoadExtJs ( true );
			$this->_addContent ( $this->getLayout ()->createBlock ( 'marketplace/adminhtml_marketplace_edit' ) )->_addLeft ( $this->getLayout ()->createBlock ( 'marketplace/adminhtml_marketplace_edit_tabs' ) );
			$this->renderLayout ();
		} else {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'marketplace' )->__ ( 'Seller details does not exist' ) );
			$this->_redirect ( '*/*/' );
		}
	}
	/**
	 * Edit seller data
	 *
	 * @return void
	 */
	public function newAction() {
		$this->_forward ( 'edit' );
	}
	/**
	 * Save seller data and change the status
	 *
	 * @return void
	 */
	public function saveAction() {
		$data = $this->getRequest ()->getPost ();
		if ($data) {
			$model = Mage::getModel ( 'marketplace/marketplace' );
			$model->setData ( $data )->setId ( $this->getRequest ()->getParam ( 'id' ) );
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime () == NULL) {
					$model->setCreatedTime ( now () )->setUpdateTime ( now () );
				} else {
					$model->setUpdateTime ( now () );
				}
				$model->save ();
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'marketplace' )->__ ( 'Seller approved successfully.' ) );
				Mage::getSingleton ( 'adminhtml/session' )->setFormData ( false );
				if ($this->getRequest ()->getParam ( 'back' )) {
					$this->_redirect ( '*/*/edit', array (
							'id' => $model->getId () 
					) );
					return;
				}
				$this->_redirect ( '*/*/' );
				return;
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				Mage::getSingleton ( 'adminhtml/session' )->setFormData ( $data );
				$this->_redirect ( '*/*/edit', array (
						'id' => $this->getRequest ()->getParam ( 'id' ) 
				) );
				return;
			}
		}
		Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'marketplace' )->__ ( 'Seller details not updated' ) );
		$this->_redirect ( '*/*/' );
	}
	/**
	 * Delete multiple seller's at a time
	 *
	 * @return void
	 */
	public function massDeleteAction() {
		$marketplaceIds = $this->getRequest ()->getParam ( 'marketplace' );
		if (! is_array ( $marketplaceIds )) {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'adminhtml' )->__ ( 'Please select at least one seller' ) );
		} else {
			try {
				foreach ( $marketplaceIds as $marketplaceId ) {
					Mage::helper ( 'marketplace/marketplace' )->deleteSeller ( $marketplaceId );
					$productCollections = Mage::getModel('catalog/product')->getCollection()
					->addAttributeToFilter('seller_id',$marketplaceId);
					foreach($productCollections as $product){
						$productId = $product->getEntityId();
						$model = Mage::getModel('catalog/product')->load($productId);
						$model->delete();
					}
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Total of %d record(s) were successfully deleted', count ( $marketplaceIds ) ) );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
			}
		}
		$this->_redirect ( '*/*/index' );
	}
	/**
	 * Setting commission for admin
	 *
	 * @return void
	 */
	public function setcommissionAction() {
		$this->_initAction ()->renderLayout ();
	}
	/**
	 * Save commission information in database
	 *
	 * @return void
	 */
	public function savecommissionAction() {
		if ($this->getRequest ()->getParam ( 'id' ) > 0) {
			$id = $this->getRequest ()->getParam ( 'id' );
			$commission = $this->getRequest ()->getParam ( 'commission' );
			try {
				$collection = Mage::getModel ( 'marketplace/sellerprofile' )->load ( $id, 'seller_id' );
				$getId = $collection->getId ();
				if ($getId != '') {
					Mage::getModel ( 'marketplace/sellerprofile' )->load ( $id, 'seller_id' )->setCommission ( $commission )->save ();
				} else {
					$collection = Mage::getModel ( 'marketplace/sellerprofile' );
					$collection->setCommission ( $commission );
					$collection->setSellerId ( $id );
					$collection->save ();
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'marketplace' )->__ ( 'Seller commission saved successfully .' ) );
				$this->_redirect ( '*/*/' );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				$this->_redirect ( '*/*/' );
			}
		}
		$this->_redirect ( '*/*/' );
	}
	/**
	 * Set seller status as approve after seller register in the website
	 *
	 * @return void
	 */
	public function approveAction() {
		if ($this->getRequest ()->getParam ( 'id' ) > 0) {
			$id = $this->getRequest ()->getParam ( 'id' );
			$commission = $this->getRequest ()->getParam ( 'commission' );
			try {
				$model = Mage::getModel ( 'customer/customer' )->load ( $this->getRequest ()->getParam ( 'id' ) );
				$model->setCustomerstatus ( '1' )->save ();
				/**
				 * send email to customer regarding approval of seller registration
				 */
				$template_id = ( int ) Mage::getStoreConfig ( 'marketplace/admin_approval_seller_registration/seller_email_template_selection' );
				$admin_email_id = Mage::getStoreConfig ( 'marketplace/marketplace/admin_email_id' );
				$toMailId = Mage::getStoreConfig ( "trans_email/ident_$admin_email_id/email" );
				$toName = Mage::getStoreConfig ( "trans_email/ident_$admin_email_id/name" );
				if ($template_id) {
					$emailTemplate = Mage::getModel ( 'core/email_template' )->load ( $template_id );
				} else {
					$emailTemplate = Mage::getModel ( 'core/email_template' )->loadDefault ( 'marketplace_admin_approval_seller_registration_seller_email_template_selection' );
				}
				$customer = Mage::getModel ( 'customer/customer' )->load ( $id );
				$recipient = $customer->getEmail ();
				$cname = $customer->getName ();
				$emailTemplate->setSenderName ( ucwords ( $toName ) );
				$emailTemplate->setSenderEmail ( $toMailId );
				$emailTemplateVariables = (array (
						'ownername' => ucwords ( $toName ),
						'cname' => ucwords ( $cname ) 
				));
				$emailTemplate->setDesignConfig ( array (
						'area' => 'frontend' 
				) );
				$processedTemplate = $emailTemplate->getProcessedTemplate ( $emailTemplateVariables );
				$emailTemplate->send ( $recipient, ucwords ( $cname ), $emailTemplateVariables );
				/**
				 * end email
				 */
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'marketplace' )->__ ( 'Seller approved successfully.' ) );
				$this->_redirect ( '*/*/' );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				$this->_redirect ( '*/*/' );
			}
		}
		$this->_redirect ( '*/*/' );
	}
	/**
	 * Set seller status as disapprove after seller register in the website
	 *
	 * @return void
	 */
	public function disapproveAction() {
		if ($this->getRequest ()->getParam ( 'id' ) > 0) {
			$id = $this->getRequest ()->getParam ( 'id' );
			try {
				$model = Mage::getModel ( 'customer/customer' )->load ( $this->getRequest ()->getParam ( 'id' ) );
				$model->setCustomerstatus ( '2' )->save ();
				/**
				 * send email to admin regarding disapprove of seller registration
				 */
				$template_id = ( int ) Mage::getStoreConfig ( 'marketplace/admin_approval_seller_registration/seller_email_template_disapprove' );
				$admin_email_id = Mage::getStoreConfig ( 'marketplace/marketplace/admin_email_id' );
				$toMailId = Mage::getStoreConfig ( "trans_email/ident_$admin_email_id/email" );
				$toName = Mage::getStoreConfig ( "trans_email/ident_$admin_email_id/name" );
				if ($template_id) {
					$emailTemplate = Mage::getModel ( 'core/email_template' )->load ( $template_id );
				} else {
					$emailTemplate = Mage::getModel ( 'core/email_template' )->loadDefault ( 'marketplace_admin_approval_seller_registration_seller_email_template_disapprove' );
				}
				$customer = Mage::getModel ( 'customer/customer' )->load ( $id );
				$recipient = $customer->getEmail ();
				$cname = $customer->getName ();
				$emailTemplate->setSenderName ( ucwords ( $toName ) );
				$emailTemplate->setSenderEmail ( $toMailId );
				$emailTemplateVariables = (array (
						'ownername' => ucwords ( $toName ),
						'cname' => ucwords ( $cname ) 
				));
				$emailTemplate->setDesignConfig ( array (
						'area' => 'frontend' 
				) );
				$processedTemplate = $emailTemplate->getProcessedTemplate ( $emailTemplateVariables );
				$emailTemplate->send ( $recipient, ucwords ( $cname ), $emailTemplateVariables );
				/**
				 * end email
				 */
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'marketplace' )->__ ( 'Seller disapproved.' ) );
				$this->_redirect ( '*/*/' );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				$this->_redirect ( '*/*/' );
			}
		}
		$this->_redirect ( '*/*/' );
	}
	/**
	 * Deller seller from website
	 *
	 * @return void
	 */
	public function deleteAction() {
		if ($this->getRequest ()->getParam ( 'id' ) > 0) {
			try {
				/**
				 * Reset group id
				 */
				$model = Mage::getModel ( 'customer/customer' )->load ( $this->getRequest ()->getParam ( 'id' ) );
				$model->setGroupId ( 1 );
				$model->save ();
				$productCollections = Mage::getModel('catalog/product')->getCollection()
				->addAttributeToFilter('seller_id',$this->getRequest ()->getParam ( 'id' ) );
				foreach($productCollections as $product){
					$productId = $product->getEntityId();
					$model = Mage::getModel('catalog/product')->load($productId);
					$model->delete();
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Seller successfully deleted' ) );
				$this->_redirect ( '*/*/' );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				$this->_redirect ( '*/*/edit', array (
						'id' => $this->getRequest ()->getParam ( 'id' ) 
				) );
			}
		}
		$this->_redirect ( '*/*/' );
	}
	/**
	 * Set seller status as approve multiple seller register in the website
	 *
	 * @return void
	 */
	public function massApproveAction() {
		$marketplaceIds = $this->getRequest ()->getParam ( 'marketplace' );
		if (! is_array ( $marketplaceIds )) {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'adminhtml' )->__ ( 'Please select at least one seller' ) );
		} else {
			try {
				foreach ( $marketplaceIds as $marketplaceId ) {
					Mage::helper ( 'marketplace/marketplace' )->approveSellerStatus ( $marketplaceId );
					/**
					 * send email to customer regarding approval of seller registration
					 */
					$template_id = ( int ) Mage::getStoreConfig ( 'marketplace/admin_approval_seller_registration/seller_email_template_selection' );
					$admin_email_id = Mage::getStoreConfig ( 'marketplace/marketplace/admin_email_id' );
					$toMailId = Mage::getStoreConfig ( "trans_email/ident_$admin_email_id/email" );
					$toName = Mage::getStoreConfig ( "trans_email/ident_$admin_email_id/name" );
					if ($template_id) {
						$emailTemplate = Mage::helper ( 'marketplace/marketplace' )->loadEmailTemplate ( $template_id );
					} else {
						$emailTemplate = Mage::getModel ( 'core/email_template' )->loadDefault ( 'marketplace_admin_approval_seller_registration_seller_email_template_selection' );
					}
					$customer = Mage::helper ( 'marketplace/marketplace' )->loadCustomerData ( $marketplaceId );
					$recipient = $customer->getEmail ();
					$cname = $customer->getName ();
					$emailTemplate->setSenderName ( ucwords ( $toName ) );
					$emailTemplate->setSenderEmail ( $toMailId );
					$emailTemplateVariables = (array (
							'ownername' => ucwords ( $toName ),
							'cname' => ucwords ( $cname ) 
					));
					$emailTemplate->setDesignConfig ( array (
							'area' => 'frontend' 
					) );
					$processedTemplate = $emailTemplate->getProcessedTemplate ( $emailTemplateVariables );
					$emailTemplate->send ( $recipient, ucwords ( $cname ), $emailTemplateVariables );
				/**
				 * end email
				 */
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'A total of %d record(s) is successfully approved', count ( $marketplaceIds ) ) );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
			}
		}
		$this->_redirect ( '*/*/index' );
	}
	/**
	 * Set seller status as disapprove multiple seller register in the website
	 *
	 * @return void
	 */
	public function massDisapproveAction() {
		$marketplaceIds = $this->getRequest ()->getParam ( 'marketplace' );
		if (! is_array ( $marketplaceIds )) {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'adminhtml' )->__ ( 'Please select at least one seller' ) );
		} else {
			try {
				foreach ( $marketplaceIds as $marketplaceId ) {
					Mage::helper ( 'marketplace/marketplace' )->disapproveSellerStatus ( $marketplaceId );
					/**
					 * send email to admin regarding disapprove of seller registration
					 */
					$template_id = ( int ) Mage::getStoreConfig ( 'marketplace/admin_approval_seller_registration/seller_email_template_disapprove' );
					$admin_email_id = Mage::getStoreConfig ( 'marketplace/marketplace/admin_email_id' );
					$toMailId = Mage::getStoreConfig ( "trans_email/ident_$admin_email_id/email" );
					$toName = Mage::getStoreConfig ( "trans_email/ident_$admin_email_id/name" );
					if ($template_id) {
						$emailTemplate = Mage::helper ( 'marketplace/marketplace' )->loadEmailTemplate ( $template_id );
					} else {
						$emailTemplate = Mage::getModel ( 'core/email_template' )->loadDefault ( 'marketplace_admin_approval_seller_registration_seller_email_template_disapprove' );
					}
					$customer = Mage::helper ( 'marketplace/marketplace' )->loadCustomerData ( $marketplaceId );
					$recipient = $customer->getEmail ();
					$cname = $customer->getName ();
					$emailTemplate->setSenderName ( ucwords ( $toName ) );
					$emailTemplate->setSenderEmail ( $toMailId );
					$emailTemplateVariables = (array (
							'ownername' => ucwords ( $toName ),
							'cname' => ucwords ( $cname ) 
					));
					$emailTemplate->setDesignConfig ( array (
							'area' => 'frontend' 
					) );
					$processedTemplate = $emailTemplate->getProcessedTemplate ( $emailTemplateVariables );
					$emailTemplate->send ( $recipient, ucwords ( $cname ), $emailTemplateVariables );
				/**
				 * end email
				 */
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'A total of %d record(s) is successfully disapproved', count ( $marketplaceIds ) ) );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
			}
		}
		$this->_redirect ( '*/*/index' );
	}
} 
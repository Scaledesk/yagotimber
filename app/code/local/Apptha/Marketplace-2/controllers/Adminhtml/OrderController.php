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
class Apptha_Marketplace_Adminhtml_OrderController extends Mage_Adminhtml_Controller_action {
	protected function _initAction() {
		$this->loadLayout ()->_setActiveMenu ( 'marketplace/items' )->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Items Manager' ), Mage::helper ( 'adminhtml' )->__ ( 'Item Manager' ) );
		return $this;
	}
	/**
	 * Load phtml file layout
	 *
	 * @return void
	 */
	public function indexAction() {
		$sellerId = Mage::app ()->getRequest ()->getParam ( 'id' );
		if (empty ( $sellerId )) {
			$this->_redirect ( 'marketplaceadmin/adminhtml_orderview' );
			return;
		}
		$this->_initAction ()->renderLayout ();
	}
	/**
	 * Credit amount to seller account
	 *
	 * @return void
	 */
	public function creditAction() {
		$id = $this->getRequest ()->getParam ( 'id' );
		if ($id > 0) {
			try {
				$model = Mage::getModel ( 'marketplace/commission' )->load ( $id );
				$model->setCredited ( '1' )->save ();
				$seller_id = $model->getSellerId ();
				$admin_commission = $model->getCommissionFee ();
				$seller_commission = $model->getSellerAmount ();
				$order_id = $model->getOrderId ();
				/**
				 * transaction collection
				 */
				$transaction = Mage::getModel ( 'marketplace/transaction' )->load ( $id, 'commission_id' );
				$transaction_id = $transaction->getId ();
				if (empty ( $transaction_id )) {
					$Data = array (
							'commission_id' => $id,
							'seller_id' => $seller_id,
							'seller_commission' => $seller_commission,
							'admin_commission' => $admin_commission,
							'order_id' => $order_id,
							'received_status' => 0 
					);
					Mage::getModel ( 'marketplace/transaction' )->setData ( $Data )->save ();
				}
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'marketplace' )->__ ( 'Amount was successfully credited' ) );
				$this->_redirect ( '*/*/' );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				$this->_redirect ( '*/*/' );
			}
		}
		$this->_redirect ( '*/*/' );
	}
	/**
	 * Credit amount to multiple seller account
	 *
	 * @return void
	 */
	public function masscreditAction() {
		$marketplace = $this->getRequest ()->getPost ( 'marketplace' );
		foreach ( $marketplace as $value ) {
			$model = Mage::helper ( 'marketplace/marketplace' )->updateCredit ( $value );
			$seller_id = $model->getSellerId ();
			$admin_commission = $model->getCommissionFee ();
			$seller_commission = $model->getSellerAmount ();
			$order_id = $model->getOrderId ();
			/**
			 * transaction collection
			 */
			$transaction = Mage::helper ( 'marketplace/marketplace' )->getTransactionInfo ( $value );
			$transaction_id = $transaction->getId ();
			if (empty ( $transaction_id )) {
				$Data = array (
						'commission_id' => $value,
						'seller_id' => $seller_id,
						'seller_commission' => $seller_commission,
						'admin_commission' => $admin_commission,
						'order_id' => $order_id 
				);
				Mage::helper ( 'marketplace/marketplace' )->saveTransactionData ( $Data );
			}
		}
		Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'marketplace' )->__ ( 'Amount was successfully credited' ) );
		$this->_redirect ( '*/*/' );
	}
} 
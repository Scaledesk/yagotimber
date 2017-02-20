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

class  Apptha_Superdeals_Model_Order_Payment extends Mage_Sales_Model_Order_Payment
{
	/**
	 * Decide whether authorization transaction may close (if the amount to capture will cover entire order)
	 * @param float $amountToCapture
	 * @return bool
	 */
	protected function _isCaptureFinal($amountToCapture)
	{
		foreach($this->getOrder()->getAllItems() as $oOrderItem){
			$ordrId		= $this->getOrder()->getIncrementId();
			if($oOrderItem()->getStatus() == 'processing'){
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();
				$fields 			= array();
				$fields['status'] 	= 'Processing';
				$where 				= $connection->quoteInto('order_no=?', $ordrId);
				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			}
			elseif($oOrderItem()->getStatus() == 'complete'){
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();
				$fields 			= array();
				$fields['status'] 	= 'Complete';
				$where 				= $connection->quoteInto('order_no=?', $ordrId);
				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			}
			elseif($oOrderItem()->getStatus() == 'closed'){
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();
				$fields 			= array();
				$fields['status'] 	= 'Closed';
				$where 				= $connection->quoteInto('order_no=?', $ordrId);
				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			}
			elseif ($oOrderItem()->getStatus()  == 'canceled') {
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();
				$fields 			= array();
				$fields['status'] 	= 'Canceled';
				$where 				= $connection->quoteInto('order_no=?', $ordrId);
				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			} elseif ($oOrderItem()->getStatus() == 'holded') {
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();
				$fields			  = array();
				$fields['status'] = 'On Hold';
				$where 			  = $connection->quoteInto('order_no=?', $ordrId);
				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			} elseif ($oOrderItem()->getStatus() == 'fraud') {
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();
				$fields = array();
				$fields['status'] = 'Suspected Fraud';
				$where = $connection->quoteInto('order_no=?', $ordrId);

				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			}  elseif ($oOrderItem()->getStatus() == 'payment_review') {
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();
				$fields = array();
				$fields['status'] = 'Payment Review';
				$where = $connection->quoteInto('order_no=?', $ordrId);
				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			} elseif ($oOrderItem()->getStatus() == 'pending') {
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();

				$fields = array();
				$fields['status'] = 'Pending';
				$where = $connection->quoteInto('order_no=?', $ordrId);

				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			} elseif ($oOrderItem()->getStatus() == 'pending_payment') {
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();

				$fields = array();
				$fields['status'] = 'Pending Payment';
				$where = $connection->quoteInto('order_no=?', $ordrId);

				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			} elseif ($oOrderItem()->getStatus() == 'pending_paypal') {
				$connection = Mage::getSingleton('core/resource')
				->getConnection('core_write');
				$connection->beginTransaction();

				$fields = array();
				$fields['status'] = 'Pending PayPal';
				$where = $connection->quoteInto('order_no=?', $ordrId);

				$connection->update('superdeals_orders', $fields, $where);
				$connection->commit();
			}
		}
		return parent::_isCaptureFinal($amountToCapture);
	}
}

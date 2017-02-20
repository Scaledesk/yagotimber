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
 * This file is used to event observer
 */
class Apptha_Superdeals_Model_Observer extends Mage_Core_Model_Abstract {

    const EMAIL_TO_RECIPIENT_TEMPLATE_XML_PATH = 'superdeals/general/email_template';
    const XML_PATH_EMAIL_IDENTITY = 'superdeals/general/sender_email_id';
    const XML_PATH_EMAIL_RECIPIENT = 'superdeals/general/receiver_email_id';
    const EMAIL_TO_RECIPIENT_TEMPLATE_NOTIFY_XML_PATH = 'superdeals/general/notify_template';
    /**
     * Sending the deal statistics email
     * 
     * return void
     */
    public function SendStatisticsMail() {

        if ((Mage::helper('superdeals')->isDealzEnabled()) && (Mage::helper('superdeals')->isMailEnabled())) {
            $now = Mage::getModel('core/date')->timestamp(time());
            $end = date('Y-m-d' . ' 00:00:00', $now);
            $start = Mage::getModel('core/date')->timestamp(date('Y-m-d' . ' 00:00:00', strtotime("-1 Week")));
            $start = date('Y-m-d' . ' 00:00:00', $start);
            $model = Mage::getModel('superdeals/dealstatistics')->getCollection()
                    ->addFieldToFilter('deal_start_date', array('to' => $end))
                    ->addFieldToFilter('deal_end_date', array('from' => $start));
            $i = 1;

            foreach ($model as $mod) {
                $dealDetails .= '<tr style="background:#F8F7F5;">
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $i . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:bold 13px arial; padding:5px; border-bottom: 0;">' . $mod->getDealId() . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $mod->getQuantity() . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $mod->getDealStartDate() . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $mod->getDealEndDate() . '</td><br/>
                               </tr>';
                $i++;
            }

            $template = self::EMAIL_TO_RECIPIENT_TEMPLATE_XML_PATH;
            $email = self::XML_PATH_EMAIL_IDENTITY;
            $reciptent = self::XML_PATH_EMAIL_RECIPIENT;

            /**
             * To create new object
             */
            $postObject = new Varien_Object();
            /**
             * set data to send in the email template
             */
            $postObject->setData('deal_details', $dealDetails);
            $from_namee = Mage::getStoreConfig('trans_email/ident_general/name');
            $postObject->setData('owner_name', $from_namee);

            try {

                $templateId = Mage::getStoreConfig($template);
                $reciptentTo = Mage::getStoreConfig($reciptent);
                $from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
                $from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
                $sender = array('name' => $from_name, 'email' => $from_email);
                $mailTemplate = Mage::getModel('core/email_template');

                /* Send Transactional Email */
                //$mailTemplate->sendTransactional(
                //$templateId, $sender, $reciptentTo, $from_name, $postObject->getData()
                //);
            } catch (Exception $e) {

                $this->_getSession()->addError(Mage::helper('superdeals')->__("Email can not be send !"));
            }
        }
    }

    /**
     * Send Periodic Mail to Admin When a Deal End
     * 
     * return void
     */
    public function SendNotificationMail() {

        if ((Mage::helper('superdeals')->isDealzEnabled()) && (Mage::helper('superdeals')->isMailEnabled())) {
            $sym = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
            $notifyDays = Mage::getStoreConfig('superdeals/general/deal_end_notification');
            $now = Mage::getModel('core/date')->timestamp(time());
            $now = date('Y-m-d', $now);
            $end = Mage::getModel('core/date')->timestamp(date('Y-m-d', strtotime("+$notifyDays days")));
            $end = date('Y-m-d', $end);
            $model = Mage::getModel('superdeals/dealstatistics')->getCollection()
                    ->addFieldToFilter('deal_end_date', array('from' => $now, 'to' => $end));

            if (count($model) != 0) {
                $i = 1;
                foreach ($model as $mod) {
                    $dealEndDetails .= '<tr style="background:#F8F7F5;">
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $i . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:bold 13px arial; padding:5px; border-bottom: 0;">' . $mod->getDealId() . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $sym . $mod->getActualPrice() . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $sym . $mod->getDealPrice() . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $mod->getDealStartDate() . '</td>
                                     <td valign="top" style="border-width: 0; text-align:center; border: 1px solid #CCC; border-right:0; border-top:0; color: #0A263C; font:normal 13px arial; padding:5px; border-bottom: 0;">' . $mod->getDealEndDate() . '</td><br/>
                                     </tr>';
                    $i++;
                }

                $template = self::EMAIL_TO_RECIPIENT_TEMPLATE_NOTIFY_XML_PATH;
                $email = self::XML_PATH_EMAIL_IDENTITY;
                $reciptent = self::XML_PATH_EMAIL_RECIPIENT;
                /**
                 * To create new object
                 */
                $postObject = new Varien_Object();
                /**
                 * set data to send in the email template
                 */
                $postObject->setData('deal_details', $dealEndDetails);
                $from_namee = Mage::getStoreConfig('trans_email/ident_general/name');
                $postObject->setData('owner_name', $from_namee);

                try {

                    $templateId = Mage::getStoreConfig($template);
                    $reciptentTo = Mage::getStoreConfig($reciptent);
                    $from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
                    $from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
                    $sender = array('name' => $from_name, 'email' => $from_email);
                    $mailTemplate = Mage::getModel('core/email_template');

                    /**
                     *  Send Transactional Email 
                     */
                    $mailTemplate->sendTransactional(
                            $templateId, $sender, $reciptentTo, $from_name, $postObject->getData()
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError(Mage::helper('superdeals')->__("Email can not be send !"));
                }
            }
        }
    }

    /**
     * check order status of payapal
     * 
     * return void
     */
    public function salesOrderStatusAfter(Varien_Event_Observer $observer) {
        $event = $observer->getEvent();
        $quantity = '';
        $order_id = $event->getOrder()->getId();
        $order = Mage::getModel('sales/order')->load($order_id);
        $ordrId = $event->getOrder()->getIncrementId();
        $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
        $items = $order->getAllItems();
        $itemcount = count($items);
        $tablePrefix = (string) Mage::getConfig()->getTablePrefix(); //get table prefix
        $orderTable = $tablePrefix . 'superdeals_orders';
        foreach ($items as $itemId => $item) {
            $product_id = $item->getProductId();
            $sku = $item->getSku();
            $quantity = $item->getQtyOrdered();
            $obj = Mage::getModel('catalog/product');
            $_product = $obj->load($product_id);
            $productName = $_product->getName();
            $status = $event->getStatus();
            $originalPrice = $_product->getPrice();
            $specialPrice = $_product->getSpecialPrice();
            $dealSpecialFromDate = $_product->getData('special_from_date');
            $dealSpecialToDate = $_product->getData('special_to_date');
            $now = Mage::getModel('core/date')->timestamp(time());
            $now = date('Y-m-d' . ' 00:00:00', $now);         
            $totalSales = $quantity * $specialPrice;
            $saveAmount = ($originalPrice - $specialPrice) * $quantity;

            if ((!empty($specialPrice)) && (($dealSpecialToDate > $now || empty($dealSpecialToDate)) )) {
                if ($status == 'complete' || $status == 'processing' || $status == 'closed') {
                    $connection = Mage::getSingleton('core/resource')
                            ->getConnection('core_write');
                    $connection->beginTransaction();
                    $fields = array();
                    $dup = Mage::getModel('superdeals/dealz')->getCollection()
                            ->addFieldToFilter('duplicate', 1)
                            ->addFieldToFilter('order_no', $ordrId);
                    $dupp = count($dup);
                    if ($status == 'complete' && $dupp != 1) {
                        $quantity = $item->getQtyInvoiced();
                        $fields['status'] = 'Complete';
                        $fields['product_status'] = 'Complete';
                        $where = $connection->quoteInto('order_no =?', $ordrId);
                        $connection->update($orderTable, $fields, $where);
                        $connection->commit();
                    } elseif ($status == 'complete') {
                        $fields['status'] = 'Complete';
                        $fields['product_status'] = 'Complete';
                        $where = $connection->quoteInto('order_no =?', $ordrId);
                        $connection->update($orderTable, $fields, $where);
                        $connection->commit();
                    } elseif ($status == 'processing') {
                        $quantity = $item->getQtyToShip();
                        $fields['status'] = 'Processing';
                        $fields['product_status'] = 'Complete';
                        $fields['duplicate'] = 1;
                        $duplicate = 1;
                        $where = $connection->quoteInto('order_no =?', $ordrId);
                        $connection->update($orderTable, $fields, $where);
                        $connection->commit();
                    } elseif ($status == 'closed') {
                        $dup = Mage::getModel('superdeals/dealz');
                        $dupp = $dup->load($order_id);
                        $dupQty = $dupp->getQuantity();
                        $quantity = $dupQty;
                        $fields['status'] = 'Closed';
                        $fields['product_status'] = 'Closed';
                        $where = $connection->quoteInto('order_no =?', $ordrId);
                        $connection->update($orderTable, $fields, $where);
                        $connection->commit();
                    }

                    $tPrefix = (string) Mage::getConfig()->getTablePrefix(); //get table prefix
                    $statisticsTable = $tPrefix . 'superdeals_reports';
                    $write = Mage::getSingleton('core/resource')->getConnection('core_write'); //get db connection

                    $connection = Mage::getSingleton('core/resource')
                            ->getConnection('core_read');

                    $select = $connection->select()
                            ->from($statisticsTable, array('deal_id'))
                            ->where('deal_id=?', $productName);

                    $productArray = $connection->fetchRow($select);
                    $product = $productArray['deal_id'];

                    if ($product != null) {
                        $selectResult = $write->query("select max(serial_id) from $statisticsTable where deal_id = '$productName'");
                        $serialId = $selectResult->fetch(PDO::FETCH_COLUMN);
                        $connection = Mage::getSingleton('core/resource')
                                ->getConnection('core_read');
                        $select = $connection->select()
                                ->from($statisticsTable, array('quantity'))
                                ->where('serial_id=?', $serialId);
                        $oldQuantityArray = $connection->fetchRow($select);
                        $oldQuantity = $oldQuantityArray['quantity'];

                        /**
                         * TO GET PRODUCT STATUS FROM SUPERDEALS_ORDERS TABLE
                         */
                        
                        $value = $connection->select()
                                ->from($orderTable, array('product_status', 'status'))
                                ->where('order_no=?', $ordrId);

                        $oldStatusArray = $connection->fetchRow($value);
                        $completeStatus = $oldStatusArray['product_status'];
                        $state = $oldStatusArray['status'];
                        if ($status == 'holded') {
                            $newQuantity = $oldQuantity - $quantity;
                        } else {
                            $newQuantity = $oldQuantity + $quantity;
                        }
                        $newSales = $newQuantity * $specialPrice;
                        $saveAmount = ($originalPrice - $specialPrice) * $newQuantity;
                        $connection = Mage::getSingleton('core/resource')
                                ->getConnection('core_write');
                        $connection->beginTransaction();
                        $fields = array();
                        $fields['quantity'] = $newQuantity;
                        $fields['total_sales'] = $newSales;
                        $fields['save_amount'] = $saveAmount;
                        $fields['status'] = 'Active';
                        $where = $connection->quoteInto('serial_id=?', $serialId);
                        $connection->update($statisticsTable, $fields, $where);
                        $connection->commit();
                    } else {
                        /**
                         * Collection starts here
                         */
                        $model = Mage::getModel('superdeals/dealstatistics');
                        $model->setProductId($product_id)
                                ->setDealId($productName)
                                ->setSku($sku)
                                ->setQuantity($quantity)
                                ->setActualPrice($originalPrice)
                                ->setDealPrice($specialPrice)
                                ->setTotalSales($newSales)
                                ->setSaveAmount($saveAmount)
                                ->setDealStartDate($dealSpecialFromDate)
                                ->setDealEndDate($dealSpecialToDate)
                                ->setStatus('Active');
                        $model->save();
                    }
                }
            } elseif ($status == 'canceled') {
            	$tablePrefix = 
                $connection = Mage::getSingleton('core/resource')
                        ->getConnection('core_write');
                $connection->beginTransaction();
                $fields = array();
                $fields['status'] = 'Canceled';
                $where = $connection->quoteInto('order_no=?', $ordrId);
                $connection->update($orderTable, $fields, $where);
                $connection->commit();
            } elseif ($status == 'holded') {
                $connection = Mage::getSingleton('core/resource')
                        ->getConnection('core_write');
                $connection->beginTransaction();
                $fields = array();
                $fields['status'] = 'On Hold';
                $where = $connection->quoteInto('order_no=?', $ordrId);
                $connection->update($orderTable, $fields, $where);
                $connection->commit();
            } elseif ($status == 'fraud') {
                $connection = Mage::getSingleton('core/resource')
                        ->getConnection('core_write');
                $connection->beginTransaction();

                $fields = array();
                $fields['status'] = 'Suspected Fraud';
                $where = $connection->quoteInto('order_no=?', $ordrId);

                $connection->update($orderTable, $fields, $where);
                $connection->commit();
            } elseif ($status == 'payment_review') {
                $connection = Mage::getSingleton('core/resource')
                        ->getConnection('core_write');
                $connection->beginTransaction();
                $fields = array();
                $fields['status'] = 'Payment Review';
                $where = $connection->quoteInto('order_no=?', $ordrId);
                $connection->update($orderTable, $fields, $where);
                $connection->commit();
            } elseif ($status == 'pending') {
                $connection = Mage::getSingleton('core/resource')
                        ->getConnection('core_write');
                $connection->beginTransaction();

                $fields = array();
                $fields['status'] = 'Pending';
                $where = $connection->quoteInto('order_no=?', $ordrId);

                $connection->update($orderTable, $fields, $where);
                $connection->commit();
            } elseif ($status == 'pending_payment') {
                $connection = Mage::getSingleton('core/resource')
                        ->getConnection('core_write');
                $connection->beginTransaction();

                $fields = array();
                $fields['status'] = 'Pending Payment';
                $where = $connection->quoteInto('order_no=?', $ordrId);

                $connection->update($orderTable, $fields, $where);
                $connection->commit();
            } elseif ($status == 'pending_paypal') {
                $connection = Mage::getSingleton('core/resource')
                        ->getConnection('core_write');
                $connection->beginTransaction();

                $fields = array();
                $fields['status'] = 'Pending PayPal';
                $where = $connection->quoteInto('order_no=?', $ordrId);

                $connection->update($orderTable, $fields, $where);
                $connection->commit();
            }
        }
    }

    /**
     * Save deal order in custom table
     * 
     * return void
     */
    public function afterSalesOrderSaved(Varien_Event_Observer $observer) {
        $event = $observer->getEvent();
        $orderId = $event->getOrder()->getId();
        $order = Mage::getModel('sales/order')->load($orderId);
        $customer = Mage::getsingleton('customer/customer')->load($order->getCustomerId());
        $items = $order->getAllItems();        
        foreach ($items as $itemId => $item) {
            $productId = $item->getProductId();
            $obj = Mage::getModel('catalog/product');
            $product = $obj->load($productId);
            $productName = $product->getName();
            $originalPrice = $product->getPrice();
            $specialPrice = $product->getSpecialPrice();            
            $dealSpecialToDate = $product->getData('special_to_date');
            $now = Mage::getModel('core/date')->timestamp(time());
            $now = date('Y-m-d' . ' 00:00:00', $now);
            $email = $customer->getEmail(); //get email of a customer
            $firstname = $customer->getFirstname(); //  get Firstname of a customer
            $lastname = $customer->getLastname(); //get lastname of customer
            if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
                $email = $order->getBillingAddress()->getEmail(); // To get Email Id of a customer
                $firstname = $order->getBillingAddress()->getFirstname(); // To get Firstname of a customer
                $lastname = $order->getBillingAddress()->getLastname();
            }
            if (!empty($specialPrice) && (($dealSpecialToDate > $now || empty($dealSpecialToDate)) )) {
                $model = Mage::getModel('superdeals/dealz');
                $model->setCustomerId($firstname . " " . $lastname)
                        ->setCustomerMailId($email)
                        ->setOrderNo($order->getIncrementId())
                        ->setDealId($productName)
                        ->setQuantity($item->getQtyToInvoice())
                        ->setActualPrice($originalPrice)
                        ->setDealPrice($specialPrice)
                        ->setPurchaseDate($order->getCreated_at())
                        ->setStatus('Pending');
                $model->save();
            }
        }
    }

    /**
     * Save data in deal statistics table
     * 
     * return void
     */
    public function afterProductSaved(Varien_Event_Observer $observer) {
        $product = $observer->getProduct();
        $dealName = $product->getName();
        $dealOriginalPrice = $product->getPrice();
        $dealprice = floatval($dealOriginalPrice);
        $dealSpecialPrice = $product->getSpecialPrice();
        $dealSpecialFromDate = $product->getData('special_from_date');       
        $dealSpecialToDate = $product->getData('special_to_date');
        $tPrefix = (string) Mage::getConfig()->getTablePrefix(); //get table prefix
        $statisticsTable = $tPrefix . 'superdeals_reports';
        if (empty($dealSpecialToDate)) {
            $dealSpecialToDate = NULL;
        }
        $now = Mage::getModel('core/date')->timestamp(time());
        $now = date('Y-m-d' . ' 00:00:00', $now);
        $product_id = $product->getEntityId();
        $sku = $product->getSku();
        $sample = Mage::getModel('superdeals/dealstatistics')->getCollection()
                ->addFieldToFilter('deal_id', $dealName)
                ->addFieldToFilter('product_id', $product_id)
                ->addFieldToFilter('sku', $sku)
                ->addFieldToFilter('actual_price', $dealprice)
                ->addFieldToFilter('deal_price', $dealSpecialPrice)
                ->addFieldToFilter('deal_start_date', $dealSpecialFromDate)
                ->addFieldToFilter('status', 'Active');
        if (!empty($dealSpecialToDate))
            $sample->addFieldToFilter('deal_end_date', $dealSpecialToDate);
        $count = count($sample);
        if ($count == 0) {
            if ((!empty($dealSpecialPrice)) && (($dealSpecialToDate > $now || empty($dealSpecialToDate)) && ($dealprice > $dealSpecialPrice))) {

                /**
                 *  Update Old Deal With same name to inactive
                 */
                $connections = Mage::getSingleton('core/resource')
                        ->getConnection('core_write');
                $connections->beginTransaction();
                $fields = array();
                $fields['status'] = 'Inactive';
                $where = $connections->quoteInto('product_id=?', $product_id);
                $connections->update($statisticsTable, $fields, $where);
                $connections->commit();
                $collection = Mage::getModel('superdeals/dealstatistics');
                $data = array('product_id' => $product_id, 'deal_id' => $dealName, 'sku' => $sku, 'quantity' => 0, 'actual_price' => $dealOriginalPrice, 'deal_price' => $dealSpecialPrice, 'deal_start_date' => $dealSpecialFromDate, 'deal_end_date' => $dealSpecialToDate, 'status' => "Active");
                $collection->setData($data);
                $collection->save();
            }
        }       
        $now = Mage::getModel('core/date')->timestamp(time());
        $now = date('Y-m-d', $now);
        $model = Mage::getModel('superdeals/dealstatistics')->getCollection()
                ->addFieldToFilter('deal_end_date', array('lteq' => $now));        
        if (!empty($model)) {
            $connections = Mage::getSingleton('core/resource')
                    ->getConnection('core_write');
            $connections->beginTransaction();
            $fields = array();
            $fields['status'] = 'Inactive';
            $where = $connections->quoteInto('deal_end_date<=?', $now);
            $connections->update($statisticsTable, $fields, $where);
            $connections->commit();
        }
    }

}
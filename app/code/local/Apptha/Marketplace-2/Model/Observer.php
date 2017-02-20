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
 */

/**
 * Event Observer 
 */
class Apptha_Marketplace_Model_Observer {

    /**
     * Order saved successfully then commisssion information will be saved in database and email notification 
     * will be sent to seller
     * 
     * Order information will be get from the $observer parameter
     * @param array $observer
     * 
     * @return void
     */
    public function successAfter($observer) {
        $orderIds = $observer->getEvent()->getOrderIds();
        $order = Mage::getModel('sales/order')->load($orderIds[0]);      
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $getCustomerId = $customer->getId();
        $grandTotal = $order->getGrandTotal();
        $status = $order->getStatus();
        $itemCount = 0;
        $shippingCountryId = '';
        /**
         *  getting Product information to update commission details
         */
        $items = $order->getAllItems();
        $orderEmailData = array();
        foreach ($items as $item) {  
            $getProductId = $item->getProductId();
            $createdAt = $item->getCreatedAt();
            $paymentMethodCode = $order->getPayment()->getMethodInstance()->getCode();
            $products = Mage::helper('marketplace/marketplace')->getProductInfo($getProductId);
            $sellerId = $products->getSellerId();
            $productType=$products->getTypeID();
            $sellerShippingEnabled = Mage::getStoreConfig('carriers/apptha/active');
            if($sellerShippingEnabled == 1 && $productType == 'simple'){
            	$nationalShippingPrice = $products->getNationalShippingPrice();
            	$internationalShippingPrice = $products->getInternationalShippingPrice();
            	$sellerDefaultCountry = $products->getDefaultCountry();
            	$shippingCountryId = $order->getShippingAddress()->getCountry();
            }
            if ($sellerId) {
                if ($paymentMethodCode == 'paypaladaptive') {
                    $credited = 1;
                    $orderPrice = $item->getPrice() * $item->getQtyOrdered();
                    $productAmt = $item->getPrice();
                    $productQty = $item->getQtyOrdered();
                 if($sellerDefaultCountry == $shippingCountryId){
                    	$shippingPrice = $orderPrice + ($nationalShippingPrice * $productQty);
                    } else {
                    	$shippingPrice = $orderPrice + ($internationalShippingPrice* $productQty);
                    }
                } else {
                    $credited = 0;
                   $orderPrice = $item->getPrice() * $item->getQtyOrdered();
                   $productAmt = $item->getPrice();
                   $productQty = $item->getQtyOrdered();
                    if($sellerDefaultCountry == $shippingCountryId){
                    	$shippingPrice = $orderPrice + ($nationalShippingPrice * $productQty);
                    } else {
                    	$shippingPrice = $orderPrice + ($internationalShippingPrice* $productQty);
                    }
                }
                /**
                 * Getting seller commission percent              
                 */
                $sellerCollection = Mage::helper('marketplace/marketplace')->getSellerCollection($sellerId);
                $percentperproduct = $sellerCollection['commission'];
                $commissionFee = $orderPrice * ($percentperproduct / 100);
                $sellerAmount = $shippingPrice - $commissionFee;

                /**
                 *  Storing commission information in database table 
                 */
                $commissionData = array('seller_id' => $sellerId, 'product_id' => $getProductId, 'product_qty' => $productQty, 'product_amt' => $productAmt, 'commission_fee' => $commissionFee, 'seller_amount' => $sellerAmount, 'order_id' => $order->getId(), 'increment_id' => $order->getIncrementId(), 'order_total' => $grandTotal, 'order_status' => $status, 'credited' => $credited, 'customer_id' => $getCustomerId, 'status' => 1, 'created_at' => $createdAt, 'payment_method' => $paymentMethodCode);
                $commissionId = $this->storeCommissionData($commissionData);
                $orderEmailData[$itemCount]['seller_id'] = $sellerId;
                $orderEmailData[$itemCount]['product_id'] = $getProductId;
                $orderEmailData[$itemCount]['product_qty'] = $productQty;
                $orderEmailData[$itemCount]['product_amt'] = $productAmt;
                $orderEmailData[$itemCount]['commission_fee'] = $commissionFee;
                $orderEmailData[$itemCount]['seller_amount'] = $sellerAmount;
                $orderEmailData[$itemCount]['increment_id'] = $order->getIncrementId();
                $orderEmailData[$itemCount]['customer_email'] = $order->getCustomerEmail();
                $orderEmailData[$itemCount]['customer_firstname'] = $order->getCustomerFirstname();
                $itemCount = $itemCount + 1;
            }
            if ($paymentMethodCode == 'paypaladaptive') {
                /**
                 * If payment method is paypal adaptive, then commission table(credited to seller) and transaction table(amout paid to seller) will be updated
                 */
                $model = Mage::helper('marketplace/marketplace')->getCommissionInfo($commissionId);
                $sellerId = $model->getSellerId();
                $adminCommission = $model->getCommissionFee();
                $sellerCommission = $model->getSellerAmount();
                $orderId = $model->getOrderId();
                $commissionId = $model->getId();
                /**
                 * transaction collection to update the payment information 
                 */
                $transaction = Mage::helper('marketplace/marketplace')->getTransactionInfo($commissionId);
                $transactionId = $transaction->getId();
                if (empty($transactionId)) {
                    $Data = array('commission_id' => $commissionId, 'seller_id' => $sellerId, 'seller_commission' => $sellerCommission, 'admin_commission' => $adminCommission, 'order_id' => $orderId, 'received_status' => 0);
                    Mage::helper('marketplace/marketplace')->saveTransactionData($Data);
                }
                /**
                 * Update the database after admin paid seller amount
                 */
                $transactions = Mage::getModel('marketplace/transaction')->getCollection()
                        ->addFieldToFilter('seller_id', $sellerId)
                        ->addFieldToSelect('id')
                        ->addFieldToFilter('paid', 0);
                foreach ($transactions as $transaction) {
                    $transactionId = $transaction->getId();
                    if (!empty($transactionId)) {
                        Mage::helper('marketplace/marketplace')->updateTransactionData($transactionId);
                    }
                }
            }
        }
		
        if (Mage::getStoreConfig('marketplace/admin_approval_seller_registration/sales_notification') == 1) {
            $this->sendOrderEmail($orderEmailData);
        }
    }

    /**
     * Save seller commission data in database and get the commission id
     * 
     * Commission information passed to update in database 
     * @param array $commissionData
     * 
     * This function will return the commission id of the last saved data
     * @return int
     */
    public function storeCommissionData($commissionData) {
        $model = Mage::getModel('marketplace/commission');
        $model->setData($commissionData);
        $model->save();
        $commissionId = $model->getId();
        return $commissionId;
    }

    /**
     * If Order status changed successfully then commisssion information will be saved in database and email notification 
     * will be sent to seller
     * 
     * @return void
     */
    public function salesOrderAfter() {
    	$shippingCountryId = $sellerDefaultCountry = '';
    	$nationalShippingPrice =	$internationalShippingPrice = 0;
        $orderId = (int) Mage::app()->getRequest()->getParam('order_id');
        if ($orderId) {        	
            $orders = Mage::getModel('sales/order')->load($orderId);
            $statusOrder = $orders->getStatus();
            $commissions = Mage::getModel('marketplace/commission')->getCollection()
                    ->addFieldToFilter('order_id', $orderId)
                    ->addFieldToSelect('id');
            $count = count($commissions);
            if ($count > 0) {
                foreach ($commissions as $commission) {
                    $commissionId = $commission->getId();
                    if (!empty($commissionId)) {
                        Mage::helper('marketplace/marketplace')->updateCommissionData($statusOrder, $commissionId);
                    }
                }
            } else {
                $order = Mage::getModel('sales/order')->load($orderId);
                $customer = Mage::getSingleton('customer/session')->getCustomer();
                $getCustomerId = $customer->getId();
                $grandTotal = $order->getGrandTotal();
                $status = $order->getStatus();
                /**
                 * get Product details to update commission information
                 */
                $items = $order->getAllItems();
                foreach ($items as $item) {
                    $getProductId = $item->getProductId();
                    $createdAt = $item->getCreatedAt();
                    $paymentMethodCode = $order->getPayment()->getMethodInstance()->getCode();
                    $products = Mage::helper('marketplace/marketplace')->getProductInfo($getProductId);
                    $productType = $products->getTypeID();
                    $sellerShippingEnabled = Mage::getStoreConfig('carriers/apptha/active');
                    if($sellerShippingEnabled == 1 && $productType == 'simple'){
                    	$nationalShippingPrice = $products->getNationalShippingPrice();
                    	$internationalShippingPrice = $products->getInternationalShippingPrice();
                    	$sellerDefaultCountry = $products->getDefaultCountry();
                    	$shippingCountryId = $orders->getShippingAddress()->getCountry();
                    	
                    }
                    $sellerId = $products->getSellerId();
                    if ($sellerId) {
                        $credited = 1;
                        $orderPrice = $item->getPrice() * $item->getQtyOrdered();
                        $productAmt = $item->getPrice();
                        $productQty = $item->getQtyOrdered();
                    if($sellerDefaultCountry == $shippingCountryId){
                    	$shippingPrice = $orderPrice + ($nationalShippingPrice * $productQty);
                    } else {
                    	$shippingPrice = $orderPrice + ($internationalShippingPrice* $productQty);
                    }
                    }
                    /**
                     * Get seller commission percent
                     */
                    $sellerCollection = Mage::helper('marketplace/marketplace')->getSellerCollection($sellerId);
                    $percentPerProduct = $sellerCollection['commission'];
                    $commissionFee = $orderPrice * ($percentPerProduct / 100);
                  $sellerAmount = $shippingPrice - $commissionFee;

                    /**
                     *  Storing commission information in database
                     */
                    $commissionData = array('seller_id' => $sellerId, 'product_id' => $getProductId, 'product_qty' => $productQty, 'product_amt' => $productAmt, 'commission_fee' => $commissionFee, 'seller_amount' => $sellerAmount, 'order_id' => $order->getId(), 'increment_id' => $order->getIncrementId(), 'order_total' => $grandTotal, 'order_status' => $status, 'credited' => $credited, 'customer_id' => $getCustomerId, 'status' => 1, 'created_at' => $createdAt, 'payment_method' => $paymentMethodCode);
                    $commissionId = $this->storeCommissionData($commissionData);
                }
                if ($paymentMethodCode == 'paypaladaptive') {
                    /**
                     * If payment method is paypal adaptive, then commission table(credited to seller) and transaction table(amout paid to seller) will be updated
                     */
                    $model = Mage::helper('marketplace/marketplace')->getCommissionInfo($commissionId);
                    $sellerId = $model->getSellerId();
                    $adminCommission = $model->getCommissionFee();
                    $sellerCommission = $model->getSellerAmount();
                    $orderId = $model->getOrderId();
                    $commissionId = $model->getId();
                    /**
                     * transaction collection to update the payment information 
                     */
                    $transaction = Mage::helper('marketplace/marketplace')->getTransactionInfo($commissionId);
                    $transactionId = $transaction->getId();
                    if (empty($transactionId)) {
                        $Data = array('commission_id' => $commissionId, 'seller_id' => $sellerId, 'seller_commission' => $sellerCommission, 'admin_commission' => $adminCommission, 'order_id' => $orderId, 'received_status' => 0);
                        Mage::getModel('marketplace/transaction')->setData($Data)->save();
                    }
                    /**
                     * Update the database after admin paid seller amount
                     */
                    $transactions = Mage::getModel('marketplace/transaction')->getCollection()
                            ->addFieldToFilter('seller_id', $sellerId)
                            ->addFieldToSelect('id')
                            ->addFieldToFilter('paid', 0);
                    foreach ($transactions as $transaction) {
                        $transactionId = $transaction->getId();
                        if (!empty($transactionId)) {
                            Mage::helper('marketplace/marketplace')->updateTransactionData($transactionId);
                        }
                    }
                }
            }
        }
    }

    /**
     * creditmemo(Refund process)
     * 
     * Order information will be get from the $observer parameter
     * @param array $observer
     * 
     * @return void
     */
    public function creditMemoEvent(Varien_Event_Observer $observer) {

        $orderId = (int) Mage::app()->getRequest()->getParam('order_id');
        $creditmemo = $observer->getEvent()->getCreditmemo();
        $items = $creditmemo->getAllItems();
        foreach ($items as $item) {
            $getProductId = $item->getProductId();
            /**
             * Gettings commission information in database table 
             */
            $commissions = Mage::getModel('marketplace/commission')->getCollection()
                    ->addFieldToFilter('order_id', $orderId)
                    ->addFieldToFilter('product_id', $getProductId)
                    ->addFieldToSelect('id')
                    ->addFieldToSelect('product_qty');
            foreach ($commissions as $commission) {
                $commissionId = $commission->getId();
                $commissionQty = $commission->getProductQty();
                $qty = $commissionQty - $item->getQty();
                $sellerId = $commission->getSellerId();
                $orderPrice = $item->getPrice() * $qty;
                /**
                 * Gettings seller information in database table 
                 */
                $sellerCollection = Mage::helper('marketplace/marketplace')->getSellerCollection($sellerId);
                $percentperproduct = $sellerCollection['commission'];
                $commissionFee = $orderPrice * ($percentperproduct / 100);
                $sellerAmount = $orderPrice - $commissionFee;
                if (empty($sellerAmount)) {
                    $status = 0;
                } else {
                    $status = 1;
                }
                /**
                 * update commission information in database table 
                 */
                if (!empty($commissionId)) {
                    $Data = array('product_qty' => $qty, 'commission_fee' => $commissionFee, 'seller_amount' => $sellerAmount, 'status' => $status);
                    Mage::helper('marketplace/marketplace')->saveCommissionData($Data, $commissionId);
                }
            }
        }
    }

    /**
     * If product edit(enable/disable) from admin panel this event function will be called to 
     * send email notification to seller  
     * 
     * Product information will be get from the $observer parameter
     * @param array $observer
     * 
     * @return void
     */
    public function productEditAction($observer) {
        /**
         *  Checking whether email notification enabled or not
         */
        if (Mage::getStoreConfig('marketplace/product/productmodificationnotification')) {

            $product = array();
            $productGroupId = $sellerId = $productUrl = $marketplaceGroupId = $savedProductStatus = $savedProductCreatedat = $savedProductUpdatedat = $savedProductUpdatedat = '';
            $store = 0;
            $storeName = 'All Store Views';
            $product = $observer->getProduct();
            $productGroupId = $product->getGroupId();
            $sellerId = $product->getSellerId();
            $productStatus = $product->getStatus();
            $marketplaceGroupId = Mage::helper('marketplace')->getGroupId();
            $observer->getStoreId();
            if ($store != 0) {
                $storeName = Mage::getModel('core/store')->load($store);
            } else {
                $storeName = 'All Store Views';
            }
            $savedProductId = $product->getId();
            $savedProduct = Mage::getModel('catalog/product')->load($savedProductId);
            $savedProductStatus = $savedProduct->getStatus();
            if ($savedProductStatus != $productStatus && count($savedProduct) >= 1) {
                if ($productGroupId == $marketplaceGroupId) {
                    if ($productStatus == 1) {
                        $templateId = (int) Mage::getStoreConfig('marketplace/product/addproductenabledemailnotificationtemplate');
                    } else {
                        $templateId = (int) Mage::getStoreConfig('marketplace/product/addproductdisabledemailnotificationtemplate');
                    }
                    $adminEmailId = Mage::getStoreConfig('marketplace/marketplace/admin_email_id');
                    $toMailId = Mage::getStoreConfig("trans_email/ident_$adminEmailId/email");
                    $toName = Mage::getStoreConfig("trans_email/ident_$adminEmailId/name");
                    /**
                     *  Selecting template id
                     */
                    if ($templateId) {
                        $emailTemplate = Mage::getModel('core/email_template')->load($templateId);
                    } else {
                        if ($productStatus == 1) {

                            $emailTemplate = Mage::getModel('core/email_template')
                                    ->loadDefault('marketplace_product_addproductenabledemailnotificationtemplate');
                        } else {

                            $emailTemplate = Mage::getModel('core/email_template')
                                    ->loadDefault('marketplace_product_addproductdisabledemailnotificationtemplate');
                        }
                    }
                    $customer = Mage::getModel('customer/customer')->load($sellerId);
                    $selleremail = $customer->getEmail();
                    $recipient = $selleremail;
                    $sellername = $customer->getName();
                    $productname = $product->getName();
                    $producturl = $product->getProductUrl();
                    $emailTemplate->setSenderName($toName);
                    $emailTemplate->setSenderEmail($toMailId);
                    $emailTemplateVariables = (array('ownername' => $toName, 'sellername' => $sellername, 'adminemailid' => $toMailId, 'productname' => $productname, 'producturl' => $producturl, 'storename' => $storeName));
                    $emailTemplate->setDesignConfig(array('area' => 'frontend'));
                    $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
                    $emailTemplate->send($recipient, $toName, $emailTemplateVariables);
                }
            }
        }
    }

    /**
     * If multiple product are selected to edit(enable/disable) from admin panel this event function will be called to 
     * send email notification to seller  
     * 
     * Product information will be get from the $observer parameter
     * @param array $observer
     * 
     * @return void
     */
    public function productMassEditAction($observer) {
        /**
         *  Checking whether email notification enabled or not
         */
        if (Mage::getStoreConfig('marketplace/product/productmodificationnotification')) {
            $product = $productIds = $attributesData = array();
            $storeName = 'All Store Views';
            $storeName = 0;
            $attributesData = $observer->getAttributesData();
            $status = $attributesData['status'];
            $productIds = $observer->getProductIds();
            $store = $observer->getStoreId();
            if ($store != 0) {
                $storeName = Mage::getModel('core/store')->load($store);
            } else {
                $storeName = 'All Store Views';
            }
            foreach ($productIds as $productId) {
                $marketplaceGroupId = $prdouctGroupId = $sellerId = $productStatus = '';
                $marketplaceGroupId = Mage::helper('marketplace')->getGroupId();
                $product = Mage::helper('marketplace/marketplace')->getProductInfo($productId);
                $prdouctGroupId = $product->getGroupId();
                $sellerId = $product->getSellerId();
                $productStatus = $product->getStatus();
                if ($productStatus != $status && $prdouctGroupId == $marketplaceGroupId) {
                    if ($status == 1) {
                        $templateId = (int) Mage::getStoreConfig('marketplace/product/addproductenabledemailnotificationtemplate');
                    } else {
                        $templateId = (int) Mage::getStoreConfig('marketplace/product/addproductdisabledemailnotificationtemplate');
                    }
                    $adminEmailId = Mage::getStoreConfig('marketplace/marketplace/admin_email_id');
                    $toMailId = Mage::getStoreConfig("trans_email/ident_$adminEmailId/email");
                    $toName = Mage::getStoreConfig("trans_email/ident_$adminEmailId/name");
                    /**
                     *  Selecting template id
                     */
                    if ($templateId) {
                        $emailTemplate = Mage::helper('marketplace/marketplace')->loadEmailTemplate($templateId);
                    } else {
                        if ($status == 1) {
                            $emailTemplate = Mage::getModel('core/email_template')
                                    ->loadDefault('marketplace_product_addproductenabledemailnotificationtemplate');
                        } else {
                            $emailTemplate = Mage::getModel('core/email_template')
                                    ->loadDefault('marketplace_product_addproductdisabledemailnotificationtemplate');
                        }
                    }
                    $customer = Mage::helper('marketplace/marketplace')->loadCustomerData($sellerId);
                    $selleremail = $customer->getEmail();
                    $recipient = $selleremail;
                    $sellername = $customer->getName();
                    $productname = $product->getName();
                    $producturl = $product->getProductUrl();
                    $emailTemplate->setSenderName($toName);
                    $emailTemplate->setSenderEmail($toMailId);
                    $emailTemplateVariables = (array('ownername' => $toName, 'sellername' => $sellername, 'adminemailid' => $toMailId, 'productname' => $productname, 'producturl' => $producturl, 'storename' => $storeName));
                    $emailTemplate->setDesignConfig(array('area' => 'frontend'));
                    $emailTemplate->getProcessedTemplate($emailTemplateVariables);
                    $emailTemplate->send($recipient, $toName, $emailTemplateVariables);
                }
            }
        }
    }

    /**
     * Send Order Email to seller
     * 
     * Passed the order information to send with email
     * @param array $orderEmailData
     * 
     * @return void
     */
    public function sendOrderEmail($orderEmailData) { 
    	  	
        $sellerIds = array();
        /**
         * For Language translation assigned the table heading in varibles
         */
        $displayProductName = Mage::helper('marketplace')->__('Product Name');
        $displayProductQty = Mage::helper('marketplace')->__('Product QTY');
        $displayProductAmt = Mage::helper('marketplace')->__('Product Amount');
        $displayProductCommission = Mage::helper('marketplace')->__('Commission Fee');
        $displaySellerAmount = Mage::helper('marketplace')->__('Seller Amount');
        foreach ($orderEmailData as $data) {
	        if (!in_array($data['seller_id'], $sellerIds)) {
	            $sellerIds[] = $data['seller_id'];
	        }
        }
        foreach ($sellerIds as $key => $id) {
            $totalProductAmt = $totalCommissionFee = $totalSellerAmt = 0;
            $productDetails = '<table cellspacing="0" cellpadding="0" border="0" width="650" style="border:1px solid #eaeaea">';
            $productDetails .='<thead><tr>';
            $productDetails .='<th align="left" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductName . '</th>';
            $productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductQty . '</th>';
            $productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductAmt . '</th>';
            $productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductCommission . '</th>';
            $productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displaySellerAmount . '</th>';
            $productDetails .='</tr></thead>';
            $productDetails .='<tbody bgcolor="#F6F6F6">';
            $currencySymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
            foreach ($orderEmailData as $data) {
                if ($id == $data['seller_id']) {
                    $sellerId = $data['seller_id'];
                    $productId = $data['product_id'];
                    $product = Mage::helper('marketplace/marketplace')->getProductInfo($productId);
                    /**
                     *  Getting group id
                     */
                    $groupId = Mage::helper('marketplace')->getGroupId();
                    $productGroupId = $product->getGroupId();
                    $productName = $product->getName();
                    $productDetails .= '<tr>';
                    $productDetails .= '<td align="left" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $productName . '</td>';
                    $productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . round($data['product_qty']) . '</td>';
                    $productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . round($data['product_amt'],2) . '</td>';
                    $productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . round($data['commission_fee'],2) . '</td>';
                    $productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . round($data['seller_amount'],2) . '</td>';
                    $totalProductAmt = $totalProductAmt + $data['product_amt'];
                    $totalCommissionFee = $totalCommissionFee + $data['commission_fee'];
                    $totalSellerAmt = $totalSellerAmt + $data['seller_amount'];
                    $incrementId = $data['increment_id'];
                    $customerEmail = $data['customer_email'];
                    $customerFirstname = $data['customer_firstname'];
                    $productDetails .= '</tr>';
                }
            }
            $productDetails .= '</tbody>';
            $productDetails .= '<tfoot>
                                 <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px">Commision Fee</td>
                                    <td align="center" style="padding:3px 9px"><span>' . $currencySymbol . round($totalCommissionFee,2) . '</span></td>
                                </tr>
                                 <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px">Seller Amount</td>
                                    <td align="center" style="padding:3px 9px"><span>' . $currencySymbol . round($totalSellerAmt,2) . '</span></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px"><strong>Total Product Amount</strong></td>
                                    <td align="center" style="padding:3px 9px"><strong><span>' . $currencySymbol . round($totalProductAmt,2) . '</span></strong></td>
                                </tr>
                            </tfoot>';
            $productDetails .= '</table>';
         
            if ($groupId == $productGroupId) {
                /**
                 *  Sending order email 
                 */
                $templateId = (int) Mage::getStoreConfig('marketplace/admin_approval_seller_registration/sales_notification_template_selection');
                $adminEmailId = Mage::getStoreConfig('marketplace/marketplace/admin_email_id');
                $toMailId = Mage::getStoreConfig("trans_email/ident_$adminEmailId/email");
                $toName = Mage::getStoreConfig("trans_email/ident_$adminEmailId/name");

                if ($templateId) {
                    $emailTemplate = Mage::helper('marketplace/marketplace')->loadEmailTemplate($templateId);
                } else {
                    $emailTemplate = Mage::getModel('core/email_template')
                            ->loadDefault('marketplace_admin_approval_seller_registration_sales_notification_template_selection');
                }
                $customer = Mage::helper('marketplace/marketplace')->loadCustomerData($sellerId);
                $sellerEmail = $customer->getEmail();
                $sellerName = $customer->getName();
                $recipient = $toMailId;
                $sellerStore = Mage::app()->getStore()->getName();
                $recipientSeller = $sellerEmail;
                $emailTemplate->setSenderName($customerFirstname);
                $emailTemplate->setSenderEmail($customerEmail);
                $emailTemplateVariables = (array('ownername' => $toName, 'productdetails' => $productDetails, 'order_id' => $incrementId, 'seller_store' => $sellerStore, 'customer_email' => $customerEmail, 'customer_firstname' => $customerFirstname));
                $emailTemplate->setDesignConfig(array('area' => 'frontend'));
                /**
                 *  Sending email to admin              
                 */
                $emailTemplate->getProcessedTemplate($emailTemplateVariables);
                $emailTemplate->send($recipient, $toName, $emailTemplateVariables);
                /**
                 *  Sending email to seller
                 */
                $emailTemplateVariables = (array('ownername' => $sellerName, 'productdetails' => $productDetails, 'order_id' => $incrementId, 'seller_store' => $sellerStore, 'customer_email' => $customerEmail, 'customer_firstname' => $customerFirstname));
                $emailTemplate->send($recipientSeller, $sellerName, $emailTemplateVariables);
            }
        }
    }

    /**
     * Setting Cron job to enable/disable vacation mode by seller
     * 
     * @return void
     */
    public function eventVacationMode() {
        $currentDate = date("Y-m-d", Mage::getModel('core/date')->timestamp(time()));
        $vacationInfo = Mage::getModel('marketplace/vacationmode')->getCollection()->addFieldToSelect('*');
        foreach ($vacationInfo as $_vacationInfo) {
            $fromDate = $_vacationInfo['date_from'];
            $toDate = $_vacationInfo['date_to'];
            $sellerId = $_vacationInfo['seller_id'];
            $productStatus = $_vacationInfo['product_disabled'];
            $product = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter('seller_id', $sellerId);
            $productId = array();
            foreach ($product as $_product) {
                $productId[] = $_product->getId();
            }
            if ($currentDate >= $fromDate && $currentDate <= $toDate && $productStatus == 0) {
                foreach ($productId as $_productId) {
                    Mage::getModel('catalog/product')->load($_productId)->setStatus(2)->save();
                }
            }
            if ($currentDate <= $fromDate && $currentDate >= $toDate) {
                foreach ($productId as $_productId) {
                    Mage::getModel('catalog/product')->load($_productId)->setStatus(1)->save();
                }
            }
        }
    }

    /**
     * Email notification will be sent to seller after admin cancel a order
     * 
     * @return void
     */
    public function cancelOrderEmail($observer) {    	
       $orderIds = $observer->getEvent()->getOrder()->getId();     
       $order = Mage::getModel('sales/order')->load($orderIds);
        /**
         * get Product inforation to send that details in email
         */
       $itemCount = 0;
        $items = $order->getAllItems();    
        $orderEmailData = array();
        foreach ($items as $item) {
            $getProductId = $item->getProductId();
            $products = Mage::helper('marketplace/marketplace')->getProductInfo($getProductId);
            $sellerShippingEnabled = Mage::getStoreConfig('carriers/apptha/active');
            if($sellerShippingEnabled == 1){
            	$nationalShippingPrice = $products->getNationalShippingPrice();
            	$internationalShippingPrice = $products->getInternationalShippingPrice();
            	$sellerDefaultCountry = $products->getDefaultCountry();
            	$shippingCountryId = $order->getShippingAddress()->getCountry();
            }
            $sellerId = $products->getSellerId();
            if ($sellerId) {
                $orderPrice = $item->getPrice() * $item->getQtyOrdered();
                $productAmt = $item->getPrice();
                $productQty = $item->getQtyOrdered();
            if($sellerDefaultCountry == $shippingCountryId){
                    	$shippingPrice = $orderPrice + ($nationalShippingPrice * $productQty);
                    } else {
                    	$shippingPrice = $orderPrice + ($internationalShippingPrice* $productQty);
                    }
                /**
                 * Get seller commission percent              
                 */
                $sellerCollection = Mage::helper('marketplace/marketplace')->getSellerCollection($sellerId);
                $percentperproduct = $sellerCollection['commission'];
                $commissionFee = $orderPrice * ($percentperproduct / 100);
               $sellerAmount = $shippingPrice - $commissionFee;

                $orderEmailData[$itemCount]['seller_id'] = $sellerId;
                $orderEmailData[$itemCount]['product_id'] = $getProductId;
                $orderEmailData[$itemCount]['product_qty'] = round($productQty);
                $orderEmailData[$itemCount]['product_amt'] = number_format($productAmt,2);
                $orderEmailData[$itemCount]['commission_fee'] = $commissionFee;
                $orderEmailData[$itemCount]['seller_amount'] = $sellerAmount;
                $orderEmailData[$itemCount]['increment_id'] = $order->getIncrementId();
                $orderEmailData[$itemCount]['customer_email'] = $order->getCustomerEmail();
                $orderEmailData[$itemCount]['customer_firstname'] = $order->getCustomerFirstname();
                $itemCount = $itemCount + 1;
            }
        }
        if (Mage::getStoreConfig('marketplace/admin_approval_seller_registration/cancel_order_notification') == 1) {
            $this->sendCancelOrderEmail($orderEmailData);
        }
    }

    /**
     * Send Cancel Order Email to seller
     * 
     * Order information will be get from the $observer parameter
     * @param array $observer
     * 
     * @return void
     */
    public function sendCancelOrderEmail($orderEmailData) {		
        $sellerIds = array();
        /**
         * For Language translation assigned the table heading in varibles
         */
        $displayProductName = Mage::helper('marketplace')->__('Product Name');
        $displayProductQty = Mage::helper('marketplace')->__('Product QTY');
        $displayProductAmt = Mage::helper('marketplace')->__('Product Amount');
        $displayProductCommission = Mage::helper('marketplace')->__('Commission Fee');
        $displaySellerAmount = Mage::helper('marketplace')->__('Seller Amount');
        foreach ($orderEmailData as $data) {
            if (!in_array($data['seller_id'], $sellerIds)) {
                $sellerIds[] = $data['seller_id'];
            }
        }
        foreach ($sellerIds as $key => $id) {
            $totalProductAmt = $totalCommissionFee = $totalSellerAmt = 0;
            $productDetails = '<table cellspacing="0" cellpadding="0" border="0" width="650" style="border:1px solid #eaeaea">';
            $productDetails .='<thead><tr>';
            $productDetails .='<th align="left" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductName . '</th>';
            $productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductQty . '</th>';
            $productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductAmt . '</th>';
            $productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductCommission . '</th>';
            $productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displaySellerAmount . '</th>';
            $productDetails .='</tr></thead>';
            $productDetails .='<tbody bgcolor="#F6F6F6">';
            $currencySymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
            foreach ($orderEmailData as $data) {
            	
                if ($id == $data['seller_id']) {
                    $sellerId = $data['seller_id'];
                    $productId = $data['product_id'];
                    $product = Mage::helper('marketplace/marketplace')->getProductInfo($productId);
                    /**
                     *  Getting group id
                     */
                    $groupId = Mage::helper('marketplace')->getGroupId();
                    $productGroupId = $product->getGroupId();
                    $productName = $product->getName();
                    $productDetails .= '<tr>';
                    $productDetails .= '<td align="left" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $productName . '</td>';
                    $productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $data['product_qty'] . '</td>';
                    $productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . $data['product_amt'] . '</td>';
                    $productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . $data['commission_fee'] . '</td>';
                    $productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . $data['seller_amount'] . '</td>';
                    $totalProductAmt = $totalProductAmt + $data['product_amt'];
                    $totalCommissionFee = $totalCommissionFee + $data['commission_fee'];
                    $totalSellerAmt = $totalSellerAmt + $data['seller_amount'];
                    $incrementId = $data['increment_id'];
                    $customerEmail = $data['customer_email'];
                    $customerFirstname = $data['customer_firstname'];
                    $productDetails .= '</tr>';
                }
            }
            $productDetails .= '</tbody>';
            $productDetails .= '<tfoot>
                                 <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px">Commision Fee</td>
                                    <td align="center" style="padding:3px 9px"><span>' . $currencySymbol . $totalCommissionFee . '</span></td>
                                </tr>
                                 <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px">Seller Amount</td>
                                    <td align="center" style="padding:3px 9px"><span>' . $currencySymbol . $totalSellerAmt . '</span></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px"><strong>Total Product Amount</strong></td>
                                    <td align="center" style="padding:3px 9px"><strong><span>' . $currencySymbol . $totalProductAmt . '</span></strong></td>
                                </tr>
                            </tfoot>';
            $productDetails .= '</table>';  
                 
            if ($groupId == $productGroupId) {
            
                /**
                 *  Sending order email 
                 */
                $templateId = (int) Mage::getStoreConfig('marketplace/admin_approval_seller_registration/cancel_notification_template_selection');
                $adminEmailId = Mage::getStoreConfig('marketplace/marketplace/admin_email_id');
                $toMailId = Mage::getStoreConfig("trans_email/ident_$adminEmailId/email");
                $toName = Mage::getStoreConfig("trans_email/ident_$adminEmailId/name");
                if ($templateId) {
                    $emailTemplate = Mage::helper('marketplace/marketplace')->loadEmailTemplate($templateId);
                } else {
                    $emailTemplate = Mage::getModel('core/email_template')
                            ->loadDefault('marketplace_admin_approval_seller_registration_cancel_notification_template_selection');
                }
                /**
                 * Loading customer data to send in email
                 */
                $customer = Mage::helper('marketplace/marketplace')->loadCustomerData($sellerId);
                $sellerEmail = $customer->getEmail();
                $sellerName = $customer->getName();
                $recipient = $toMailId;
                $sellerStore = Mage::app()->getStore()->getName();
                $recipientSeller = $sellerEmail;
                $emailTemplate->setSenderName($toName);
                $emailTemplate->setSenderEmail($toMailId);
                $emailTemplateVariables = (array('ownername' => $toName, 'productdetails' => $productDetails, 'order_id' => $incrementId, 'seller_store' => $sellerStore, 'customer_email' => $customerEmail, 'customer_firstname' => $customerFirstname));
                $emailTemplate->setDesignConfig(array('area' => 'frontend'));
                /**
                 *  Sending email to admin              
                 */
                $emailTemplate->getProcessedTemplate($emailTemplateVariables);                
                $emailTemplate->send($recipient, $toName, $emailTemplateVariables);
                
                /**
                 *  Sending email to seller
                 */
                $emailTemplateVariables = (array('ownername' => $sellerName, 'productdetails' => $productDetails, 'order_id' => $incrementId, 'seller_store' => $sellerStore, 'customer_email' => $customerEmail, 'customer_firstname' => $customerFirstname));
                $emailTemplate->send($recipientSeller, $sellerName, $emailTemplateVariables);
            }
        }
    }
    
    /**
     * Change status to disable for deleted seller products.
     * @param object $observer
     */
    public function customerdelete($observer) {
    	$customer = $observer->getCustomer();
    	$productCollections = Mage::getModel('catalog/product')->getCollection()
    	->addAttributeToFilter('seller_id',$customer->getId());    
    	foreach($productCollections as $product){
    		$productId = $product->getEntityId();
    		$model = Mage::getModel('catalog/product')->load($productId);
    		$model->delete();
    	}
    }
    
    /**
     * Restrict seller product to buy themself
     * @param object $observer
     */
    public function addToCartEvent($observer) {
    	
    	if($observer->getEvent()->getControllerAction()->getFullActionName() == 'checkout_cart_add')
    	{
    	$request = Mage::app()->getRequest()->getParam('product', 0);
    	
    	$customerId = '';
    	if(Mage::getSingleton('customer/session')->isLoggedIn()) {
    	$customerData = Mage::getSingleton('customer/session')->getCustomer();
        $customerId = $customerData->getId();
    	}
    	
    	$product = Mage::getModel('catalog/product')
    	->load(Mage::app()->getRequest()->getParam('product', 0));
    	if (!$product->getId() || empty($customerId)) {
    		return;
    	}    	
        $sellerId = $product->getSellerId();
        if($sellerId == $customerId){
        $productUrl = $product->getProductUrl();        
        
        $msg = Mage::helper('marketplace')->__("Seller can't buy their own product.");
        Mage::getSingleton('core/session')->addError($msg);
        
        Mage::app()->getFrontController()->getResponse()->setRedirect($productUrl);
        Mage::app()->getResponse()->sendResponse(); 
        
        $controller = $observer->getControllerAction();
        $controller->getRequest()->setDispatched(true);
        $controller->setFlag(
        		'',
        		Mage_Core_Controller_Front_Action::FLAG_NO_DISPATCH,
        		true
        );
        }    	
    	}
    	return $this;    
    }
    
    /**
     * Send invoice mail to seller
     * @param object $observer
     */
    public function sendInvoiceMailToSeller($observer) {
    	
    	if (Mage::getStoreConfig('marketplace/admin_approval_seller_registration/invoiced_order_notification') == 1) {
    	
    	$event = $observer->getEvent();
    	$invoice = $event->getInvoice();
    	$orderData = $invoice->getOrder();    	
    	$orderIds = $orderData->getId();
    	$order = Mage::getModel('sales/order')->load($orderIds);
    	/**
    	 * Get Product inforation to send that details in email
    	*/
    	$itemCount = 0;
    	$items = $order->getAllItems();
    	$orderEmailData = array();
    	foreach ($items as $item) {
    		$getProductId = $item->getProductId();
    		$products = Mage::helper('marketplace/marketplace')->getProductInfo($getProductId);
    		$productType = $products->getTypeID();
    		$sellerShippingEnabled = Mage::getStoreConfig('carriers/apptha/active');
    		if($sellerShippingEnabled == 1 && $productType == 'simple'){
    			$nationalShippingPrice = $products->getNationalShippingPrice();
    			$internationalShippingPrice = $products->getInternationalShippingPrice();
    			$sellerDefaultCountry = $products->getDefaultCountry();
    			$shippingCountryId = $order->getShippingAddress()->getCountry();
    		}
    		$sellerId = $products->getSellerId();
    		if ($sellerId) {
    			$orderPrice = $item->getPrice() * $item->getQtyOrdered();
    			$productAmt = $item->getPrice();
    			$productQty = $item->getQtyOrdered();
    			if($sellerDefaultCountry == $shippingCountryId){
    				$shippingPrice = $orderPrice + ($nationalShippingPrice * $productQty);
    			} else {
    				$shippingPrice = $orderPrice + ($internationalShippingPrice* $productQty);
    			}
    			/**
    			 * Get seller commission percent
    			 */
    			$sellerCollection = Mage::helper('marketplace/marketplace')->getSellerCollection($sellerId);
    			$percentperproduct = $sellerCollection['commission'];
    			$commissionFee = $orderPrice * ($percentperproduct / 100);
    			$sellerAmount = $shippingPrice - $commissionFee;
    	
    			$orderEmailData[$itemCount]['seller_id'] = $sellerId;
    			$orderEmailData[$itemCount]['product_id'] = $getProductId;
    			$orderEmailData[$itemCount]['product_qty'] = $productQty;
    			$orderEmailData[$itemCount]['product_amt'] = $productAmt;
    			$orderEmailData[$itemCount]['commission_fee'] = $commissionFee;
    			$orderEmailData[$itemCount]['seller_amount'] = $sellerAmount;
    			$orderEmailData[$itemCount]['increment_id'] = $order->getIncrementId();
    			$orderEmailData[$itemCount]['customer_email'] = $order->getCustomerEmail();
    			$orderEmailData[$itemCount]['customer_firstname'] = $order->getCustomerFirstname();
    			$itemCount = $itemCount + 1;
    		}
    	}
    	$this->sendInvoicedOrderEmail($orderEmailData);
    	}    	
    }  

    /**
     * Send Order Invoiced Email to seller
     *
     * Order information will be get from the $observer parameter
     * @param array $observer
     *
     * @return void
     */
    public function sendInvoicedOrderEmail($orderEmailData) {
    	$sellerIds = array();
    	/**
    	 * For Language translation assigned the table heading in varibles
    	*/
    	$displayProductName = Mage::helper('marketplace')->__('Product Name');
    	$displayProductQty = Mage::helper('marketplace')->__('Product QTY');
    	$displayProductAmt = Mage::helper('marketplace')->__('Product Amount');
    	$displayProductCommission = Mage::helper('marketplace')->__('Commission Fee');
    	$displaySellerAmount = Mage::helper('marketplace')->__('Seller Amount');
    	foreach ($orderEmailData as $data) {
    		if (!in_array($data['seller_id'], $sellerIds)) {
    			$sellerIds[] = $data['seller_id'];
    		}
    	}
    	foreach ($sellerIds as $key => $id) {
    		$totalProductAmt = $totalCommissionFee = $totalSellerAmt = 0;
    		$productDetails = '<table cellspacing="0" cellpadding="0" border="0" width="650" style="border:1px solid #eaeaea">';
    		$productDetails .='<thead><tr>';
    		$productDetails .='<th align="left" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductName . '</th>';
    		$productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductQty . '</th>';
    		$productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductAmt . '</th>';
    		$productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displayProductCommission . '</th>';
    		$productDetails .='<th align="center" bgcolor="#EAEAEA" style="font-size:13px;padding:3px 9px;">' . $displaySellerAmount . '</th>';
    		$productDetails .='</tr></thead>';
    		$productDetails .='<tbody bgcolor="#F6F6F6">';
    		$currencySymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
    		foreach ($orderEmailData as $data) {
    			 
    			if ($id == $data['seller_id']) {
    				$sellerId = $data['seller_id'];
    				$productId = $data['product_id'];
    				$product = Mage::helper('marketplace/marketplace')->getProductInfo($productId);
    				/**
    				 *  Getting group id
    				*/
    				$groupId = Mage::helper('marketplace')->getGroupId();
    				$productGroupId = $product->getGroupId();
    				$productName = $product->getName();
    				$productDetails .= '<tr>';
    				$productDetails .= '<td align="left" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $productName . '</td>';
    				$productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . round($data['product_qty']) . '</td>';
    				$productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . number_format($data['product_amt'],2) . '</td>';
    				$productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . $data['commission_fee'] . '</td>';
    				$productDetails .= '<td align="center" valign="top" style="font-size:11px;padding:3px 9px;border-bottom:1px dotted #cccccc;">' . $currencySymbol . $data['seller_amount'] . '</td>';
    				$totalProductAmt = $totalProductAmt + $data['product_amt'];
    				$totalCommissionFee = $totalCommissionFee + $data['commission_fee'];
    				$totalSellerAmt = $totalSellerAmt + $data['seller_amount'];
    				$incrementId = $data['increment_id'];
    				$customerEmail = $data['customer_email'];
    				$customerFirstname = $data['customer_firstname'];
    				$productDetails .= '</tr>';
    			}
    		}
    		$productDetails .= '</tbody>';
    		$productDetails .= '<tfoot>
                                 <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px">Commision Fee</td>
                                    <td align="center" style="padding:3px 9px"><span>' . $currencySymbol . $totalCommissionFee . '</span></td>
                                </tr>
                                 <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px">Seller Amount</td>
                                    <td align="center" style="padding:3px 9px"><span>' . $currencySymbol . $totalSellerAmt . '</span></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right" style="padding:3px 9px"><strong>Total Product Amount</strong></td>
                                    <td align="center" style="padding:3px 9px"><strong><span>' . $currencySymbol . $totalProductAmt . '</span></strong></td>
                                </tr>
                            </tfoot>';
    		$productDetails .= '</table>';    		
    		 
    		if ($groupId == $productGroupId) {
    
    			/**
    			 *  Sending order email
    			 */
    			$templateId = (int) Mage::getStoreConfig('marketplace/admin_approval_seller_registration/invoiced_notification_template_selection');
    			$adminEmailId = Mage::getStoreConfig('marketplace/marketplace/admin_email_id');
    			$toMailId = Mage::getStoreConfig("trans_email/ident_$adminEmailId/email");
    			$toName = Mage::getStoreConfig("trans_email/ident_$adminEmailId/name");
    			if ($templateId) {
    				$emailTemplate = Mage::helper('marketplace/marketplace')->loadEmailTemplate($templateId);
    			} else {
    				$emailTemplate = Mage::getModel('core/email_template')
    				->loadDefault('marketplace_admin_approval_seller_registration_invoiced_notification_template_selection');
    			}
    			/**
    			 * Loading customer data to send in email
    			 */
    			$customer = Mage::helper('marketplace/marketplace')->loadCustomerData($sellerId);
    			$sellerEmail = $customer->getEmail();
    			$sellerName = $customer->getName();
    			$recipient = $toMailId;
    			$sellerStore = Mage::app()->getStore()->getName();
    			$recipientSeller = $sellerEmail;
    			$emailTemplate->setSenderName($toName);
    			$emailTemplate->setSenderEmail($toMailId);
    			$emailTemplateVariables = (array('ownername' => $toName, 'productdetails' => $productDetails, 'order_id' => $incrementId, 'seller_store' => $sellerStore, 'customer_email' => $customerEmail, 'customer_firstname' => $customerFirstname));
    			$emailTemplate->setDesignConfig(array('area' => 'frontend'));
    			/**
    			 *  Sending email to admin
    			*/
    			$emailTemplate->getProcessedTemplate($emailTemplateVariables);
    			$emailTemplate->send($recipient, $toName, $emailTemplateVariables);
    
    			/**
    			 *  Sending email to seller
    			*/
    			$emailTemplateVariables = (array('ownername' => $sellerName, 'productdetails' => $productDetails, 'order_id' => $incrementId, 'seller_store' => $sellerStore, 'customer_email' => $customerEmail, 'customer_firstname' => $customerFirstname));
    			$emailTemplate->send($recipientSeller, $sellerName, $emailTemplateVariables);
    		}
    	}
    }
    
}

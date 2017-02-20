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
 * Seller shipping calculation for per item basis in cart 
 */
class Apptha_Merchantshipping_Model_Carrier_Shipping extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {
    /**
     * Assigned the $_code as protected with value as 'apptha'
     */
    protected $_code = 'apptha';
    /**
     * Function to calculate the shipping per item in cart
     * 
     * Core function shipping request data
     * @param int Mage_Shipping_Model_Rate_Request $request
     * 
     * This function will return the calculated shipping rate 
     * @return int
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request) {
        if (!Mage::getStoreConfig('carriers/' . $this->_code . '/active')) {
            return false;
        }       
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $total = $totalshipamount = '';
        foreach ($quote->getAllItems() as $quote_item) {
            if ($quote_item->getProduct()->isVirtual() || $quote_item->getParentItem()) {
                continue;
            }
            if ($quote_item->getHasChildren() && $quote_item->isShipSeparately()) {
                foreach ($quote_item->getChildren() as $child) {
                    if ($child->getFreeShipping() && !$child->getProduct()->isVirtual()) {
                        $product = Mage::getModel('catalog/product')->load($quote_item->getProductId());
                        $sellerShippingOption = $product->getSellerShippingOption();
                        $nationalShippingPrice = $product->getNationalShippingPrice();
                        $internationalShippingPrice = $product->getInternationalShippingPrice();
                        $sellerDefaultCountry = $product->getDefaultCountry();
                        $shippingCountryId = $quote->getShippingAddress()->getCountry();
                        $subtotal = $quote->getSubtotal();
                        $qty = $quote_item->getQty();
                        if ($nationalShippingPrice != '' && $internationalShippingPrice != '' && $shippingCountryId != '' && $sellerDefaultCountry == $shippingCountryId) {
                            $total = $nationalShippingPrice * $qty;
                        } else {
                            $total = $internationalShippingPrice * $qty;
                        }
                        $totalshipamount = $totalshipamount + $total;
                    }
                }
            } else {
                $product = Mage::getModel('catalog/product')->load($quote_item->getProductId());
                $sellerShippingOption = $product->getSellerShippingOption();
                $nationalShippingPrice = $product->getNationalShippingPrice();
                $internationalShippingPrice = $product->getInternationalShippingPrice();
                $sellerDefaultCountry = $product->getDefaultCountry();
                $shippingCountryId = $quote->getShippingAddress()->getCountry();
                $subtotal = $quote->getSubtotal();
                $qty = $quote_item->getQty();
                if ($nationalShippingPrice != '' && $internationalShippingPrice != '' && $shippingCountryId != '' && $sellerDefaultCountry == $shippingCountryId) {
                    $total = $nationalShippingPrice * $qty;
                } else {
                    $total = $internationalShippingPrice * $qty;
                }
                $totalshipamount = $totalshipamount + $total;
            }
        }        
        $result = Mage::getModel('shipping/rate_result');
        $show = true;
        if ($show) {
            $method = Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_code);
            $method->setMethod($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethodTitle($this->getConfigData('name'));
            $method->setPrice($totalshipamount);
            $method->setCost($totalshipamount);
            $result->append($method);
        } else {
            $error = Mage::getModel('shipping/rate_result_error');
            $error->setCarrier($this->_code);
            $error->setCarrierTitle($this->getConfigData('name'));
            $error->setErrorMessage($this->getConfigData('specificerrmsg'));
            $result->append($error);
        }
        return $result;
    }
    /**
     * Function to get the allowed shipping method data     
     * 
     * This function will return shipping method data
     * @return array
     */
    public function getAllowedMethods() {
        return array('apptha' => $this->getConfigData('name'));
    }

}
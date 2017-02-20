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
 * Registration page functionality
 */
class Apptha_Marketplace_Block_Form_Register extends Mage_Core_Block_Template {

    protected $_address;

    /**
     * Used to set page title
     * 
     * Return page title
     * @return varchar
     */
    protected function _prepareLayout() {
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('marketplace')->__('Create New Seller Account'));
        return parent::_prepareLayout();
    }

    /**
     * Function to get registration form data post url
     * 
     * Return the registration data post url
     * @return string
     */
    public function getPostActionUrl() {
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        $secure = strstr($currentUrl, "https");
        if ($secure == true) {
            return $this->getUrl('*/*/createpost', array('_secure' => true));
        } else {
            return $this->getUrl('*/*/createpost');
        }
    }

    /**
     * Retrieve back url(product url)
     *
     * Return the product url
     * @return string
     */
    public function getBackUrl() {
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        $secure = strstr($currentUrl, "https");
        if ($secure == true) {
            return $this->getUrl('marketplace/seller/login', array('_secure' => true));
        } else {
            return $this->getUrl('marketplace/seller/login');
        }
    }

    /**
     * Retrieve form data
     *
     * Return form post data
     * @return Varien_Object
     */
    public function getFormData() {
        $data = $this->getData('form_data');
        if (is_null($data)) {
            $formData = Mage::getSingleton('customer/session')->getCustomerFormData(true);
            $data = new Varien_Object();
            if ($formData) {
                $data->addData($formData);
                $data->setCustomerData(1);
            }
            if (isset($data['region_id'])) {
                $data['region_id'] = (int) $data['region_id'];
            }
            $this->setData('form_data', $data);
        }
        return $data;
    }

    /**
     * Retrieve customer country identifier
     *
     * Returnt the customer country id
     * @return int
     */
    public function getCountryId() {
        $countryId = $this->getFormData()->getCountryId();
        if ($countryId) {
            return $countryId;
        }
        return parent::getCountryId();
    }

    /**
     * Retrieve customer region identifier
     *
     * Return the customer region id
     * @return int
     */
    public function getRegion() {
        if (false !== ($region = $this->getFormData()->getRegion())) {
            return $region;
        } else if (false !== ($region = $this->getFormData()->getRegionId())) {
            return $region;
        }
        return null;
    }

    /**
     *  Newsletter module availability
     *
     * Return boolen value for newletter enabled or not
     *  @return boolean
     */
    public function isNewsletterEnabled() {
        return Mage::helper('core')->isModuleOutputEnabled('Mage_Newsletter');
    }

    /**
     * To get the customer address 
     * 
     * Return customer address instance
     * @return Mage_Customer_Model_Address
     */
    public function getAddress() {
        if (is_null($this->_address)) {
            $this->_address = Mage::getModel('customer/address');
        }

        return $this->_address;
    }

    /**
     * Restore entity data from session
     * Entity and form code must be defined for the form
     *
     * @param Mage_Customer_Model_Form $form
     * @return Mage_Customer_Block_Form_Register
     */
    public function restoreSessionData(Mage_Customer_Model_Form $form, $scope = null) {
        if ($this->getFormData()->getCustomerData()) {
            $request = $form->prepareRequest($this->getFormData()->getData());
            $data = $form->extractData($request, $scope, false);
            $form->restoreData($data);
        }
        return $this;
    }

}
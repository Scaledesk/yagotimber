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
 * This file contains seller login/ registration, seller profile page functionality
 */
class Apptha_Marketplace_SellerController extends Mage_Core_Controller_Front_Action {

    /**
     * Action list where need check enabled cookie
     *
     * @var array
     */
    protected $_cookieCheckActions = array('loginPost', 'createpost');

    /**
     * Retrieve customer session model object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession() {
        return Mage::getSingleton('customer/session');
    }

    /**
     * Check whether VAT ID validation is enabled
     *
     * @param Mage_Core_Model_Store|string|int $store
     * @return bool
     */
    protected function _isVatValidationEnabled($store = null) {
        return Mage::helper('customer/address')->isVatValidationEnabled($store);
    }

    /**
     * Function to display seller login and registration page
     * 
     * Checking license key and seller logged in or not
     * @return void 
     */
    public function indexAction() {

        if (Mage::helper('marketplace')->checkMarketplaceKey() != '') {
            $msg = Mage::helper('marketplace')->checkMarketplaceKey();
            Mage::app()->getResponse()->setBody($msg);
            return;
        } else {
            if (!$this->_getSession()->isLoggedIn()) {
                Mage::getSingleton('core/session')->addError($this->__('You must have a Seller Account to access this page'));
                $this->_redirect('*/*/login');
                return;
            }
            $this->loadLayout();
            $this->renderLayout();
        }
    }

    /**
     * Function to display login page 
     * 
     * Checking license key and seller logged in or not
     * @return void
     */
    public function loginAction() {
        if (Mage::helper('marketplace')->checkMarketplaceKey() != '') {
            $msg = Mage::helper('marketplace')->checkMarketplaceKey();
            Mage::app()->getResponse()->setBody($msg);
            return;
        } else {
            if ($this->_getSession()->isLoggedIn()) {
                $this->_redirect('marketplace/seller/dashboard');
                return;
            }
            $this->loadLayout();
            $this->renderLayout();
        }
    }

    /**
     * Function to post login page data's 
     * 
     * Checking username and password for log in and redirect to seller/customer account
     * @return void
     */
    public function loginPostAction() {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('marketplace/seller/dashboard');
            return;
        }
        $session = $this->_getSession();
        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
                try {
                    $customer = Mage::getModel('customer/customer');
                    $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                            ->loadByEmail($login['username']);
                    $customerGroupid = $customer->getGroupId();
                    $groupId = Mage::helper('marketplace')->getGroupId();
                    if ($customerGroupid != $groupId) {
                        Mage::getSingleton('core/session')->addError($this->__('You must have a Seller Account to access this page'));
                        $this->_redirect('*/*/login');
                        return;
                    }
                    $customerStatus = $customer->getCustomerstatus();
                    if ($customerStatus == 2 || $customerStatus == 0) {
                        Mage::getSingleton('core/session')->addError($this->__('Admin Approval is required for Seller Account'));
                        $this->_redirect('*/*/login');
                        return;
                    }
                    $session->login($login['username'], $login['password']);
                    if ($session->getCustomer()->getIsJustConfirmed()) {
                        $this->_welcomeCustomer($session->getCustomer(), true);
                    }
                } catch (Mage_Core_Exception $e) {
                    switch ($e->getCode()) {
                        case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                            $message = $e->getMessage();
                            break;
                        default:
                            $message = $e->getMessage();
                    }
                    $session->addError($message);
                    $session->setUsername($login['username']);
                }
            } else {
                $session->addError($this->__('Login and password are must.'));
            }
        }
        $this->_redirect('marketplace/seller/dashboard');
    }

    /**
     * Function to display registration page 
     * 
     * Display seller/customer account registration form 
     * @return void
     */
    public function createAction() {
        if (Mage::helper('marketplace')->checkMarketplaceKey() != '') {
            $msg = Mage::helper('marketplace')->checkMarketplaceKey();
            Mage::app()->getResponse()->setBody($msg);
            return;
        } else {
            $this->loadLayout();
            $this->renderLayout();
        }
    }

    /**
     * Function to post the registration page data's
     * 
     * Get and validate seller/customer account registration form 
     * @return void
     */
    public function createPostAction() {
        $adminApproval = Mage::getStoreConfig('marketplace/admin_approval_seller_registration/need_approval');
        $session = $this->_getSession();
        if ($session->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $session->setEscapeMessages(true); // prevent XSS injection in user input
        if ($this->getRequest()->isPost()) {
            $errors = array();
            if (!$customer = Mage::registry('current_customer')) {
                $customer = Mage::getModel('customer/customer')->setId(null);
            }
            $groupId = Mage::helper('marketplace')->getGroupId();
            $customer->setGroupId($groupId);

            if ($adminApproval == 1) {
                $customer->setCustomerstatus('0');
            } else {
                $customer->setCustomerstatus('1');
            }
            /* @var $customerForm Mage_Customer_Model_Form */
            $customerForm = Mage::getModel('customer/form');
            $customerForm->setFormCode('customer_account_create')
                    ->setEntity($customer);
            $customerData = $customerForm->extractData($this->getRequest());
            $customer->getGroupId();
            if ($this->getRequest()->getPost('create_address')) {
                /* @var $address Mage_Customer_Model_Address */
                $address = Mage::getModel('customer/address');
                /* @var $addressForm Mage_Customer_Model_Form */
                $addressForm = Mage::getModel('customer/form');
                $addressForm->setFormCode('customer_register_address')
                        ->setEntity($address);
                $addressData = $addressForm->extractData($this->getRequest(), 'address', false);
                $addressErrors = $addressForm->validateData($addressData);
                if ($addressErrors === true) {
                    $address->setId(null)
                            ->setIsDefaultBilling($this->getRequest()->getParam('default_billing', false))
                            ->setIsDefaultShipping($this->getRequest()->getParam('default_shipping', false));
                    $addressForm->compactData($addressData);
                    $customer->addAddress($address);

                    $addressErrors = $address->validate();
                    if (is_array($addressErrors)) {
                        $errors = array_merge($errors, $addressErrors);
                    }
                } else {
                    $errors = array_merge($errors, $addressErrors);
                }
            }
            try {
                $customerErrors = $customerForm->validateData($customerData);
                if ($customerErrors !== true) {
                    $errors = array_merge($customerErrors, $errors);
                } else {
                    $customerForm->compactData($customerData);
                    $customer->setPassword($this->getRequest()->getPost('password'));
                    
                    $magentoVersion = Mage::getVersion();
                    if (version_compare($magentoVersion, '1.9.1', '>=')){
                    $customer->setPasswordConfirmation($this->getRequest()->getPost('confirmation'));
                    }
                    else {
                    $customer->setConfirmation($this->getRequest()->getPost('confirmation'));                    
                    }                    
                   
                    $customerErrors = $customer->validate();
                    if (is_array($customerErrors)) {
                        $errors = array_merge($customerErrors, $errors);
                    }
                }
                $validationResult = count($errors) == 0;
                if (true === $validationResult) {
                    $customerId = $customer->save()->getId();
					$company_name = $this->getRequest()->getParam('company_name');
						$store_type = $this->getRequest()->getParam('company_type');
						$store_address = $this->getRequest()->getParam('regadd');
						$store_address1 = $this->getRequest()->getParam('shopadd');
						$store_pan = $this->getRequest()->getParam('panno');
						$store_vat = $this->getRequest()->getParam('vatno');
						$store_tin = $this->getRequest()->getParam('tinno');
						$store_cst = $this->getRequest()->getParam('cstno');
						$store_owner = $this->getRequest()->getParam('director');
						$store_owneraddress = $this->getRequest()->getParam('directoradd');
						$store_din = $this->getRequest()->getParam('dinno');
						$store_cname = $this->getRequest()->getParam('contactp');
						$store_cpos = $this->getRequest()->getParam('desig');
						$store_cladnumber = $this->getRequest()->getParam('landline');
						$store_cmob = $this->getRequest()->getParam('mobileno');
						$store_cmail = $this->getRequest()->getParam('emailid');
						$store_bankdetails = $this->getRequest()->getParam('bankde');
						$store_bankaname = $this->getRequest()->getParam('bankadd');
						$account_name = $this->getRequest()->getParam('accname');
						$account_number = $this->getRequest()->getParam('accno');
						$store_type = $this->getRequest()->getParam('acctyp');
						$store_bankaifsc = $this->getRequest()->getParam('ifc');
						$store_bankmicr = $this->getRequest()->getParam('micr');
						$exported = $this->getRequest()->getParam('exported');
						$exp_country = $this->getRequest()->getParam('exp_country');
						$iec_code = $this->getRequest()->getParam('iec');
						
						
						
							
					  $collection_pre = Mage::getModel('marketplace/sellerprofile')->load($customerId, 'seller_id');
                $collection_pre->setSellerId($customerId);
                $collection_pre->setStoreTitle($company_name);
				 $collection_pre->setStoreType($store_type);
				  $collection_pre->setStoreAddress($store_address);
				   $collection_pre->setStoreAddress1($store_address1);
				    $collection_pre->setStorePan($store_pan);
					 $collection_pre->setStoreVat($store_vat);
					  $collection_pre->setStoreTin($store_tin);
					   $collection_pre->setStoreCst($store_cst);
					    $collection_pre->setStoreOwner($store_owner);
						 $collection_pre->setStoreOwneraddress($store_owneraddress);
						  $collection_pre->setStoreDin($store_din);
						   $collection_pre->setStoreCname($store_cname);
						    $collection_pre->setStoreCpos($store_cpos);
							 $collection_pre->setStoreCladnumber($store_cladnumber);
							  $collection_pre->setStoreCmob($store_cmob);
							  $collection_pre->setStore_cmail($store_cmail);
							  $collection_pre->setStoreBankdetails($store_bankdetails);
							     $collection_pre->setStoreBankaname($store_bankaname);
								   $collection_pre->setStoreBankatype($store_bankatype);
								     $collection_pre->setStoreBankaifsc($store_bankaifsc);
									   $collection_pre->setStoreBankdetails($store_bankdetails);
									   $collection_pre->setStoreBankmicr($store_bankmicr);
									  
				 $collection_pre->save();
				
                    if ($adminApproval == 1) {
                        Mage::getModel('marketplace/sellerprofile')->adminApproval($customerId);
                        Mage::dispatchEvent('customer_register_success', array('account_controller' => $this, 'customer' => $customer));
                        Mage::getSingleton('core/session')->addSuccess($this->__('Admin Approval is required. Please wait until admin confirms your Seller Account'));
                        $this->_redirect('*/*/login');
                        return;
                    } else {

                        Mage::getModel('marketplace/sellerprofile')->newSeller($customerId);
                        Mage::dispatchEvent('customer_register_success', array('account_controller' => $this, 'customer' => $customer)
                        );
                        $session->setCustomerAsLoggedIn($customer);
                        $session->renewSession();
                        $url = $this->_welcomeCustomer($customer);
                        $this->_redirectSuccess($url);
                    }
                } else {
                    $session->setCustomerFormData($this->getRequest()->getPost());
                    if (is_array($errors)) {
                        foreach ($errors as $errorMessage) {
                            $session->addError($errorMessage);
                        }
                    } else {
                        $session->addError($this->__('Invalid customer data'));
                    }
                }
            } catch (Mage_Core_Exception $e) {
                $session->setCustomerFormData($this->getRequest()->getPost());
                if ($e->getCode() === Mage_Customer_Model_Customer::EXCEPTION_EMAIL_EXISTS) {
                    $url = Mage::getUrl('customer/account/forgotpassword');
                    Mage::getSingleton('core/session')->addError($this->__('There is already an account with this email address. If you are sure that it is your email address, <a href="%s">click here</a> to get your password and access your account.', $url));
                    $this->_redirect('*/*/login');
                } else {
                    $message = $e->getMessage();
                }
                $session->addError($message);
            } catch (Exception $e) {
                $session->setCustomerFormData($this->getRequest()->getPost())
                        ->addException($e, $this->__('Customer details not saved.'));
            }
        }

        $this->_redirectError(Mage::getUrl('*/*/login', array('_secure' => true)));
    }

    /**
     * Function to display welcome message
     * 
     * Display welcome message for seller/ customer 
     * @return void
     */
    protected function _welcomeCustomer(Mage_Customer_Model_Customer $customer, $isJustConfirmed = false) {
        $this->_getSession()->addSuccess(
                $this->__('Thank you for registering with %s.', Mage::app()->getStore()->getFrontendName())
        );
        if ($this->_isVatValidationEnabled()) {
            /**
             * Show corresponding VAT message to customer 
             */
            $configAddressType = Mage::helper('customer/address')->getTaxCalculationAddressType();
            $userPrompt = '';
            switch ($configAddressType) {
                case Mage_Customer_Model_Address_Abstract::TYPE_SHIPPING:
                    $userPrompt = $this->__('If you are a registered VAT customer, please click <a href="%s">here</a> to enter you shipping address for proper VAT calculation', Mage::getUrl('customer/address/edit'));
                    break;
                default:
                    $userPrompt = $this->__('If you are a registered VAT customer, please click <a href="%s">here</a> to enter you billing address for proper VAT calculation', Mage::getUrl('customer/address/edit'));
            }
            $this->_getSession()->addSuccess($userPrompt);
        }
        $customer->sendNewAccountEmail(
                $isJustConfirmed ? 'confirmed' : 'registered', '', Mage::app()->getStore()->getId()
        );
        $successUrl = Mage::getUrl('*/*/index', array('_secure' => true));
        if ($this->_getSession()->getBeforeAuthUrl()) {
            $successUrl = $this->_getSession()->getBeforeAuthUrl(true);
        }
        return $successUrl;
    }

    /**
     * Function to display add profile form
     * 
     * Display Add profile form url
     * @return void
     */
    function addprofileAction() {
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
     * Function to save seller profile information
     * 
     * Save Add profile form 
     * @return void
     */
    function saveprofileAction() {
    	$removeLogo = $imagesPathBanner = $removeBanner = '';
        $data = $this->getRequest()->getPost();
        $sellerId = $storeName = $storeLogo = $description = $metaKeyword = $metaDescription = '';
        $bankPayment = $paypalId = $remove = $contact = $showProfile = '';
        $uploadsData = new Zend_File_Transfer_Adapter_Http();
        $filesDataArray = $uploadsData->getFileInfo();
        $sellerId = $data['seller_id'];
        $storeName = $data['store_name'];
        $storeLogo = $filesDataArray['store_logo']['name'];
        $storeBanner = $filesDataArray['store_banner']['name'];
        $state            = $data['state'];
        $country            = $data['country'];
        $description = $data['description'];
        $metaKeyword = $data['meta_keyword'];
        $metaDescription = $data['meta_description'];
        $twitterId         = $data['twitter_id'];
        $facebookId        = $data['facebook_id']; 
        $googleId        = $data['google_id'];
        $linkedId        = $data['linked_id'];
        $bankPayment = $data['bank_payment'];
        $paypalId = $data['paypal_id'];
        if (isset($data['remove_logo'])) {
            $removeLogo = $data['remove_logo'];
        }
        if (isset($data['remove_banner'])) {
        	$removeBanner = $data['remove_banner'];
        }
        $contact = $data['contact'];
        if (isset($data['show_profile'])) {
            $showProfile = $data['show_profile'];
        }
        $basedir = Mage::getBaseDir('media');
        $file = new Varien_Io_File();
        /**
         * create a folder to save the logo and banner images in media folder 
         */
        if (!is_dir($basedir . '/sellerimage')) {
            $file->mkdir($basedir . '/sellerimage');
        }
        if (isset($filesDataArray['store_logo']['name']) && (file_exists($filesDataArray['store_logo']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader($filesDataArray['store_logo']);
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->addValidateCallback('catalog_product_image', Mage::helper('catalog/image'), 'validateUploadFile');
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $path = $basedir . DS . 'sellerimage';
                $uploader->save($path, $filesDataArray['store_logo']['name']);
                $imagesPathLogo = $uploader->getUploadedFileName();
            } catch (Exception $e) {
                /**
                 * Display error message for images upload  
                 */
                Mage::getSingleton('core/session')->addError($this->__($e->getMessage()));
            }
            if (!is_dir($basedir . '/marketplace/resized')) {
                $file->mkdir($basedir . '/marketplace/resized');
            }
            $imageUrlLogo = Mage::getBaseDir('media') . DS . 'sellerimage' . DS . $imagesPathLogo;
            $imageResizedLogo = Mage::getBaseDir('media') . DS . 'marketplace' . DS . 'resized' . DS . $imagesPathLogo;
            if (file_exists($imageUrlLogo) && !file_exists($imageResizedLogo)) {
                $imageObj = new Varien_Image($imageUrlLogo);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(False);
                $imageObj->keepFrame(FALSE);
                 $imageObj->resize(150, 110);
                $imageObj->save($imageResizedLogo);
            }
        }
        
        /**
         * create a folder to save the logo and banner images in media folder
        */
        if (!is_dir($basedir . '/sellerimage')) {
        	$file->mkdir($basedir . '/sellerimage');
        }
        if (isset($filesDataArray['store_banner']['name']) && (file_exists($filesDataArray['store_banner']['tmp_name']))) {
        	try {
        		$uploader = new Varien_File_Uploader($filesDataArray['store_banner']);
        		$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
        		$uploader->addValidateCallback('catalog_product_image', Mage::helper('catalog/image'), 'validateUploadFile');
        		$uploader->setAllowRenameFiles(true);
        		$uploader->setFilesDispersion(false);
        		$path = $basedir . DS . 'sellerimage';
        		$uploader->save($path, $filesDataArray['store_banner']['name']);
        		$imagesPathBanner = $uploader->getUploadedFileName();
        	} catch (Exception $e) {
        		/**
        		 * Display error message for images upload
        		 */
        		Mage::getSingleton('core/session')->addError($this->__($e->getMessage()));
        	}
        	if (!is_dir($basedir . '/marketplace/resized')) {
        		$file->mkdir($basedir . '/marketplace/resized');
        	}
        	$imageUrlBanner = Mage::getBaseDir('media') . DS . 'sellerimage' . DS . $imagesPathBanner; 
        	$imageResizedBanner = Mage::getBaseDir('media') . DS . 'marketplace' . DS . 'resized' . DS . $imagesPathBanner;
        	if (file_exists($imageUrlBanner) && !file_exists($imageResizedBanner)) {         		      		
        		$imageObj = new Varien_Image($imageUrlBanner);
        		$imageObj->constrainOnly(TRUE);
        		$imageObj->keepAspectRatio(False);
        		$imageObj->keepFrame(FALSE);
        		$imageObj->resize(750,230);
        		$imageObj->save($imageResizedBanner);
        	}
        }
        $collection = Mage::getModel('marketplace/sellerprofile')->load($sellerId, 'seller_id');
        $getId = $collection->getId();
        try {
            if ($getId) {
                /**
                 * Update form input data in database
                 */
                $collection = Mage::getModel('marketplace/sellerprofile')->load($sellerId, 'seller_id');
                $collection->setSellerId($sellerId);
                $collection->setStoreTitle('jh');
                if (!empty($storeLogo)) {
                    $collection->setStoreLogo($imagesPathLogo);
                }
                if (!empty($storeBanner)) {                	
                	$collection->setStoreBanner($imagesPathBanner);
                }
                if ($removeLogo == 1) {
                    $collection->setStoreLogo('');
                }
                if ($removeBanner == 1) {                	
                	$collection->setStoreBanner('');
                }
                $collection->setState($state);
                $collection->setCountry($country);
                $collection->setDescription($description);
                $collection->setMetaKeyword($metaKeyword);
                $collection->setMetaDescription($metaDescription);
                $collection->setTwitterId($twitterId);
                $collection->setFacebookId($facebookId);
                $collection->setGoogleId($googleId);
                $collection->setLinkedId($linkedId);
                $collection->setContact($contact);
                $collection->setBankPayment($bankPayment);
                $collection->setPaypalId($paypalId);
                if ($showProfile) {
                    $collection->setShowProfile($showProfile);
                } else {
                    $collection->setShowProfile('');
                }
                $collection->save();

                $targetPath = 'marketplace/seller/displayseller/id/' . $sellerId;
                $mainUrlRewrite = Mage::getModel('core/url_rewrite')->load($targetPath, 'target_path');
                $getRequestPath = $mainUrlRewrite->getRequestPath();
                $newGetRequestPath = Mage::getUrl($getRequestPath);
                if ($newGetRequestPath == Mage::getBaseUrl()) {
                    Mage::getModel('marketplace/sellerprofile')->addRewriteUrl($storeName, $sellerId);
                }
                Mage::getSingleton('core/session')->addSuccess($this->__('Your profile information is saved successfully'));
                $this->_redirect('marketplace/seller/addprofile');
                return true;
            } else {
                /**
                 * insert form input data in database  
                 */
                $collection = Mage::getModel('marketplace/sellerprofile');
                $collection->setSellerId($sellerId);
                $collection->setStoreTitle($storeName);
                $collection->setStoreLogo($imagesPathLogo);
                $collection->setStoreBanner($imagesPathBanner);
                $collection->setState($state);
                $collection->setCountry($country);
                $collection->setContact($contact);
                $collection->setDescription($description);
                $collection->setMetaKeyword($metaKeyword);
                $collection->setMetaDescription($metaDescription);
                $collection->setTwitterId($twitterId);
                $collection->setFacebookId($facebookId);
                $collection->setGoogleId($googleId);
                $collection->setLinkedId($linkedId);
                $collection->setBankPayment($bankPayment);
                $collection->setPaypalId($paypalId);
                $collection->setShowProfile($showProfile);
                $collection->save();
                /**
                 * url management 
                 */
                Mage::getModel('marketplace/sellerprofile')->addRewriteUrl($storeName, $sellerId);
                Mage::getSingleton('core/session')->addSuccess($this->__('Your profile information is saved successfully'));
                $this->_redirect('marketplace/seller/addprofile');
                return true;
            }
        } catch (Exception $e) {
            /**
             * Error message redirect to create new product page 
             */
            Mage::getSingleton('core/session')->addError($this->__($e->getMessage()));
            $this->_redirect('marketplace/seller/addprofile');
        }
    }

    /**
     * Function to display change buyer into seller form
     * 
     * change buyer in to seller form 
     * @return void
     */
    function changebuyerAction() {
        Mage::helper('marketplace')->checkMarketplaceKey();
        if (!$this->_getSession()->isLoggedIn()) {
            Mage::getSingleton('core/session')->addError($this->__('You must have a Seller Account to access this page'));
            $this->_redirect('customer/account/login');
            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Function to change buyer into seller 
     * 
     * convert and change group id from buyer into seller 
     * @return void
     */
    function becomesellerAction() {
        $adminApproval = Mage::getStoreConfig('marketplace/admin_approval_seller_registration/need_approval');
        $approval = 0;
        if ($adminApproval == 1) {
            $approval = 0;
        } else {
            $approval = 1;
        }
        $getGroupId = Mage::helper('marketplace')->getGroupId();
        $customer = Mage::getSingleton("customer/session")->getCustomer();
        $customer->setGroupId($getGroupId)->save();
        $customerId = $customer->getId();
        $model = Mage::getModel('customer/customer')->load($customerId);
        $model->setCustomerstatus($approval)
                ->save();
        if ($adminApproval == 1) {
            Mage::getModel('marketplace/sellerprofile')->adminApproval($customerId);
            Mage::getSingleton('core/session')->addSuccess($this->__('Admin Approval is required. Please wait until admin confirms your Seller Account'));
        } else {
            Mage::getModel('marketplace/sellerprofile')->newSeller($customerId);
            Mage::getSingleton('core/session')->addSuccess($this->__('Thank you for registering with %s.', Mage::app()->getStore()->getFrontendName()));
        }
        $this->_redirect('customer/account');
    }

    /**
     * Function to display seller profile information
     * 
     * Display seller profile page
     * @return void
     */
    function displaysellerAction() {
        Mage::helper('marketplace')->checkMarketplaceKey();
        $this->loadLayout();
        $this->renderLayout();
        $id = $this->getRequest()->getParam('id');
        $sellerPage = Mage::getModel('marketplace/sellerprofile')->collectprofile($id);
        $head = $this->getLayout()->getBlock('head');
        $head->setTitle($sellerPage->getStoreTitle());
        $head->setKeywords($sellerPage->getMetaKeyword());
        $head->setDescription($sellerPage->getMetaDescription());
    }
    
    /**
     * Function to display seller dashboard
     * 
     * Display seller dashboard page
     * @return void
     */
    function dashboardAction() {
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
     * Function to display top seller 
     * 
     * Display seller top seller page
     * @return void
     */
    function topsellerAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Function to display All seller information 
     * 
     * Display all seller page
     * @return void
     */
    function allsellerAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('All Seller'));
        $this->renderLayout();
    }

    /**
     * Function to display category wise seller products 
     * 
     * Display category wise seller products
     * @return void
     */
    function categorylistAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Category List'));
        $this->renderLayout();
    }

    /**
     * Function to save reviews and ratings
     * 
     * Save seller review 
     * @return void
     */
    function savereviewAction() {
        $data = $this->getRequest()->getPost();
        $id = $data['seller_id'];
        $url = Mage::getModel('marketplace/sellerreview')->backUrl($id);
        $saveReview = Mage::getModel('marketplace/sellerreview')->saveReview($data);
        if ($saveReview == 1) {
        	$needAdmin    =  Mage::getStoreConfig('marketplace/seller_review/need_approval');        	
        	if($needAdmin == 1){
        	Mage::getSingleton('core/session')->addSuccess($this->__('Your review has been accepted for moderation.'));        	
        	} else {
        	Mage::getSingleton('core/session')->addSuccess($this->__('Your review has been successfully posted.'));
        	}        	
          
            $this->_redirectUrl($url);
        } else {
            Mage::getSingleton('core/session')->addError($this->__('Sorry there was an error occured while submiting your review'));
            $this->_redirectUrl($url);
        }
    }

    /**
     * Function to display all reviews in seller profile page
     * 
     * Display seller review page
     * @return void
     */
    function allreviewAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('All Review'));
        $this->renderLayout();
    }

    /**
     * Function to display customer review to seller
     * 
     * Display customer review page
     * @return void
     */
    function customerreviewAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Customer Review'));
        $this->renderLayout();
    }

    /**
     * Function to display vacation mode to seller
     * 
     * Display vacation mode page
     * @return void
     */
    function vacationmodeAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Vacation Mode'));
        $this->renderLayout();
    }

    /**
     * Function to save vacation mode to seller
     * 
     * Display vacation mode save page
     * @return void
     */
    function vacationmodesaveAction() {
        $vacationStatus = $this->getRequest()->getParam('vacation_status');
        $vacationMessage = $this->getRequest()->getParam('vacation_message');
        $disableProducts = $this->getRequest()->getParam('disable_products');
        $dateFrom = $this->getRequest()->getParam('date_from');
        $dateTo = $this->getRequest()->getParam('date_to');
        $currentDate = Mage::getModel('core/date')->date('Y-m-d');
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $seller = Mage::getSingleton('customer/session')->getCustomer();
            $sellerId = $seller->getId();
            $product = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter('seller_id', $sellerId);
            $productId = array();
            foreach ($product as $_product) {
                $productId[] = $_product->getId();
            }
            $sellerInfo = Mage::getModel('marketplace/vacationmode')->load($sellerId, 'seller_id');
            $getId = $sellerInfo->getId();
            if ($getId) {
                $updateExisting = Mage::getModel('marketplace/vacationmode')->load($sellerId, 'seller_id');
                $updateExisting->setVacationMessage($vacationMessage);
                $updateExisting->setVacationStatus($vacationStatus);
                $updateExisting->setProductDisabled($disableProducts);
                $updateExisting->setDateFrom($dateFrom);
                $updateExisting->setDateTo($dateTo);
                $updateExisting->setSellerId($sellerId);
                $updateExisting->save();
                
            } else {
                $insertNew = Mage::getModel('marketplace/vacationmode');
                $insertNew->setVacationMessage($vacationMessage);
                $insertNew->setVacationStatus($vacationStatus);
                $insertNew->setProductDisabled($disableProducts);
                $insertNew->setDateFrom($dateFrom);
                $insertNew->setDateTo($dateTo);
                $insertNew->setSellerId($sellerId);
                $insertNew->save();
            }
            if($vacationStatus == 0){
                if ($disableProducts == 0) {                	             	
                    foreach ($productId as $_productId) {                    	
                        Mage::getModel('catalog/product')->load($_productId)->setStatus(2)->save();
                    }              
                } elseif ($disableProducts == 1) {           	      	
                	foreach ($productId as $_productId) {
                        Mage::getModel('catalog/product')->load($_productId)->setStatus(1)->save();
                    }            
                }
               
            } else {
            	foreach ($productId as $_productId) {
            		Mage::getModel('catalog/product')->load($_productId)->setStatus(1)->save();
            	}
            }
            Mage::getSingleton('core/session')->addSuccess($this->__('Your vacation mode information is saved successfully'));
            $this->_redirect('marketplace/seller/vacationmode');
            return true;
        }
        }
        /**
         * Load seller products with category id in ajax
         * 
         * @param int id
         * @param int sellerid
         * 
         * @return string
         */
        function getProductListAction(){
        	$categoryId = $this->getRequest()->getParam('id');
        	$sellerId = $this->getRequest()->getParam('sellerid');  	    	
        	$collection = Mage::getModel('catalog/product')
        				->getCollection()
        				->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
        				->addAttributeToSelect('*')
        				->addAttributeToFilter('category_id', array('in' => $categoryId))
        				->addAttributeToFilter('seller_id',$sellerId);        	
        	 $collectionSize = count($collection);
        	 if($collectionSize>0){
        	 	$productDetails = '<ul id = "mp-product-list" class="products-grid product_snipt f-left">';
        	 	foreach($collection as $_collection){
        	 		$wordsCount_category = strlen($_collection->getName()); 
        	 		$productDetails .= '<li class="item">';
        	 		$productDetails .= '<a href="'.$_collection->getProductUrl().'">';
        	 		$productDetails .= '<img class="product-image" src="'.Mage::helper('catalog/image')->init($_collection, 'thumbnail')->resize(250).'"alt="'.$_collection->getName().'" />';
        	 		$productDetails .= '</a>';
        	 		$productDetails .= '<div class="product-info" style="min-height: 0px;">';
        	 		$productDetails .= '<h2 class="product-name">';
        	 		$productDetails .= '<a href="'.$_collection->getProductUrl().'">'; 
        	 		if ($wordsCount_category > 15) { 
        	 		     $productDetails .= substr(strip_tags($_collection->getName()), 0, 15) . '...';
        	 		} else {
        	 		     $productDetails .= $_collection->getName();
        	 		}
        	 		 $productDetails .= '</a>';
        	 		 $productDetails .= '</h2>';        	 		 
        	 		 $reviewHelper = $this->getLayout()->createBlock('review/helper');
        	 		 $productDetails .= $reviewHelper->getSummaryHtml($_collection, 'short', true);
        	 		 $productDetails .= Mage::helper('marketplace/marketplace')->getLabel($_collection);
        	 		 $productDetails .='<div class="price-box">';
        	 		 $productDetails .= '<span class="regular-price">';             
        	 		 $productDetails .= '<span class="price">';        	 		
        	 		 /**
        	 		  * Display Product Price
        	 		  */
        	 		 $price          = $_collection->getPrice();
        	 		 $splPrice      = $_collection->getSpecialPrice();
        	 		 $dealExpireDate = $_collection->getspecialToDate();
        	 		 if (!empty($spl_price) && ($dealExpireDate != '') && ($dealExpireDate >= $currentDate)) { 
        	 		 	$originalPrice = $_collection->getPrice(); //get orginal price
        	 		 	$discountPrice = $_collection->getSpecialPrice(); //get the discount amount
        	 		 	$savings = $originalPrice - $discountPrice; //get the saving amount from orginal price - discount price
        	 		 	$savingsPercentage = round(($savings / $originalPrice) * 100, 0);
        	 		    $productDetails .= '<p><del>"'. Mage::helper('core')->currency($price, true, false).'"</del></p>';
        	 		    $productDetails .= '<p>'. Mage::helper('core')->currency($splPrice, true, false).'</p>';
        	 		    $productDetails .= '<p>'.'-'.$savingsPercentage.'%'.'</p>';
        	 		  } else {
        	 		     $productDetails .= '<p>'. Mage::helper('core')->currency($price, true, false).'</p>';
        	 		   }
        	 		   $productDetails .= '</span>';
        	 		   $productDetails .= '</span></div>';
        	 		   
        	 		   $productDetails .= '</div>';
        	 		   $productDetails .= '</li>';
        	 		 }
        	 		  } else {
        	 		  $productDetails .= 'No products exists';
        	 		 }  
        	 		   echo $productDetails .= '</ul>';
        	 	
        }
        function contactsellerAction(){
        	$sellerId = $this->getRequest()->getParam('id');
        	$customerName = $this->getRequest()->getPost('customer_name');
        	$customerEmail = $this->getRequest()->getPost('customer_email');
        	$customerMessage = $this->getRequest()->getPost('message');
        	$rewriteUrl = Mage::helper('marketplace/marketplace')->getSellerRewriteUrl($sellerId);
        	if($sellerId != '' && $customerName != '' && $customerEmail != '' && $customerMessage !=''){
        		if (Mage::getStoreConfig('marketplace/admin_approval_seller_registration/display_contact_seller') == 1) {
        			/**
        			 *  Sending email for added new product
        			 */
        			$templateId = (int) Mage::getStoreConfig('marketplace/admin_approval_seller_registration/contact_seller');        			
        		
        			if ($templateId) {
        				$emailTemplate = Mage::getModel('core/email_template')->load($templateId);
        			} else {
        				$emailTemplate = Mage::getModel('core/email_template')
        				->loadDefault('marketplace_admin_approval_seller_registration_contact_seller');
        			}
        			$SellerInfo = Mage::getModel('customer/customer')->load($sellerId);
        			$selleremail = $SellerInfo->getEmail();
        			$recipient = $selleremail;
        			$sellername = $SellerInfo->getName();        			
        			$domainName = Mage::app ()->getFrontController ()->getRequest ()->getHttpHost ();
        			
        			$emailTemplate->setSenderName($customerName);
        			$emailTemplate->setSenderEmail($customerEmail);
        			$emailTemplateVariables = (array('sellername' => $sellername,'customername'=>$customerName, 'customeremail' => $customerEmail, 'customermessage' => $customerMessage,'domainname' => $domainName));
        			$emailTemplate->setDesignConfig(array('area' => 'frontend'));
        			$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
        			$emailTemplate->send($recipient, $sellername, $emailTemplateVariables);
        		}
        		Mage::getSingleton('core/session')->addSuccess($this->__('Your message has been successfully sent'));
        		$this->_redirectUrl($rewriteUrl);
        		return true;
        	}
        }
}
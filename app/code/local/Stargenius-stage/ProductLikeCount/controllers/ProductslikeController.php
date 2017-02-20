<?php
/**
 * Stargenius_ProductLikeCount extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Stargenius
 * @package        Stargenius_ProductLikeCount
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * ProductsLike front contrller
 *
 * @category    Stargenius
 * @package     Stargenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class Stargenius_ProductLikeCount_ProductslikeController extends Mage_Core_Controller_Front_Action
{

    /**
      * default action
      *
      * @access public
      * @return void
      * @author Ultimate Module Creator
      */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('stargenius_productlikecount/productslike')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('stargenius_productlikecount')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'productslikes',
                    array(
                        'label' => Mage::helper('stargenius_productlikecount')->__('ProductsLikes'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('stargenius_productlikecount/productslike')->getProductslikesUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('stargenius_productlikecount/productslike/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('stargenius_productlikecount/productslike/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('stargenius_productlikecount/productslike/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init ProductsLike
     *
     * @access protected
     * @return Stargenius_ProductLikeCount_Model_Productslike
     * @author Ultimate Module Creator
     */
    protected function _initProductslike()
    {
       $name   = $this->getRequest()->getParam('name');
	   $productslike     = Mage::getModel('stargenius_productlikecount/productslike')->load( $name );
	    $productslikeId   = $this->getRequest()->getParam('id', 0);
        $productslike     = Mage::getModel('stargenius_productlikecount/productslike')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productslikeId);
        if (!$productslike->getId()) {
            return false;
        } elseif (!$productslike->getStatus()) {
            return false;
        }
        return $productslike;
    }
	
	   protected function ashuAction()
    {
     
	  $p_id  = $this->getRequest()->getPost('id');
       $p_sku = $this->getRequest()->getPost('sku');
        $u_ip = $this->getRequest()->getPost('ip');
		 $postcollection = Mage::getModel('stargenius_productlikecount/productslike')->load(NULL);
		$postcollection->setProductId($p_id);
		$postcollection->setProductSku($p_sku);
		$postcollection->setProductLiked(1);
		$postcollection->setUIpaddress($u_ip );
		$postcollection->setStatus(1);
				$postcollection->save();
		
	
    }
	

    /**
     * view productslike action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $productslike = $this->_initProductslike();
        if (!$productslike) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_productslike', $productslike);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('productlikecount-productslike productlikecount-productslike' . $productslike->getId());
        }
        if (Mage::helper('stargenius_productlikecount/productslike')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('stargenius_productlikecount')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'productslikes',
                    array(
                        'label' => Mage::helper('stargenius_productlikecount')->__('ProductsLikes'),
                        'link'  => Mage::helper('stargenius_productlikecount/productslike')->getProductslikesUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'productslike',
                    array(
                        'label' => $productslike->getProductSku(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $productslike->getProductslikeUrl());
        }
        if ($headBlock) {
            if ($productslike->getMetaTitle()) {
                $headBlock->setTitle($productslike->getMetaTitle());
            } else {
                $headBlock->setTitle($productslike->getProductSku());
            }
            $headBlock->setKeywords($productslike->getMetaKeywords());
            $headBlock->setDescription($productslike->getMetaDescription());
        }
        $this->renderLayout();
    }
}

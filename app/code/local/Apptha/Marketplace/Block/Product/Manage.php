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
 * Manage seller products functionality
 */
class Apptha_Marketplace_Block_Product_Manage extends Mage_Core_Block_Template {

    /**
     * Collection for manage products
     * 
     * @return \Apptha_Marketplace_Block_Product_Manage
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $manageCollection = $this->manageProducts();
        $this->setCollection($manageCollection);
        $pager = $this->getLayout()
                ->createBlock('page/html_pager', 'my.pager')
                ->setCollection($manageCollection);
        $pager->setAvailableLimit(array(10 => 10, 20 => 20, 50 => 50));     
        $this->setChild('pager', $pager);
        return $this;
    }

    /**
     * Function to get the product details
     * 
     * Return product collection
     * @return array
     */
    public function manageProducts() {
        $entityIds = $this->getRequest()->getParam('id');
        	$delete = $this->getRequest()->getPost('multi');
        	$multi_submit = $this->getRequest()->getPost('multi_submit');
       /**
        * Check if submit buttom submitted. 
        */
      if ($multi_submit) {
			if (count ( $entityIds ) > 0 && $delete == 'delete') {
				foreach ( $entityIds as $_entity_ids ) {
					Mage::register ( 'isSecureArea', true );
					Mage::helper ( 'marketplace/marketplace' )->deleteProduct ( $_entity_ids );
					Mage::unregister ( 'isSecureArea' );
				}
				Mage::getSingleton ( 'core/session' )->addSuccess ( $this->__ ( "selected Products are Deleted Successfully" ) );
				$url = Mage::getUrl ( 'marketplace/product/manage' );
				Mage::app ()->getFrontController ()->getResponse ()->setRedirect ( $url );
			} elseif (count ( $entityIds ) == 0 && $delete == 'delete') {
				Mage::getSingleton ( 'core/session' )->addError ( $this->__ ( "Please select a product to delete" ) );
				$url = Mage::getUrl ( 'marketplace/product/manage' );
				Mage::app ()->getFrontController ()->getResponse ()->setRedirect ( $url );
			}
		}
        $filterId = $this->getRequest()->getParam('filter_id');
        $filterName = $this->getRequest()->getParam('filter_name');
        $filterPrice = $this->getRequest()->getParam('filter_price');
        $filterStatus = $this->getRequest()->getParam('filter_status');
        $filterQuantity = $this->getRequest()->getParam('filter_quantity');
        $cusId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        $products = Mage::getModel('catalog/product')->getCollection();
        $products->addAttributeToSelect('*');
        $products->addAttributeToFilter('seller_id', array('eq' => $cusId));
        if ($filterId != '') {
            $products->addAttributeToFilter('entity_id', array('eq' => $filterId));
        }
        if ($filterName != '') {
            $products->addAttributeToFilter('name', array('like' => '%' . $filterName . '%'));
        }
        if ($filterPrice != '') {
            $products->addAttributeToFilter('price', array('eq' => $filterPrice));
        }
        if ($filterStatus != 0) {
            $products->addAttributeToFilter('status', array('eq' => $filterStatus));
        }       
        if($filterQuantity!=''){
        	$products->joinField(
        			'qty',
        			'cataloginventory/stock_item',
        			'qty',
        			'product_id=entity_id',
        			'{{table}}.stock_id=1',
        			'left'
        	)
        	->addAttributeToFilter('qty', array('eq' =>$filterQuantity));
        }
      
        $products->addAttributeToSort('entity_id', 'DESC');
              
        return $products;
    }

    /**
     * Function to display pagination
     * 
     * Return collection with pagination
     * @return array
     */
    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }

    /**
     * Function to get multi select url
     * 
     * Return the multi select option url
     * @return string
     */
    public function getmultiselectUrl() {
        return Mage::getUrl('marketplace/product/manage');
    }

}
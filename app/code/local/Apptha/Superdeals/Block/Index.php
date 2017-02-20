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
 * This file is used to display deal products 
 */
class Apptha_Superdeals_Block_Index extends Mage_Catalog_Block_Product_Abstract {

    /**
     * Default toolbar block name
     *
     * @var string
     */
    protected $_defaultToolbarBlock = 'catalog/product_list_toolbar';

    /**
     * Product Collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_productCollection;

    /**
     * Retrieve loaded category collection
     * 
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function _prepareLayout() {
        /**
         * SEO Meta Keywords, title, descriptions for deal page
         */
        $STORE_CONFIG_SEO_META_TITLE = Mage::getStoreConfig('superdeals/seosettings/seotitle');
        $STORE_CONFIG_SEO_META_KEYWORDS = Mage::getStoreConfig('superdeals/seosettings/seokeyword');
        $STORE_CONFIG_SEO_META_DESCRIPTION = Mage::getStoreConfig('superdeals/seosettings/seodescription');

        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle($STORE_CONFIG_SEO_META_TITLE);
            $headBlock->setKeywords($STORE_CONFIG_SEO_META_KEYWORDS);
            $headBlock->setDescription($STORE_CONFIG_SEO_META_DESCRIPTION);
        }

        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
        $breadcrumbs->addCrumb('home', array('label' => Mage::helper('cms')->__('Home'), 'title' => Mage::helper('cms')->__('Home Page'), 'link' => Mage::getBaseUrl()));
        $breadcrumbs->addCrumb('deals', array('label' => 'Deals', 'title' => 'Deals'));
        return parent::_prepareLayout();
    }
    /**
     * Function to check the whether to enable the deal link or not
     * 
     * Return 1 if enabled 
     * @return int
     */
    public function isLinkEnabled() {

        $dealsEnable1 = Mage::helper('core/data')->isModuleEnabled('Apptha_Superdeals');
        $dealsEnable = intval($dealsEnable1);

        $advanceOption1 = Mage::getStoreConfig('advanced/modules_disable_output/Apptha_Superdeals');
        $advanceOption = intval($advanceOption1);

        $STORE_CONFIG_MODULE_ENABLED = Mage::getStoreConfig('Apptha_Superdeals');
        $STORE_CONFIG_DEALS_ENABLED = Mage::getStoreConfig('superdeals/superdeals_group/deals_enable');

        if (($STORE_CONFIG_DEALS_ENABLED == 1) && ( $dealsEnable == 1) && ( $advanceOption == 0)) {
            return 1;
        }
    }
    /**
     * Function to check the whether to enable the deal link or not
     * 
     * Return 1 if enabled 
     * @return int
     */
    public function addLink($name, $path, $label, $urlParams = array()) {
        $this->_links[$name] = new Varien_Object(array(
            'name' => $name,
            'path' => $path,
            'label' => $label,
            'url' => $this->getUrl($path, $urlParams),
        ));
        return $this;
    }

    /**
     * Function to get product collection
     *      
     * This Function will return the product collection
     * @return array
     */
    protected function _getProductCollection() {
        $cat = $this->getRequest()->getParam('id');
        $value = $this->getRequest()->getParam('value');
        $order = $this->getRequest()->getParam('order');
        if (is_null($this->_productCollection)) {
            $layer = $this->getLayer();
            if ($this->getShowRootCategory()) {
                $this->setCategoryId(Mage::app()->getStore()->getRootCategoryId());
            }
            if (Mage::registry('product')) {
                $categories = Mage::registry('product')->getCategoryCollection()
                        ->setPage(1, 1)
                        ->load();
                if ($categories->count()) {
                    $this->setCategoryId(current($categories->getIterator()));
                }
            }
            $origCategory = null;
            if ($this->getCategoryId()) {
                $category = Mage::getModel('catalog/category')->load($this->getCategoryId());
                if ($category->getId()) {
                    $origCategory = $layer->getCurrentCategory();
                    $layer->setCurrentCategory($category);
                }
            }
            $this->_productCollection = $layer->getProductCollection();
            $storeId = Mage::app()->getStore()->getId();
            $todayDate = Mage::getModel('core/date')->date('m/d/Y');
            $weekDeal = date('Y-m-d', strtotime($todayDate . ' - 7 days'));
            $monthDeal = date('Y-m-d', strtotime($todayDate . ' - 30 days'));
            $tomorrow = mktime(0, 0, 0, date('m'), date('d') + 1, date('y'));
            $dateTomorrow = date('m/d/y', $tomorrow);
            $collection = Mage::getModel('catalog/product')->getCollection();
            $collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
            $collection = $this->_addProductAttributesAndPrices($collection)->addStoreFilter();
            if (!empty($cat)) {
                /**
                 * check the catagory id is not empty
                 */
                $category = Mage::getModel('catalog/category')->load($cat);
                $collection->addCategoryFilter($category);
            }
            $collection->setStoreId($storeId)
                    ->addStoreFilter($storeId)
                    ->addAttributeToFilter('special_price', array('neq' => ''))
                    ->addAttributeToFilter('special_to_date', array('or' => array(0 => array('date' => true, 'from' => $dateTomorrow), 1 => array('is' => new Zend_Db_Expr('null')))), 'left')
                    ->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate));
            if (empty($order)) {
                $collection->addAttributeToSort('special_to_date', 'asc');
            }
            if (!empty($value)) {
                if ($value == 0)
                    $collection->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate));
                if ($value == 1)
                    $collection->addAttributeToFilter('special_from_date', array('from' => $todayDate, 'date' => true));
                if ($value == 2)
                    $collection->addAttributeToFilter('special_from_date', array('from' => $weekDeal, 'date' => true));
                if ($value == 3)
                    $collection->addAttributeToFilter('special_from_date', array('from' => $monthDeal, 'date' => true));
            }
            else {
                $collection->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate));
            }
            $this->setCollection($collection);
        }
        return $this->_productCollection;
    }

    /**
     * Get catalog layer model
     *
     * @return Mage_Catalog_Model_Layer
     */
    public function getLayer() {
        $layer = Mage::registry('current_layer');
        if ($layer) {
            return $layer;
        }
        return Mage::getSingleton('catalog/layer');
    }

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLoadedProductCollection() {
        return $this->_getProductCollection();
    }

    /**
     * Retrieve current view mode
     *
     * @return string
     */
    public function getMode() {
        return $this->getChild('toolbar')->getCurrentMode();
    }

    /**
     * Need use as _prepareLayout
     */
    protected function _beforeToHtml() {
        $toolbar = $this->getToolbarBlock();

        /**
         *  called prepare sortable parameters
         */
        $collection = $this->_getProductCollection();

        /**
         *  use sortable parameters
         */
        if ($orders = $this->getAvailableOrders()) {
            $toolbar->setAvailableOrders($orders);
        }
        if ($sort = $this->getSortBy()) {
            $toolbar->setDefaultOrder($sort);
        }
        if ($dir = $this->getDefaultDirection()) {
            $toolbar->setDefaultDirection($dir);
        }
        if ($modes = $this->getModes()) {
            $toolbar->setModes($modes);
        }
        /**
         *  set collection to toolbar and apply sort
         */
        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);
        Mage::dispatchEvent('catalog_block_product_list_collection', array(
            'collection' => $this->_getProductCollection()
        ));

        $this->_getProductCollection()->load();

        return parent::_beforeToHtml();
    }

    /**
     * Retrieve Toolbar block
     *
     * @return Mage_Catalog_Block_Product_List_Toolbar
     */
    public function getToolbarBlock() {
        if ($blockName = $this->getToolbarBlockName()) {
            if ($block = $this->getLayout()->getBlock($blockName)) {
                return $block;
            }
        }
        $block = $this->getLayout()->createBlock($this->_defaultToolbarBlock, microtime());
        return $block;
    }

    /**
     * Retrieve additional blocks html
     *
     * @return string
     */
    public function getAdditionalHtml() {
        return $this->getChildHtml('additional');
    }

    /**
     * Retrieve list toolbar HTML
     *
     * @return string
     */
    public function getToolbarHtml() {
        return $this->getChildHtml('toolbar');
    }

    /**
     * Retrieve list toolbar HTML
     *
     * Passed the collection array
     * @param int $sellerId
     * 
     * @return array
     */
    public function setCollection($collection) {
        $this->_productCollection = $collection;
        return $this;
    }
    /**
     * Retrieve Attribute using the attribute id
     *
     * Passed the attribute id as $code
     * @param varchar $code
     * 
     * @return array
     */
    public function addAttribute($code) {
        $this->_getProductCollection()->addAttributeToSelect($code);
        return $this;
    }
    /**
     * Display deal price information in product detail page     
     * 
     * Return the layout block in view page
     * @return void
     */
    public function getPriceBlockTemplate() {
        return $this->_getData('price_block_template');
    }

    /**
     * Retrieve Catalog Config object
     *
     * @return Mage_Catalog_Model_Config
     */
    protected function _getConfig() {
        return Mage::getSingleton('catalog/config');
    }

    /**
     * Prepare Sort By fields from Category Data
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Block_Product_List
     */
    public function prepareSortableFieldsByCategory($category) {
        if (!$this->getAvailableOrders()) {
            $this->setAvailableOrders($category->getAvailableSortByOptions());
        }
        $availableOrders = $this->getAvailableOrders();
        if (!$this->getSortBy()) {
            if ($categorySortBy = $category->getDefaultSortBy()) {
                if (!$availableOrders) {
                    $availableOrders = $this->_getConfig()->getAttributeUsedForSortByArray();
                }
                if (isset($availableOrders[$categorySortBy])) {
                    $this->setSortBy($categorySortBy);
                }
            }
        }
        return $this;
    }

}
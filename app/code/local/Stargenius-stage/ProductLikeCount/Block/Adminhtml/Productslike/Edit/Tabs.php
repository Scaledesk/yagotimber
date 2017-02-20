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
 * ProductsLike admin edit tabs
 *
 * @category    Stargenius
 * @package     Stargenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class Stargenius_ProductLikeCount_Block_Adminhtml_Productslike_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('productslike_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('stargenius_productlikecount')->__('ProductsLike'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Stargenius_ProductLikeCount_Block_Adminhtml_Productslike_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_productslike',
            array(
                'label'   => Mage::helper('stargenius_productlikecount')->__('ProductsLike'),
                'title'   => Mage::helper('stargenius_productlikecount')->__('ProductsLike'),
                'content' => $this->getLayout()->createBlock(
                    'stargenius_productlikecount/adminhtml_productslike_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'form_meta_productslike',
            array(
                'label'   => Mage::helper('stargenius_productlikecount')->__('Meta'),
                'title'   => Mage::helper('stargenius_productlikecount')->__('Meta'),
                'content' => $this->getLayout()->createBlock(
                    'stargenius_productlikecount/adminhtml_productslike_edit_tab_meta'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_productslike',
                array(
                    'label'   => Mage::helper('stargenius_productlikecount')->__('Store views'),
                    'title'   => Mage::helper('stargenius_productlikecount')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'stargenius_productlikecount/adminhtml_productslike_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve productslike entity
     *
     * @access public
     * @return Stargenius_ProductLikeCount_Model_Productslike
     * @author Ultimate Module Creator
     */
    public function getProductslike()
    {
        return Mage::registry('current_productslike');
    }
}

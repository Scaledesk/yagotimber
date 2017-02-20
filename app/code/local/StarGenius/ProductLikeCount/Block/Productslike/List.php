<?php
/**
 * StarGenius_ProductLikeCount extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_ProductLikeCount
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * ProductsLike list block
 *
 * @category    StarGenius
 * @package     StarGenius_ProductLikeCount
 * @author Ultimate Module Creator
 */
class StarGenius_ProductLikeCount_Block_Productslike_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $productslikes = Mage::getResourceModel('stargenius_productlikecount/productslike_collection')
                         ->addStoreFilter(Mage::app()->getStore())
                         ->addFieldToFilter('status', 1);
        $productslikes->setOrder('product_sku', 'asc');
        $this->setProductslikes($productslikes);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return StarGenius_ProductLikeCount_Block_Productslike_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'stargenius_productlikecount.productslike.html.pager'
        )
        ->setCollection($this->getProductslikes());
        $this->setChild('pager', $pager);
        $this->getProductslikes()->load();
        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}

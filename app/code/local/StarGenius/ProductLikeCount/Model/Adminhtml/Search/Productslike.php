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
 * Admin search model
 *
 * @category    StarGenius
 * @package     StarGenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class StarGenius_ProductLikeCount_Model_Adminhtml_Search_Productslike extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return StarGenius_ProductLikeCount_Model_Adminhtml_Search_Productslike
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('stargenius_productlikecount/productslike_collection')
            ->addFieldToFilter('product_sku', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $productslike) {
            $arr[] = array(
                'id'          => 'productslike/1/'.$productslike->getId(),
                'type'        => Mage::helper('stargenius_productlikecount')->__('ProductsLike'),
                'name'        => $productslike->getProductSku(),
                'description' => $productslike->getProductSku(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/productlikecount_productslike/edit',
                    array('id'=>$productslike->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}

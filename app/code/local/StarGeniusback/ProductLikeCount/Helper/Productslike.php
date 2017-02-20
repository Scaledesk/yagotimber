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
 * ProductsLike helper
 *
 * @category    StarGenius
 * @package     StarGenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class StarGenius_ProductLikeCount_Helper_Productslike extends Mage_Core_Helper_Abstract
{

    /**
     * get the url to the productslikes list page
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getProductslikesUrl()
    {
        if ($listKey = Mage::getStoreConfig('stargenius_productlikecount/productslike/url_rewrite_list')) {
            return Mage::getUrl('', array('_direct'=>$listKey));
        }
        return Mage::getUrl('stargenius_productlikecount/productslike/index');
    }

    /**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getUseBreadcrumbs()
    {
        return Mage::getStoreConfigFlag('stargenius_productlikecount/productslike/breadcrumbs');
    }
}

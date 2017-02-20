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
 * ProductsLike view block
 *
 * @category    Stargenius
 * @package     Stargenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class Stargenius_ProductLikeCount_Block_Productslike_View extends Mage_Core_Block_Template
{
    /**
     * get the current productslike
     *
     * @access public
     * @return mixed (Stargenius_ProductLikeCount_Model_Productslike|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentProductslike()
    {
        return Mage::registry('current_productslike');
    }
}

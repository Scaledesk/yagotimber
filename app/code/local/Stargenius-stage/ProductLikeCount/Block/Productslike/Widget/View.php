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
 * ProductsLike widget block
 *
 * @category    Stargenius
 * @package     Stargenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class Stargenius_ProductLikeCount_Block_Productslike_Widget_View extends Mage_Core_Block_Template implements
    Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'stargenius_productlikecount/productslike/widget/view.phtml';

    /**
     * Prepare a for widget
     *
     * @access protected
     * @return Stargenius_ProductLikeCount_Block_Productslike_Widget_View
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $productslikeId = $this->getData('productslike_id');
        if ($productslikeId) {
            $productslike = Mage::getModel('stargenius_productlikecount/productslike')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productslikeId);
            if ($productslike->getStatus()) {
                $this->setCurrentProductslike($productslike);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }
}

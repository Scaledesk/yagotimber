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
 * Form to get the seller commission from admin 
 */
class Apptha_Marketplace_Block_Adminhtml_Manageseller_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * Get the get the seller commission from admin 
     * 
     * @return void
     */
    protected function _prepareForm() {
        $seller_id = $this->getRequest()->getParam('id');
        $collection = Mage::getModel('marketplace/sellerprofile')
                ->load($seller_id, 'seller_id');
        $this->setCollection($collection);
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/savecommission', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
                )
        );
        $fieldset = $form->addFieldset('set_commission', array('legend' => Mage::helper('marketplace')->__('Seller Commission')));
        $fieldset->addField('commission', 'text', array(
            'name' => 'commission',
            'title' => Mage::helper('marketplace')->__('Seller Commission(%)'),
            'label' => Mage::helper('marketplace')->__('Seller Commission(%)'),
            'required' => true,
            'class' => 'validate-number',
            'value' => $collection['commission']
        ));
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}


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
 * ProductsLike edit form tab
 *
 * @category    StarGenius
 * @package     StarGenius_ProductLikeCount
 * @author      Ultimate Module Creator
 */
class StarGenius_ProductLikeCount_Block_Adminhtml_Productslike_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return StarGenius_ProductLikeCount_Block_Adminhtml_Productslike_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('productslike_');
        $form->setFieldNameSuffix('productslike');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'productslike_form',
            array('legend' => Mage::helper('stargenius_productlikecount')->__('ProductsLike'))
        );

        $fieldset->addField(
            'product_id',
            'text',
            array(
                'label' => Mage::helper('stargenius_productlikecount')->__('Product ID'),
                'name'  => 'product_id',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'product_sku',
            'text',
            array(
                'label' => Mage::helper('stargenius_productlikecount')->__('Product SKU'),
                'name'  => 'product_sku',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'product_liked',
            'text',
            array(
                'label' => Mage::helper('stargenius_productlikecount')->__('Product Liked'),
                'name'  => 'product_liked',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'u_ipaddress',
            'text',
            array(
                'label' => Mage::helper('stargenius_productlikecount')->__('IP Address'),
                'name'  => 'u_ipaddress',
                'required'  => true,
                'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('stargenius_productlikecount')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('stargenius_productlikecount')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('stargenius_productlikecount')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('stargenius_productlikecount')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('stargenius_productlikecount')->__('Disabled'),
                    ),
                ),
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_productslike')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_productslike')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getProductslikeData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getProductslikeData());
            Mage::getSingleton('adminhtml/session')->setProductslikeData(null);
        } elseif (Mage::registry('current_productslike')) {
            $formValues = array_merge($formValues, Mage::registry('current_productslike')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}

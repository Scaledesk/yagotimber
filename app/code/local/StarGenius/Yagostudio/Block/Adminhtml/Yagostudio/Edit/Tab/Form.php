<?php
/**
 * StarGenius_Yagostudio extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_Yagostudio
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Yagostudio edit form tab
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('yagostudio_');
        $form->setFieldNameSuffix('yagostudio');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'yagostudio_form',
            array('legend' => Mage::helper('stargenius_yagostudio')->__('Yagostudio'))
        );
        $fieldset->addType(
            'image',
            Mage::getConfig()->getBlockClassName('stargenius_yagostudio/adminhtml_yagostudio_helper_image')
        );

        $fieldset->addField(
            'customer_email',
            'text',
            array(
                'label' => Mage::helper('stargenius_yagostudio')->__('Customer Email'),
                'name'  => 'customer_email',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'designer_name',
            'text',
            array(
                'label' => Mage::helper('stargenius_yagostudio')->__('Designer Name'),
                'name'  => 'designer_name',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'designer_email',
            'text',
            array(
                'label' => Mage::helper('stargenius_yagostudio')->__('Designer Email'),
                'name'  => 'designer_email',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'designer_mobile',
            'text',
            array(
                'label' => Mage::helper('stargenius_yagostudio')->__('Designer Mobile'),
                'name'  => 'designer_mobile',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'designer_address',
            'textarea',
            array(
                'label' => Mage::helper('stargenius_yagostudio')->__('Designer Address'),
                'name'  => 'designer_address',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'designer_photos',
            'image',
            array(
                'label' => Mage::helper('stargenius_yagostudio')->__('Designer Photos'),
                'name'  => 'designer_photos',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('stargenius_yagostudio')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('stargenius_yagostudio')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('stargenius_yagostudio')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('stargenius_yagostudio')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('stargenius_yagostudio')->__('Disabled'),
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
            Mage::registry('current_yagostudio')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $fieldset->addField(
            'allow_comment',
            'select',
            array(
                'label' => Mage::helper('stargenius_yagostudio')->__('Allow Comments'),
                'name'  => 'allow_comment',
                'values'=> Mage::getModel('stargenius_yagostudio/adminhtml_source_yesnodefault')->toOptionArray()
            )
        );
        $formValues = Mage::registry('current_yagostudio')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getYagostudioData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getYagostudioData());
            Mage::getSingleton('adminhtml/session')->setYagostudioData(null);
        } elseif (Mage::registry('current_yagostudio')) {
            $formValues = array_merge($formValues, Mage::registry('current_yagostudio')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}

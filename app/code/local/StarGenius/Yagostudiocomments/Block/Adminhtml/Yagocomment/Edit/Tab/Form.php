<?php
/**
 * StarGenius_Yagostudiocomments extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_Yagostudiocomments
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * YagoComment edit form tab
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudiocomments
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudiocomments_Block_Adminhtml_Yagocomment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return StarGenius_Yagostudiocomments_Block_Adminhtml_Yagocomment_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('yagocomment_');
        $form->setFieldNameSuffix('yagocomment');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'yagocomment_form',
            array('legend' => Mage::helper('stargenius_yagostudiocomments')->__('YagoComment'))
        );
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField(
            'customer_email',
            'text',
            array(
                'label' => Mage::helper('stargenius_yagostudiocomments')->__('Customer Email'),
                'name'  => 'customer_email',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'comment_heading',
            'text',
            array(
                'label' => Mage::helper('stargenius_yagostudiocomments')->__('Comment Heading'),
                'name'  => 'comment_heading',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'comment_content',
            'editor',
            array(
                'label' => Mage::helper('stargenius_yagostudiocomments')->__('Comment Content'),
                'name'  => 'comment_content',
            'config' => $wysiwygConfig,
                'required'  => true,
                'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('stargenius_yagostudiocomments')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('stargenius_yagostudiocomments')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('stargenius_yagostudiocomments')->__('Disabled'),
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
            Mage::registry('current_yagocomment')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_yagocomment')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getYagocommentData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getYagocommentData());
            Mage::getSingleton('adminhtml/session')->setYagocommentData(null);
        } elseif (Mage::registry('current_yagocomment')) {
            $formValues = array_merge($formValues, Mage::registry('current_yagocomment')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}

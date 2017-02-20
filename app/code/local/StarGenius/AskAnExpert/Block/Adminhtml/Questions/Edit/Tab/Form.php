<?php
/**
 * StarGenius_AskAnExpert extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       StarGenius
 * @package        StarGenius_AskAnExpert
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Question edit form tab
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author      Ultimate Module Creator
 */
class StarGenius_AskAnExpert_Block_Adminhtml_Questions_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return StarGenius_AskAnExpert_Block_Adminhtml_Questions_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('questions_');
        $form->setFieldNameSuffix('questions');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'questions_form',
            array('legend' => Mage::helper('stargenius_askanexpert')->__('Question'))
        );
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('stargenius_askanexpert')->__('Name'),
                'name'  => 'name',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'email',
            'text',
            array(
                'label' => Mage::helper('stargenius_askanexpert')->__('Email'),
                'name'  => 'email',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'questionasked',
            'editor',
            array(
                'label' => Mage::helper('stargenius_askanexpert')->__('Question Asked'),
                'name'  => 'questionasked',
            'config' => $wysiwygConfig,
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'expertreply',
            'editor',
            array(
                'label' => Mage::helper('stargenius_askanexpert')->__('Expert Reply'),
                'name'  => 'expertreply',
            'config' => $wysiwygConfig,
                'required'  => true,
                'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('stargenius_askanexpert')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('stargenius_askanexpert')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('stargenius_askanexpert')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('stargenius_askanexpert')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('stargenius_askanexpert')->__('Disabled'),
                    ),
                ),
            )
        );
        $fieldset->addField(
            'in_rss',
            'select',
            array(
                'label'  => Mage::helper('stargenius_askanexpert')->__('Show in rss'),
                'name'   => 'in_rss',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('stargenius_askanexpert')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('stargenius_askanexpert')->__('No'),
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
            Mage::registry('current_questions')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_questions')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getQuestionsData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getQuestionsData());
            Mage::getSingleton('adminhtml/session')->setQuestionsData(null);
        } elseif (Mage::registry('current_questions')) {
            $formValues = array_merge($formValues, Mage::registry('current_questions')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}

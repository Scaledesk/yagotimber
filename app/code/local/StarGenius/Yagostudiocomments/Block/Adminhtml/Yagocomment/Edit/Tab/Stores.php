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
 * store selection tab
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudiocomments
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudiocomments_Block_Adminhtml_Yagocomment_Edit_Tab_Stores extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return StarGenius_Yagostudiocomments_Block_Adminhtml_Yagocomment_Edit_Tab_Stores
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setFieldNameSuffix('yagocomment');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'yagocomment_stores_form',
            array('legend' => Mage::helper('stargenius_yagostudiocomments')->__('Store views'))
        );
        $field = $fieldset->addField(
            'store_id',
            'multiselect',
            array(
                'name'     => 'stores[]',
                'label'    => Mage::helper('stargenius_yagostudiocomments')->__('Store Views'),
                'title'    => Mage::helper('stargenius_yagostudiocomments')->__('Store Views'),
                'required' => true,
                'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            )
        );
        $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
        $field->setRenderer($renderer);
        $form->addValues(Mage::registry('current_yagocomment')->getData());
        return parent::_prepareForm();
    }
}

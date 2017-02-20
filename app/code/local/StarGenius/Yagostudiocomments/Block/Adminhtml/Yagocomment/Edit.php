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
 * YagoComment admin edit form
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudiocomments
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudiocomments_Block_Adminhtml_Yagocomment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'stargenius_yagostudiocomments';
        $this->_controller = 'adminhtml_yagocomment';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('stargenius_yagostudiocomments')->__('Save YagoComment')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('stargenius_yagostudiocomments')->__('Delete YagoComment')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('stargenius_yagostudiocomments')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_yagocomment') && Mage::registry('current_yagocomment')->getId()) {
            return Mage::helper('stargenius_yagostudiocomments')->__(
                "Edit YagoComment '%s'",
                $this->escapeHtml(Mage::registry('current_yagocomment')->getCustomerEmail())
            );
        } else {
            return Mage::helper('stargenius_yagostudiocomments')->__('Add YagoComment');
        }
    }
}

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
 * Yagostudio admin edit form
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudio
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudio_Block_Adminhtml_Yagostudio_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'stargenius_yagostudio';
        $this->_controller = 'adminhtml_yagostudio';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('stargenius_yagostudio')->__('Save Yagostudio')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('stargenius_yagostudio')->__('Delete Yagostudio')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('stargenius_yagostudio')->__('Save And Continue Edit'),
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
        if (Mage::registry('current_yagostudio') && Mage::registry('current_yagostudio')->getId()) {
            return Mage::helper('stargenius_yagostudio')->__(
                "Edit Yagostudio '%s'",
                $this->escapeHtml(Mage::registry('current_yagostudio')->getDesignerName())
            );
        } else {
            return Mage::helper('stargenius_yagostudio')->__('Add Yagostudio');
        }
    }
}

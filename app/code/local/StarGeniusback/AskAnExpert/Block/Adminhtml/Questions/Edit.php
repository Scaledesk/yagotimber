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
 * Question admin edit form
 *
 * @category    StarGenius
 * @package     StarGenius_AskAnExpert
 * @author      Ultimate Module Creator
 */
class StarGenius_AskAnExpert_Block_Adminhtml_Questions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'stargenius_askanexpert';
        $this->_controller = 'adminhtml_questions';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('stargenius_askanexpert')->__('Save Question')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('stargenius_askanexpert')->__('Delete Question')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('stargenius_askanexpert')->__('Save And Continue Edit'),
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
        if (Mage::registry('current_questions') && Mage::registry('current_questions')->getId()) {
            return Mage::helper('stargenius_askanexpert')->__(
                "Edit Question '%s'",
                $this->escapeHtml(Mage::registry('current_questions')->getName())
            );
        } else {
            return Mage::helper('stargenius_askanexpert')->__('Add Question');
        }
    }
}

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
 * YagoComment admin block
 *
 * @category    StarGenius
 * @package     StarGenius_Yagostudiocomments
 * @author      Ultimate Module Creator
 */
class StarGenius_Yagostudiocomments_Block_Adminhtml_Yagocomment extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_yagocomment';
        $this->_blockGroup         = 'stargenius_yagostudiocomments';
        parent::__construct();
        $this->_headerText         = Mage::helper('stargenius_yagostudiocomments')->__('YagoComment');
        $this->_updateButton('add', 'label', Mage::helper('stargenius_yagostudiocomments')->__('Add YagoComment'));

    }
}

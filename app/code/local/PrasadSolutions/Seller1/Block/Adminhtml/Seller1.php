<?php


class PrasadSolutions_Seller1_Block_Adminhtml_Seller1 extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_seller1";
	$this->_blockGroup = "seller1";
	$this->_headerText = Mage::helper("seller1")->__("Seller1 Manager");
	$this->_addButtonLabel = Mage::helper("seller1")->__("Add New Item");
	parent::__construct();
	
	}

}
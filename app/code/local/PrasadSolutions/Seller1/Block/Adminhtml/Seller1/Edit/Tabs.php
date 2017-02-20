<?php
class PrasadSolutions_Seller1_Block_Adminhtml_Seller1_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("seller1_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("seller1")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("seller1")->__("Item Information"),
				"title" => Mage::helper("seller1")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("seller1/adminhtml_seller1_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}

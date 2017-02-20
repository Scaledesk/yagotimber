<?php
	
class PrasadSolutions_Seller1_Block_Adminhtml_Seller1_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "seller1";
				$this->_controller = "adminhtml_seller1";
				$this->_updateButton("save", "label", Mage::helper("seller1")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("seller1")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("seller1")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("seller1_data") && Mage::registry("seller1_data")->getId() ){

				    return Mage::helper("seller1")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("seller1_data")->getId()));

				} 
				else{

				     return Mage::helper("seller1")->__("Add Item");

				}
		}
}
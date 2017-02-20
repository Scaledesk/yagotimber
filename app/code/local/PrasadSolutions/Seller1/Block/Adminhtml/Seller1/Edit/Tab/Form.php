<?php
class PrasadSolutions_Seller1_Block_Adminhtml_Seller1_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("seller1_form", array("legend"=>Mage::helper("seller1")->__("Item information")));

				
						$fieldset->addField("store_title", "text", array(
						"label" => Mage::helper("seller1")->__("Company Name"),
						"name" => "store_title",
						));
						
						$fieldset->addField("store_type", "text", array(
						"label" => Mage::helper("seller1")->__("Nature of Organisation"),
						"name" => "store_type",
						));
					
						
					
						$fieldset->addField("store_address", "text", array(
						"label" => Mage::helper("seller1")->__("Address of Registered office"),
						"name" => "store_address",
						));
					
						$fieldset->addField("store_address1", "text", array(
						"label" => Mage::helper("seller1")->__("Address of Shop"),
						"name" => "store_address1",
						));
					
						$fieldset->addField("store_pan", "text", array(
						"label" => Mage::helper("seller1")->__("company Pan Number"),
						"name" => "store_pan",
						));
						
						$fieldset->addField("store_vat", "text", array(
						"label" => Mage::helper("seller1")->__("Company VAT Number"),
						"name" => "store_vat",
						));
					
						$fieldset->addField("store_tin", "text", array(
						"label" => Mage::helper("seller1")->__("TIN Number"),
						"name" => "store_tin",
						));
						
						$fieldset->addField("store_cst", "text", array(
						"label" => Mage::helper("seller1")->__("CST Number"),
						"name" => "store_cst",
						));
						
						$fieldset->addField("Company_E-mail", "text", array(
						"label" => Mage::helper("seller1")->__("Company E-mail"),
						"name" => "Company_E-mail",
						));
						$fieldset->addField("store_owner", "text", array(
						"label" => Mage::helper("seller1")->__("Name of Director"),
						"name" => "store_owner",
						));
						$fieldset->addField("store_owneraddress", "text", array(
						"label" => Mage::helper("seller1")->__("Address details of director"),
						"name" => "store_owneraddress",
						));
						$fieldset->addField("din_num", "text", array(
						"label" => Mage::helper("seller1")->__("DIN number"),
						"name" => "din_num",
						));
						$fieldset->addField("store_cname", "text", array(
						"label" => Mage::helper("seller1")->__("Name of Contact Person "),
						"name" => "store_cname",
						));
						$fieldset->addField("store_cpos", "text", array(
						"label" => Mage::helper("seller1")->__("Designation"),
						"name" => "store_cpos",
						));
						$fieldset->addField("store_cladnumber", "text", array(
						"label" => Mage::helper("seller1")->__("Landline"),
						"name" => "store_cladnumber",
						));
						$fieldset->addField("store_cmob", "text", array(
						"label" => Mage::helper("seller1")->__("Mobile"),
						"name" => "store_cmob",
						));
						$fieldset->addField("store_cmail", "text", array(
						"label" => Mage::helper("seller1")->__("Email"),
						"name" => "store_cmail",
						));
						$fieldset->addField("store_bankdetails", "text", array(
						"label" => Mage::helper("seller1")->__("Bank detail"),
						"name" => "store_bankdetails",
						));
						$fieldset->addField("store_bankaddress", "text", array(
						"label" => Mage::helper("seller1")->__("Bank Address"),
						"name" => "store_bankaddress",
						));
						$fieldset->addField("account_name", "text", array(
						"label" => Mage::helper("seller1")->__("Account Name"),
						"name" => "account_name",
						));
						$fieldset->addField("account_number", "text", array(
						"label" => Mage::helper("seller1")->__("Account Number"),
						"name" => "account_number",
						));
						$fieldset->addField("store_bankatype", "text", array(
						"label" => Mage::helper("seller1")->__("Type of Account"),
						"name" => "store_bankatype",
						));
						$fieldset->addField("store_bankaifsc", "text", array(
						"label" => Mage::helper("seller1")->__("IFC code"),
						"name" => "store_bankaifsc",
						));
						$fieldset->addField("store_bankmicr", "text", array(
						"label" => Mage::helper("seller1")->__("MICR code"),
						"name" => "store_bankmicr",
						));
						$fieldset->addField("exported", "text", array(
						"label" => Mage::helper("seller1")->__("Have You"),
						"name" => "exported",
						));
						$fieldset->addField("exp_country", "text", array(
						"label" => Mage::helper("seller1")->__("If Yes"),
						"name" => "exp_country",
						));
						$fieldset->addField("iec_code", "text", array(
						"label" => Mage::helper("seller1")->__("IEC code"),
						"name" => "iec_code",
						));
						$fieldset->addField("userid", "text", array(
						"label" => Mage::helper("seller1")->__("UserId"),
						"name" => "userid",
						));
						$fieldset->addField("password", "text", array(
						"label" => Mage::helper("seller1")->__("Password"),
						"name" => "password",
						));
						
						$fieldset->addField("aprove", "text", array(
						"label" => Mage::helper("seller1")->__("Approve"),
						"name" => "aprove",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getSeller1Data())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getSeller1Data());
					Mage::getSingleton("adminhtml/session")->setSeller1Data(null);
				} 
				elseif(Mage::registry("seller1_data")) {
				    $form->setValues(Mage::registry("seller1_data")->getData());
				}
				return parent::_prepareForm();
				
				
				
		}
}



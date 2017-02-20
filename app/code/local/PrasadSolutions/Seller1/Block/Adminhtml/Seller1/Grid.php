<?php

class PrasadSolutions_Seller1_Block_Adminhtml_Seller1_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("seller1Grid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("seller1/seller1")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("seller1")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("store_title", array(
				"header" => Mage::helper("seller1")->__("Company Name"),
				"index" => "store_title",
				));
				$this->addColumn("store_type", array(
				"header" => Mage::helper("seller1")->__("service"),
				"index" => "store_type",
				));
				$this->addColumn("store_address", array(
				"header" => Mage::helper("seller1")->__("Address of Registered office"),
				"index" => "store_address",
				));
				$this->addColumn("store_address1", array(
				"header" => Mage::helper("seller1")->__("Address of Shop"),
				"index" => "store_address1",
				));
				$this->addColumn("store_pan", array(
				"header" => Mage::helper("seller1")->__("company Pan Number "),
				"index" => "store_pan",
				));
				$this->addColumn("store_tin", array(
				"header" => Mage::helper("seller1")->__("Tin Num"),
				"index" => "store_tin",
				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_seller1', array(
					 'label'=> Mage::helper('seller1')->__('Remove Seller1'),
					 'url'  => $this->getUrl('*/adminhtml_seller1/massRemove'),
					 'confirm' => Mage::helper('seller1')->__('Are you sure?')
				));
			return $this;
		}
			

}
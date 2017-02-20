<?php 

class Netsolutions_Checkdelivery_Adminhtml_ExportcsvController extends Mage_Adminhtml_Controller_Action {
	
/**initiate the database (table name and 
	 * the checkdelivery id(primery key)) **/	

	public function exportdataAction(){
		//specify csv name
		$fileName       = 'manifest_upload_'.Mage::getSingleton('core/date')->date('d-m-Y_H-i-s').'_csv.csv';
		
		//$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		//get product collections
		$_productCollection = Mage::getModel('catalog/product')
                        ->getCollection()
                        ->addAttributeToSort('created_at', 'DESC')
                        ->addAttributeToSelect('*')
                        ->load();
			 //call checkdelivery collections          
				$zipcollections = Mage::getModel('checkdelivery/checkdelivery')->getCollection();
			
		 
			$csv = '';
			$_columns = array(
				"sku",
				"zip_code",
				"zip_codeto",
				"message",
			);
			
			$data = array();
			foreach ($_columns as $column) 
				{
					$data[] = '"'.$column.'"';
				}
				$csv .= implode(',', $data)."\n";
			$WithVal = array();
			foreach($zipcollections as $row){
			
				$data = array();
				$data[] = $row->getData('sku');
				$data[] = $row->getData('zipcode');
				$data[] = $row->getData('zipcodeto');
				$data[] = $row->getData('message');
				$csv .= implode(',', $data)."\n";
				if(!in_array($row->getData('sku'), $WithVal)){
					
					$WithVal[]=$row->getData('sku');
					
				}
			}
			
			foreach($_productCollection as $products){
				if(!in_array($products->getId(), $WithVal)){
				$data = array();
				$data[] = $products->getSku();
				//$data[] = $products['zipcode'];
				$csv .= implode(',', $data)."\n";
				}
			}
			//to prepare csv file to be downloadble
			$this->_prepareDownloadResponse($fileName, $csv); 
		   
	}
	
}

?>

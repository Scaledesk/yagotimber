<?php
class Netsolutions_Checkdelivery_Model_Mysql4_Checkdelivery extends Mage_Core_Model_Resource_Db_Abstract{
	
	/**initiate the database (table name and 
	 * the checkdelivery id(primery key)) **/	
	protected function _construct()
    {
        $this->_init('checkdelivery/checkdelivery', 'checkdelivery_id');
    }
    
   /**
     * Upload checkdelivery file and import data from it
     *
     * @param Varien_Object $object
     * @throws Mage_Core_Exception
     * @return Netsolutions_Checkdelivery_Model_Mysql4_Checkdelivery
     */
   public function uploadAndImport(Varien_Object $object){
	   
	   if(empty($_FILES['groups']['tmp_name']['nsi_csv_grp']['fields']['import']['value'])){
		   return $this;
	   }
	  $csvFile = $_FILES['groups']['tmp_name']['nsi_csv_grp']['fields']['import']['value']; 
	   
	   $this->_importErrors        = array();
	   
       $this->_importedRows        = 0;
       
	   $io = new Varien_Io_File();
	   
	   $info = pathinfo($csvFile);
	   
	   $io->open(array('path'=>$info['dirname']));
	   
	   $io->streamOpen($info['basename'],'r');
	   
	   // check and skip headers
	   $headers = $io->streamReadCsv(); 
	   
	   if($headers === false || count($headers) < 2){ 
		   $io->streamClose();
		   Mage::throwException(Mage::Helper('checkdelivery')->__('Invalid Check delivery CSV File Format'));
	   }
	   

        $adapter = $this->_getWriteAdapter();
        $adapter->beginTransaction();

        try {
            $rowNumber  = 1;
            $importData = array();

            
            while (false !== ($csvLine = $io->streamReadCsv())) {
                $rowNumber ++;

                if (empty($csvLine)) {
                    continue;
                }

                $row = $this->_getImportRow($csvLine, $rowNumber);
                if ($row !== false) {
                    $importData[] = $row;
                }

                if (count($importData) == 5000) {
                    $this->_saveImportData($importData);
                    $importData = array();
                }
            }
            $this->_saveImportData($importData);
            $io->streamClose();
        } catch (Mage_Core_Exception $e) {
            $adapter->rollback();
            $io->streamClose();
            Mage::throwException($e->getMessage());
        } catch (Exception $e) {
            $adapter->rollback();
            $io->streamClose();
            Mage::logException($e);
            Mage::throwException(Mage::helper('checkdelivery')->__('An error occurred while import zip code csv.'));
        }

        $adapter->commit();

        if ($this->_importErrors) {
            $error = Mage::helper('checkdelivery')->__('CSV has not been imported. See the following list of errors: %s', implode(" \n", $this->_importErrors));
            Mage::throwException($error);
        }

	    return $this;
   }
       
    /**
     * Validate row for import and return check delivery array or false
     * Error will be add to _importErrors array
     *
     * @param array $row
     * @param int $rowNumber
     * @return array|false
     */
    protected function _getImportRow($row, $rowNumber = 0)
    {
        // validate row
        if (count($row) < 1) {
            $this->_importErrors[] = Mage::helper('checkdelivery')->__('Invalid CSV file format in the Row #%s', $rowNumber);
            return false;
        }

        // strip whitespace from the beginning and end of each row
        foreach ($row as $k => $v) {
            $row[$k] = trim($v);
        }

     
		if($row[0] != ''){
			$sku = $row[0];
		}
		
		if($row[2] != ''){
			$zipcodeto = $row[2];
		}

if($row[3] != ''){
			$message = $row[3];
		}
        // detect zip code
        if ($row[1] == '*') {
            $zipCode = '*';
        } 
        else if($row[1] == ''){
			$zipCode = '';
		}
        else {
            $zipCode = $row[1];
        }

    
        return array(
            $sku,                 // sku
            $zipCode,
			 $zipcodeto,
			$message,             // zipcode
        );
    }
    
      /**
     * Save import data batch
     *
     * @param array $data
     * @return Netsolutions_Checkdelivery_Model_Mysql4_Checkdelivery
     */
    protected function _saveImportData(array $data)
    {
        if (!empty($data)) {
			$data = array_unique($data, SORT_REGULAR);
				
			 $columns = array('sku','zipcode','zipcodeto','message');
            $this->_getWriteAdapter()->insertArray($this->getMainTable(), $columns, $data);
            $this->_importedRows += count($data);
             }
	
        return $this;
    }
}

<?php

class Netsolutions_Checkdelivery_Model_Csv extends Mage_Core_Model_Config_Data{
	
	public function save(){ 
        Mage::getResourceModel('checkdelivery/checkdelivery')->uploadAndImport($this);
    }

}

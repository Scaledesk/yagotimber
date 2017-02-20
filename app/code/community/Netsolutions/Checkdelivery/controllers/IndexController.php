<?php

/*check zip code avaibelity from db and return the response*/

class Netsolutions_Checkdelivery_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction() {
		/*get checkdelivery store config data */
		$zip = $this->getRequest()->getParam('zipcode');
		$sku = $this->getRequest()->getParam('sku');
		$success = Mage::getStoreConfig('checkdelivery/nsi_general_grp/success_messgae');
		$failure = Mage::getStoreConfig('checkdelivery/nsi_general_grp/failure_messgae');
		$empty = Mage::getStoreConfig('checkdelivery/nsi_general_grp/empty_messgae');
		$actionType = Mage::getStoreConfig('checkdelivery/nsi_general_grp/dropdown');
		$fedExLicenceKey = Mage::getStoreConfig('checkdelivery/nsi_fedex_api_grp/fedex_licence');
		$fedExAccountNo = Mage::getStoreConfig('checkdelivery/nsi_fedex_api_grp/fedex_accountno');
		$fedExPassword = Mage::getStoreConfig('checkdelivery/nsi_fedex_api_grp/fedex_password');
		$fedExMeter = Mage::getStoreConfig('checkdelivery/nsi_fedex_api_grp/fedex_meter');
		$allowedCountryType = Mage::getStoreConfig('checkdelivery/nsi_fedex_api_grp/sallowspecific');
		$allowedCountryName = Mage::getStoreConfig('checkdelivery/nsi_fedex_api_grp/specificcountry');
		$enableApi = Mage::getStoreConfig('checkdelivery/nsi_fedex_api_grp/active');
		$enableCSV = Mage::getStoreConfig('checkdelivery/nsi_csv_grp/active');
		$countryCodeArray = explode(",", $allowedCountryName);
		/*get zip code using API code*/
		
		
	
	/**start csv code*/
	
		 if($zip){
			
			
			$collections_ashu = Mage::getModel('checkdelivery/checkdelivery')->getCollection()
			  ->addFieldToFilter('sku',$sku)
		->load();
				
			foreach($collections_ashu as $data_ashu){
				$zipcode = $data_ashu->getData('zipcode');
				$zipcodeto = $data_ashu->getData('zipcodeto');
				if($zip >= $zipcode  && $zip <= $zipcodeto) {
				$message_ashu = $data_ashu->getData('message');
				}
			 
			}
			if($message_ashu) {
				$response['message'] = $message_ashu;
				$response['color'] = 'green';
			}
			else {
			$response['message'] = $failure;
			$response['color'] = 'red';
			}
						
			
		 }
				else{
				$response['message'] = $empty;
				$response['color'] = 'orange';
				}
				echo json_encode($response);
				Mage::log($response);
			}
			
					
			
		
			
	
    }
			
	

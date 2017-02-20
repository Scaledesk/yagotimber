<?php
class Stargenius_Countryrestriction_Model_Onepage extends Mage_Checkout_Model_Type_Onepage
{



    

    public function saveShippingMethod($shippingMethod)
    {
		  
		   $quote = $this->getQuote();
	 $pin_code = $quote->getShippingAddress()->getPostcode();
	
	
	  foreach ($quote->getAllItems() as $item) {
        $product = Mage::getModel('catalog/product')->load($item->getProductId());
				$get_sku =  $product->getSku();
			 $Error_Message = 'The Product with'.$get_sku.' is not avaiable for your location.';	
	$collections_ashu = Mage::getModel('checkdelivery/checkdelivery')->getCollection()
			->addFieldToFilter('zipcode',$pin_code)
	       ->addFieldToFilter('sku',$get_sku)
		->load();
				
			foreach($collections_ashu as $data_ashu){
				$message_ashu = $data_ashu->getData('message');
				$message_pin = $data_ashu->getData('zipcode');
			 
			}
			
			if(empty($message_pin))
			
	     {
			 
			 Mage::getSingleton('core/session')->addNotice('Notice message');
			  Mage::getSingleton('checkout/session')->addError($Error_Message);
		                Mage::throwException($Error_Message);
		                exit();
                   
	          
		 }
				
	  }
     
	
	
	 
    	return parent::saveShippingMethod($shippingMethod);
    }
}
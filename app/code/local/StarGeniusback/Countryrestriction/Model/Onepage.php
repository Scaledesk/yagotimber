<?php
class StarGenius_Countryrestriction_Model_Onepage extends Mage_Checkout_Model_Type_Onepage
{



    

    public function saveShippingMethod($shippingMethod)
    {
		  
		   $quote = $this->getQuote();
	 $pin_code = $quote->getShippingAddress()->getPostcode();
	
	
	  foreach ($quote->getAllItems() as $item) {
        $product = Mage::getModel('catalog/product')->load($item->getProductId());
				$get_sku =  $product->getSku();
				
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
			 $get_title =  $product->getName();
			 $Error_Message = 'The Product with '.$get_title.'  is not avaiable for your location.';	
			 
			
			  Mage::getSingleton('checkout/session')->addError($Error_Message);
		                Mage::throwException($Error_Message);
		                exit();
                   
	          
		 }
				
	  }
     
	
	
	 
    	return parent::saveShippingMethod($shippingMethod);
    }
}
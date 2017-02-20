<?php
class StarGenius_Countryrestriction_Model_Onepage extends Mage_Checkout_Model_Type_Onepage
{



    

    public function saveShippingMethod($shippingMethod)
    {
		 
		   $quote = $this->getQuote();
	 $pin_code = $quote->getShippingAddress()->getPostcode();
	
	$restrict =1;
	  foreach ($quote->getAllItems() as $item) {
        $product = Mage::getModel('catalog/product')->load($item->getProductId());
				$get_sku =  $product->getSku();
				
	$collections_ashu = Mage::getModel('checkdelivery/checkdelivery')->getCollection()
			 ->addFieldToFilter('sku',$get_sku)
	       		->load();
				
	
			
				foreach($collections_ashu as $data_ashu){
				$zipcode = $data_ashu->getData('zipcode');
				$zipcodeto = $data_ashu->getData('zipcodeto');
				
		if($pin_code >= $zipcode  && $pin_code <= $zipcodeto) {
				$restrict = 0;
				}
			 
			}
			
			
		if($restrict == 1)
			
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
<?php
class StarGenius_CustomUpFront_Model_Observer 
{
    public function saveCustomData($evt)
    {
        $quote = $evt->getQuote();
        $var = Mage::app()->getRequest()->getParam('payashu');
      
            $quote->setUpfrontPaymentField($var);
         
       
       
        return $this;
    }
	 public function logUpdate( $observer)
    {
       
	  
	
	
    }
}
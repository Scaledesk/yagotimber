<?php 

class Netsolutions_Checkdelivery_Model_System_Config_Source_Dropdown_Values
{
   public function toOptionArray()
    {
        return array(
            array(
                'value' => 'csv',
                'label' => 'Using CSV',
            ),
            array(
                'value' => 'api',
                'label' => 'Using API',
            ),
        );
    }

}
?>

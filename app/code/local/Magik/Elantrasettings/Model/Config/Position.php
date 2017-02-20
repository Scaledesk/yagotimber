<?php


class Magik_Elantrasettings_Model_Config_Position
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'top-left',
	            'label' => Mage::helper('elantrasettings')->__('Top Left')),
            array(
	            'value'=>'top-right',
	            'label' => Mage::helper('elantrasettings')->__('Top Right')),                       

        );
    }

}

<?php


class Magik_Elantrasettings_Model_Config_Width
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value' => 'flexible',
	            'label' => Mage::helper('elantrasettings')->__('flexible')),
            array(
	            'value' => 'fixed',
	            'label' => Mage::helper('elantrasettings')->__('fixed')),
        );
    }

}

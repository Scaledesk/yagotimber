<?php


class Magik_Elantrasettings_Model_Config_Footer
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'simple',
	            'label' => Mage::helper('elantrasettings')->__('simple')),
            array(
	            'value'=>'informative',
	            'label' => Mage::helper('elantrasettings')->__('informative')),
        );
    }

}

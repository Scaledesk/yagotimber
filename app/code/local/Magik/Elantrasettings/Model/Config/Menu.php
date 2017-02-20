<?php


class Magik_Elantrasettings_Model_Config_Menu
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'classic-menu',
	            'label' => Mage::helper('elantrasettings')->__('Classic Menu')),
            array(
	            'value'=>'mega-menu',
	            'label' => Mage::helper('elantrasettings')->__('Mega Menu')),                       

        );
    }

}

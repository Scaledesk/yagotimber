<?php


class Magik_Elantrasettings_Model_Config_Sidebarmenu
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'sidebar-classic-menu',
	            'label' => Mage::helper('elantrasettings')->__('Sidebar Classic Menu')),
            array(
	            'value'=>'sidebar-mega-menu',
	            'label' => Mage::helper('elantrasettings')->__('Sidebar Mega Menu')),                       

        );
    }

}

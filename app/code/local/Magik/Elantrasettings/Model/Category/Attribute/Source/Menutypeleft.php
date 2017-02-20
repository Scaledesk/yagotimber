<?php
class Magik_Elantrasettings_Model_Category_Attribute_Source_Menutypeleft
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{	
	protected $_options;
    
	public function getAllOptions()
	{
        return array(
            array('value' => 'noimage', 'label' => Mage::helper('elantrasettings')->__('No Image')),
            array('value' => 'leftimage', 'label' => Mage::helper('elantrasettings')->__('Left Side Image')),
            array('value' => 'leftimagetxt', 'label' => Mage::helper('elantrasettings')->__('Left Side Image With Text')),
            array('value' => 'bottomimage', 'label' => Mage::helper('elantrasettings')->__('Bottom Side Image'))
        );
    }
}

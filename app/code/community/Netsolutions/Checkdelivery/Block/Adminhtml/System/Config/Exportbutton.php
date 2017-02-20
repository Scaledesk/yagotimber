<?php 
class Netsolutions_Checkdelivery_Block_Adminhtml_System_Config_Exportbutton extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
		
        $this->setElement($element);
        //$url = $this->getUrl('checkdelivery_catalog/product'); //
		$url = Mage::helper("adminhtml")->getUrl("checkdelivery/adminhtml_exportcsv/exportdata");
        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('scalable')
                    ->setLabel('Export csv !')
                    ->setOnClick("setLocation('$url')")
                    ->toHtml();

        return $html;
    }
}
?>


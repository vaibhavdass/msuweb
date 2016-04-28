<?php 
class Pwa_Paywithamazon_Block_Button extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {

        $this->setElement($element);
        $url = $this->getUrl('paywithamazon/process/chcekprocess'); 
        $configValue = Mage::getStoreConfig('paywithamazon/install/pwa_install');
        $check = Mage::getModel('paywithamazon/check')->checkinstall();
        if($check==0){
        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('scalable')
                    ->setLabel('Check')
                    ->setOnClick("alert('Please Reinstall the plugin')")
                    ->toHtml();
        }
        else {
            $html = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('scalable')
                    ->setLabel('Check')
                    ->setOnClick("alert('Plugin is successfully installed')")
                    ->toHtml();
        }

        return $html;
    }

   
}
?>

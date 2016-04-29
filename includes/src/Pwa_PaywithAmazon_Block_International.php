<?php
class Pwa_PaywithAmazon_Block_International extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $_addRowButtonHtml = array();
    protected $_removeRowButtonHtml = array();
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {   

        $rowIndex = 0;
        $this->setElement($element);
        $html = '<div id="merchant_allowed_methods_template" style="display:none;">';
        $html .= $this->_getRowTemplateHtmlPre();
        $html .= '</div>';
        $module_disable = 'style=display:none;';
        if(Mage::getStoreConfig('paywithamazon/amazon_shipping_option/enable_shipping_override')){
            $module_disable = 'style=display:block;';
        }
        $html .= '<div '.$module_disable.' id="custom_international_module" >';
        $html .= '<ul   id="merchant_allowed_methods_container" style="margin-top:30px;">';

        $flag = 0;
        if ($this->_getValue('service_level')) {
            foreach ($this->_getValue('service_level') as $i => $f) {
                if ($i) {
                    $html .= $this->_getRowTemplateHtml($i);
                    $rowIndex =  $i;
                    $flag = 1;
                }
            }
            //$html .= "<script type='text/javascript'>var rowIndex = $rowIndex;</script>";
        }
        $html .= '</ul>';
        $html .= $this->_getAddRowButtonHtml('merchant_allowed_methods_container',
            'merchant_allowed_methods_template', $this->__('Add New SLO Setting'));
        $html .= '</div>';
        if($flag){
            $html .= '<script type="text/javascript"> flag = 1; </script>';
        }
        else{
            $html .= '<script type="text/javascript"> flag = 0; </script>';
        }

        
        $html .=        '<style>
                            #row_paywithamazon_amazon_shipping_option_international_shipping_method {position: relative;}
                            #merchant_allowed_methods_container div {margin: 20px 0;}
                            #row_paywithamazon_amazon_shipping_option_international_shipping_method .scope-label{display:none;}
                            #merchant_allowed_methods_container > li:first-child button {display: none;}
                            #merchant_allowed_methods_container #excluded_region_div_1 {display: none;}
                            }
                        </style>
                        <script type="text/javascript">

                            function myfunction(template){

                                var rowIndex = parseInt($(\'merchant_allowed_methods_container\').select(\'li\').length) +1;
                                if(rowIndex == 10){
                                    alert("Soory! You Can\'t add more option");
                                    return null;
                                }
                                str = $(template).innerHTML;
                                var re = new RegExp(\'counter\', \'g\');
                                str = str.replace(re, rowIndex); 
                                str = str.replace("input-text price", "input-text required-entry  validate-number"); 
                                str = str.replace("input-text delivery_time_minimum", "input-text  required-entry  validate-number validate-digits validate-digits-range digits-range-1-999"); 
                                str = str.replace("input-text delivery_time_maximum", "input-text  required-entry  validate-number validate-digits validate-digits-range digits-range-1-999"); 
                                str = str.replace("input-text included_region", "input-text required-entry"); 
                                return str;
                            }
                            
                            attrValue = document.getElementsByClassName(\'save\')[0].attributes.getNamedItem(\'onclick\') ; 
                            attrValue.value = \'clearValue();\'+attrValue.value ;
                            document.getElementsByClassName(\'save\')[0].attributes.setNamedItem(attrValue) ;


                            function clearValue(){
                                errorHtml_span = $(\'row_paywithamazon_amazon_shipping_option_international_shipping_method\').select(\'span.validation-advice\');
                               
                                    for (i=0; i < errorHtml_span.length; i++) 
                                    {   
                                        
                                        errorHtml_span[i].removeClassName(\'validation-advice\');
                                        errorHtml_span[i].innerHTML = null;
                                    }
                                
                            }
                            function valCustom(){                               
                                errorHtml = $(\'row_paywithamazon_amazon_shipping_option_international_shipping_method\').select(\'div.validation-advice\');

                                errorHtml_span = $(\'row_paywithamazon_amazon_shipping_option_international_shipping_method\').select(\'span.validation-advice\');
                                if(errorHtml.length != 0){
                                    for (i=0; i < errorHtml_span.length; i++) 
                                    {   
                                        
                                        errorHtml_span[i].removeClassName(\'validation-advice\');
                                        errorHtml_span[i].innerHTML = null;
                                    }
                                }
                                for (i=0; i < errorHtml.length; i++) 
                                {   str = errorHtml[i].id;  
                                    str = str.split("-");
                                    //alert(\'error_\'+str[str.length-1]);  
                                    document.getElementById(\'error_\'+str[str.length-1]).innerHTML = errorHtml[i].innerHTML;
                                    document.getElementById(\'error_\'+str[str.length-1]).className = \'validation-advice\';
                                    errorHtml[i].remove();
                                }
                            }
                            function showExcludedRegion(o,counter){
                                if(o.value == "WORLDALL"){
                                    document.getElementById(\'excluded_region_div_\'+counter).style.display = \'block\';
                                }
                                else{
                                    document.getElementById(\'excluded_region_div_\'+counter).style.display = \'none\';
                                }
                            }
                            function shippingRate(o,counter){
                                if(o.value == "ItemQuantityBased+ShipmentBased" || o.value == "WeightBased+ShipmentBased"){
                                    document.getElementById(\'div_shipping_selector_\'+counter).style.display = \'block\';
                                }
                                else{
                                    document.getElementById(\'div_shipping_selector_\'+counter).style.display = \'none\';
                                }

                            }
                            function dependentOption(){
                                enable_shipping_override = document.getElementById(\'paywithamazon_amazon_shipping_option_enable_shipping_override\');
                                reflatId = document.getElementById(\'custom_international_module\');
                                if(enable_shipping_override.value == 1){
                                    reflatId.style.display = "block";
                                    if(parseInt($(\'merchant_allowed_methods_container\').select(\'li\').length) == 0){
                                        document.getElementById(\'add_random\').click();
                                    }
                                }
                                else{
                                    if(flag == 0){
                                        document.getElementById(\'merchant_allowed_methods_container\').firstChild.remove() ;
                                    }
                                    reflatId.style.display = "none";

                                }
                                firstRegion();
                            }                            
                            document.getElementById(\'paywithamazon_amazon_shipping_option_enable_shipping_override\').addEventListener("change", function(){
                                 dependentOption();
                            });

                            setInterval(valCustom,500);
                            function firstRegion(){
                                if(document.getElementById("included_region_1")){
                                    var my_id = document.getElementById("included_region_1");
                                    if(!document.getElementById("first_include_region")){
                                        var span = document.createElement("span");
                                            span.innerHTML = "India";
                                            span.id = "first_include_region";
                                        my_id.parentNode.insertBefore(span, my_id);
                                    }
                                    my_id.style.display = "none";
                                    my_id.value = "IN";
                                    my_id.nextSibling.style.display = "none";
                                }
                            }
                            firstRegion();

                        </script>
                       ';
       
        return $html;
    }
    /**
     * Retrieve html template for shipping method row
     *
     * @param int $rowIndex
     * @return string
     */
    protected function _getRowTemplateHtml($rowIndex = 0)
    {    

        $html = '<li style="margin-bottom: 30px;">';
        //$html = '<table class="data border"><tr>';
        //Shipping Label
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Shipping Label </label>';         

        $html .= '<input  id="shipping_label_'.$rowIndex.'"   class="input-text "     name="'
            . $this->getElement()->getName() . '[shipping_label][]" value="'
            . $this->_getValue('shipping_label/' . $rowIndex) . '" ' . $this->_getDisabled() . '/>
            <p class="note"><span>The description or abbreviation for the shipment method.For example,FEDEX</span></p><span id="error_shipping_label_'.$rowIndex.'"></span></div> ';


        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Service Level </label>';
         
        $html .= '<select id="service_level_'.$rowIndex.'" name="' . $this->getElement()->getName() . '[service_level][]" ' . $this->_getDisabled() . '>';
        $html .= '<option value="">' . $this->__('Select Service Level') . '</option>';
        
            foreach ($this->getServiceLevel() as $methodCode => $method) {
                $code = $methodCode;
                $html .= '<option value="' . $this->escapeHtml($code) . '" '
                    . $this->_getSelected('service_level/' . $rowIndex, $code)
                    . ' style="background:white;">' . $this->escapeHtml($method) . '</option>';

        }
        $html .= '</select><span id="error_service_level_'.$rowIndex.'"></span></div>';
        //Shipping Rate
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Shipping Rate </label>';
         
        $html .= '<select onchange="shippingRate(this,'.$rowIndex.')" id="shipping_rate_'.$rowIndex.'"  name="' . $this->getElement()->getName() . '[shipping_rate][]" ' . $this->_getDisabled() . '>';
        $html .= '<option value="">' . $this->__('Select Shipping Rate') . '</option>';
        
            foreach ($this->getShippingRate() as $methodCode => $method) {
                $code = $methodCode;
                $html .= '<option value="' . $this->escapeHtml($code) . '" '
                    . $this->_getSelected('shipping_rate/' . $rowIndex, $code)
                    . ' style="background:white;">' . $this->escapeHtml($method) . '</option>';
                    
        }
        $html .= '</select><span id="error_shipping_rate_'.$rowIndex.'"></span></div>';
        //Price
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Price </label>';         

        $html .= '<input  id="price_'.$rowIndex.'"   class="input-text required-entry  validate-number"     name="'
            . $this->getElement()->getName() . '[price][]" value="'
            . $this->_getValue('price/' . $rowIndex) . '" ' . $this->_getDisabled() . '/><span id="error_price_'.$rowIndex.'"></span></div> ';
        $htmlshipping_selector = '';
        $htmlshipping_selector .= '<div style="position:relative;"><label style="position: absolute; left: -205px;">Shipment Based Rate</label>';         

        $htmlshipping_selector .= '<input  id="shipping_price_'.$rowIndex.'"   class="input-text "     name="'
            . $this->getElement()->getName() . '[shipping_price][]" value="'
            . $this->_getValue('shipping_price/' . $rowIndex) . '" ' . $this->_getDisabled() . '/><span id="error_shipping_price_'.$rowIndex.'"></span></div> ';
        $shipmentRateClass = 'style="display:none;"';    
        if($this->_getValue('shipping_rate/' . $rowIndex) == "ItemQuantityBased+ShipmentBased" || $this->_getValue('shipping_rate/' . $rowIndex) == "WeightBased+ShipmentBased"){ 
            $shipmentRateClass = 'style="display:block;"';
        }
        $html .= '<div  '.$shipmentRateClass.' id="div_shipping_selector_'.$rowIndex.'">'.$htmlshipping_selector.'</div>';
        //Delivery Time Minimum
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Delivery Time Minimum </label>';         

        $html .= '<input   id="delivery_time_minimum_'.$rowIndex.'"   class="input-text required-entry  validate-number validate-digits validate-digits-range digits-range-1-999"  name="'
            . $this->getElement()->getName() . '[delivery_time_minimum][]" value="'
            . $this->_getValue('delivery_time_minimum/' . $rowIndex) . '" ' . $this->_getDisabled() . '/> 
            <p class="note"><span >Please Enter Value In Days for Delivery Minimum Time</span></p>
            <span id="error_delivery_time_minimum_'.$rowIndex.'"></span></div>';
        // Delivery Time Maximum
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Delivery Time Maximum </label>';
         
        $html .= '<input   id="delivery_time_maximum_'.$rowIndex.'"  class=" input-text required-entry  validate-number validate-digits validate-digits-range digits-range-1-999"   name="'
            . $this->getElement()->getName() . '[delivery_time_maximum][]" value="'
            . $this->_getValue('delivery_time_maximum/' . $rowIndex) . '" ' . $this->_getDisabled() . '/>
            <p class="note"><span >Please Enter Value In Days for Delivery Maximum Time</span></p>
            <span id="error_delivery_time_maximum_'.$rowIndex.'"></span></div> ';
        // included 
        $html .= '<div style="position:relative;" ><label style="position: absolute; left: -205px;"> Included Region </label>';
         
        $html .= '<select onchange="showExcludedRegion(this,'.$rowIndex.')" id="included_region_'.$rowIndex.'" class="input-text required-entry" name="' . $this->getElement()->getName() . '[included_region][]" ' . $this->_getDisabled() . '>';
        $html .= '<option value="">' . $this->__('Select Included Region') . '</option>';
        
            foreach ($this->getCountry() as $methodCode => $method) {
                $code = $methodCode;
                $html .= '<option value="' . $this->escapeHtml($code) . '" '
                    . $this->_getSelected('included_region/' . $rowIndex, $code)
                    . ' style="background:white;">' . $this->escapeHtml($method) . '</option>';

        }
        $html .= '</select><p class="note"><span>Select the regions you will  ship to</span></p><span id="error_included_region_'.$rowIndex.'"></span></div>'; 

        $excludeClass = 'display:none;';    
        if($this->_getValue('included_region/' . $rowIndex) == "WORLDALL" ){ 
            $excludeClass = 'display:block;';
        }

        $html .= '<div style="position:relative;'.$excludeClass.'"   id="excluded_region_div_'.$rowIndex.'"><label style="position: absolute; left: -205px;"> Excluded Region </label>';
         
        $html .= '<select id="excluded_region_'.$rowIndex.'" name="' . $this->getElement()->getName() . '[excluded_region][]" ' . $this->_getDisabled() . '>';
        $html .= '<option value="">' . $this->__('Select Excluded Region') . '</option>';
        
            foreach ($this->getCountry() as $methodCode => $method) {
                $code = $methodCode;
                $html .= '<option value="' . $this->escapeHtml($code) . '" '
                    . $this->_getSelected('excluded_region/' . $rowIndex, $code)
                    . ' style="background:white;">' . $this->escapeHtml($method) . '</option>';

        }
        $html .= '</select><p class="note"><span>Select the regions you will not ship to</span></p><span id="error_excluded_region_'.$rowIndex.'"></span></div>';
        if($rowIndex != 1) {
            // Delete
            $html .= '<div>'.$this->_getRemoveRowButtonHtml().'</div> ';
        }

        //$html .= '</tr></table>';
        $html .= '</li>';
        return $html;
    }
    protected function _getRowTemplateHtmlPre($rowIndex = 0)
    {   
        $html = '<li style="margin-bottom: 30px;">';
        //$html = '<table class="data border"><tr>';
        //Shipping Label
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Shipping Label </label>';         

        $html .= '<input  id="shipping_label_counter"   class="input-text "     name="'
            . $this->getElement()->getName() . '[shipping_label][]"  />
            <p class="note"><span>The description or abbreviation for the shipment method.For example,FEDEX</span></p>
            <span id="error_shipping_label_counter"></span></div> ';

        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Service Level </label>';
         
        $html .= '<select  id="service_level_counter"   name="' . $this->getElement()->getName() . '[service_level][]" ' . $this->_getDisabled() . '>';
        $html .= '<option value="">' . $this->__('Select Service Level') . '</option>';
        
            foreach ($this->getServiceLevel() as $methodCode => $method) {
                $code = $methodCode;
                $html .= '<option value="' . $this->escapeHtml($code) . '" '
                    . ' style="background:white;">' . $this->escapeHtml($method) . '</option>';

        }
        $html .= '</select><span id="error_service_level_counter"></span></div>';
        //Shipping Rate
         
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Shipping Rate </label>';
         
        $html .= '<select onchange="shippingRate(this,counter)" id="shipping_rate_counter"  name="' . $this->getElement()->getName() . '[shipping_rate][]" ' . $this->_getDisabled() . '>';
        $html .= '<option value="">' . $this->__('Select Shipping Rate') . '</option>';
        
            foreach ($this->getShippingRate() as $methodCode => $method) {
                $code = $methodCode;
                $html .= '<option value="' . $this->escapeHtml($code) . '" '
                    . ' style="background:white;">' . $this->escapeHtml($method) . '</option>';
                    
        }
        $html .= '</select><span id="error_shipping_rate_counter"></span></div>';
       
        //Price
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Price </label>';         

        $html .= '<input id="price_counter"   class="input-text price"   name="'
            . $this->getElement()->getName() . '[price][]"  /><span id="error_price_counter"></span></div> ';
        

        $htmlshipping_selector = '';
        $htmlshipping_selector .= '<div style="position:relative;"><label style="position: absolute; left: -205px;">Shipment Based Rate</label>';         

        $htmlshipping_selector .= '<input  id="shipping_price_counter"   class="input-text shipping_price"     name="'
            . $this->getElement()->getName() . '[shipping_price][]" /><span id="error_shipping_price_counter"></span></div> ';
        $html .= '<div style="display:none;" id="div_shipping_selector_counter">'.$htmlshipping_selector.'</div>';
        //Delivery Time Minimum
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Delivery Time Minimum </label>';         

        $html .= '<input  id="delivery_time_minimum_counter"  class="input-text delivery_time_minimum"   name="'
            . $this->getElement()->getName() . '[delivery_time_minimum][]"  />
            <p class="note"><span >Please Enter Value In Days for Delivery Minimum Time</span></p>
            <span id="error_delivery_time_minimum_counter"></span></div>';
        // Delivery Time Maximum
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Delivery Time Maximum </label>';
         
        $html .= '<input id="delivery_time_maximum_counter"    class="input-text delivery_time_maximum"   name="'
            . $this->getElement()->getName() . '[delivery_time_maximum][]" />
            <p class="note"><span >Please Enter Value In Days for Delivery Maximum Time</span></p>
            <span id="error_delivery_time_maximum_counter"></span></div> ';
        // included region
        $html .= '<div style="position:relative;"><label style="position: absolute; left: -205px;"> Included Region </label>';
         
        $html .= '<select  id="included_region_counter"  onchange="showExcludedRegion(this,counter)"  class="input-text included_region" name="' . $this->getElement()->getName() . '[included_region][]" ' . $this->_getDisabled() . '>';
        $html .= '<option value="">' . $this->__('Select Included Region') . '</option>';
        
            foreach ($this->getCountry() as $methodCode => $method) {
                $code = $methodCode;
                $html .= '<option value="' . $this->escapeHtml($code) . '" '
                    . ' style="background:white;">' . $this->escapeHtml($method) . '</option>';

        }
        $html .= '</select>
                  <p class="note"><span>Select the regions you will ship to</span></p><span id="error_included_region_counter"></span></div>';


        $html .= '<div style="position:relative;display:none;" id="excluded_region_div_counter"><label style="position: absolute; left: -205px;"> Excluded Region </label>';
         
        $html .= '<select  id="excluded_region_counter"   name="' . $this->getElement()->getName() . '[excluded_region][]" ' . $this->_getDisabled() . '>';
        $html .= '<option value="">' . $this->__('Select Excluded Region') . '</option>';
        
            foreach ($this->getCountry() as $methodCode => $method) {
                $code = $methodCode;
                $html .= '<option value="' . $this->escapeHtml($code) . '" '
                    . ' style="background:white;">' . $this->escapeHtml($method) . '</option>';

        }
        $html .= '</select><p class="note"><span>Select the regions you will not ship to</span></p><span id="error_excluded_region_counter"></span></div>';
        // Delete
        $html .= '<div>'.$this->_getRemoveRowButtonHtml().'</div> ';

        //$html .= '</tr></table>';
        $html .= '</li>';
        return $html;
    }

    protected function getCountry(){
        $internationalShippingCountries = new SimpleXMLElement(Mage::getConfig()->getNode('default/international/shipping')->asXml());
        $internationalShippingCountries = json_decode(json_encode($internationalShippingCountries),1);
        $arrCountry = array();
        foreach($internationalShippingCountries as $countryKey => $countryLabel)
            $arrCountry[$countryKey] = $countryLabel;
        
        return $arrCountry;
        
    }
    protected function getServiceLevel(){
         
        return array('Expedited'=>'Expedited','Standard'=>'Standard');
    }
    protected function getShippingRate(){
         
        return array(
            
            'WeightBased'=>'WeightBased',
            'ItemQuantityBased'=>'ItemQuantityBased',
            'ShipmentBased'=>'ShipmentBased',
            'ItemQuantityBased+ShipmentBased'=>'ItemQuantityBased+ShipmentBased',
            'WeightBased+ShipmentBased'=>'WeightBased+ShipmentBased',
        );
    }
    
    protected function _getDisabled()
    {
        return $this->getElement()->getDisabled() ? ' disabled' : '';
    }
    protected function _getValue($key)
    {
        return $this->getElement()->getData('value/' . $key);
    }
    protected function _getSelected($key, $value)
    {
        return $this->getElement()->getData('value/' . $key) == $value ? 'selected="selected"' : '';
    }
    protected function _getAddRowButtonHtml($container, $template, $title='Add')
    {
        if (!isset($this->_addRowButtonHtml[$container])) {
            $this->_addRowButtonHtml[$container] = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('add ' . $this->_getDisabled())
                    ->setId('add_random')
                    ->setLabel($this->__($title))
                    ->setOnClick("Element.insert($('" . $container . "'), {bottom:  myfunction('".$template."')});")
                    ->setDisabled($this->_getDisabled())
                    ->toHtml();
        }
        return $this->_addRowButtonHtml[$container];
    }
    protected function _getRemoveRowButtonHtml($selector = 'li', $title = 'Remove')
    {
        if (!$this->_removeRowButtonHtml) {
            $this->_removeRowButtonHtml = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('delete v-middle ' . $this->_getDisabled())
                    ->setLabel($this->__($title))
                    ->setOnClick("Element.remove($(this).up('" . $selector . "'))")
                    ->setDisabled($this->_getDisabled())
                    ->toHtml();
        }
        return $this->_removeRowButtonHtml;
    }
}
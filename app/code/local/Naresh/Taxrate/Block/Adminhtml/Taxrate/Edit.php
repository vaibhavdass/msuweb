<?php

class Naresh_Taxrate_Block_Adminhtml_Taxrate_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'taxrate';
        $this->_controller = 'adminhtml_taxrate';
        
        $this->_updateButton('save', 'label', Mage::helper('taxrate')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('taxrate')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('taxrate_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'taxrate_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'taxrate_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('taxrate_data') && Mage::registry('taxrate_data')->getId() ) {
            return Mage::helper('taxrate')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('taxrate_data')->getTitle()));
        } else {
            return Mage::helper('taxrate')->__('Add TaxRates');
        }
    }
}
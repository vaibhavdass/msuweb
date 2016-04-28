<?php

class Naresh_Cardholder_Block_Adminhtml_Cardholder_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'cardholder';
        $this->_controller = 'adminhtml_cardholder';
        
        $this->_updateButton('save', 'label', Mage::helper('cardholder')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('cardholder')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('cardholder_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'cardholder_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'cardholder_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('cardholder_data') && Mage::registry('cardholder_data')->getId() ) {
            return Mage::helper('cardholder')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('cardholder_data')->getTitle()));
        } else {
            return Mage::helper('cardholder')->__('Cardholder Style');
        }
    }
}
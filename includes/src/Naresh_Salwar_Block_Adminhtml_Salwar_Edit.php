<?php

class Naresh_Salwar_Block_Adminhtml_Salwar_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'salwar';
        $this->_controller = 'adminhtml_salwar';
        
        $this->_updateButton('save', 'label', Mage::helper('salwar')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('salwar')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('salwar_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'salwar_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'salwar_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('salwar_data') && Mage::registry('salwar_data')->getId() ) {
            return Mage::helper('salwar')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('salwar_data')->getTitle()));
        } else {
            return Mage::helper('salwar')->__('Salwar Style');
        }
    }
}
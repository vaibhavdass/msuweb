<?php

class Naresh_Sleeves_Block_Adminhtml_Sleeves_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sleeves';
        $this->_controller = 'adminhtml_sleeves';
        
        $this->_updateButton('save', 'label', Mage::helper('sleeves')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('sleeves')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('sleeves_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'sleeves_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'sleeves_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'sleeves/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('sleeves_data') && Mage::registry('sleeves_data')->getId() ) {
            return Mage::helper('sleeves')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('sleeves_data')->getTitle()));
        } else {
            return Mage::helper('sleeves')->__('Sleeve Style');
        }
    }
}
<?php

class Naresh_Lehanga_Block_Adminhtml_Lehanga_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'lehanga';
        $this->_controller = 'adminhtml_lehanga';
        
        $this->_updateButton('save', 'label', Mage::helper('lehanga')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('lehanga')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('lehanga_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'lehanga_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'lehanga_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('lehanga_data') && Mage::registry('lehanga_data')->getId() ) {
            return Mage::helper('lehanga')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('lehanga_data')->getTitle()));
        } else {
            return Mage::helper('lehanga')->__('Lehanga Style');
        }
    }
}
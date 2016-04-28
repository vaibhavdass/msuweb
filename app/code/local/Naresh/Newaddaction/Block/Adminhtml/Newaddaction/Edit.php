<?php

class Naresh_Newaddaction_Block_Adminhtml_Newaddaction_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'newaddaction';
        $this->_controller = 'adminhtml_newaddaction';
        
        $this->_updateButton('save', 'label', Mage::helper('newaddaction')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('newaddaction')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('newaddaction_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'newaddaction_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'newaddaction_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('newaddaction_data') && Mage::registry('newaddaction_data')->getId() ) {
            return Mage::helper('newaddaction')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('newaddaction_data')->getTitle()));
        } else {
            return Mage::helper('newaddaction')->__('Add New Newaddactions');
        }
    }
}
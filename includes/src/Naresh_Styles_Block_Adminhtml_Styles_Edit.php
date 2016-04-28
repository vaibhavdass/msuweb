<?php

class Naresh_Styles_Block_Adminhtml_Styles_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'styles';
        $this->_controller = 'adminhtml_styles';
        
        $this->_updateButton('save', 'label', Mage::helper('styles')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('styles')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('styles_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'styles_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'styles_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('styles_data') && Mage::registry('styles_data')->getId() ) {
            return Mage::helper('styles')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('styles_data')->getTitle()));
        } else {
            return Mage::helper('styles')->__('Front Style');
        }
    }
}
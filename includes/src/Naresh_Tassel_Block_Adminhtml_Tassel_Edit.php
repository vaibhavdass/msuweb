<?php

class Naresh_Tassel_Block_Adminhtml_Tassel_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'tassel';
        $this->_controller = 'adminhtml_tassel';
        
        $this->_updateButton('save', 'label', Mage::helper('tassel')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('tassel')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('tassel_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'tassel_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'tassel_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('tassel_data') && Mage::registry('tassel_data')->getId() ) {
            return Mage::helper('tassel')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('tassel_data')->getTitle()));
        } else {
            return Mage::helper('tassel')->__('Tassel Style');
        }
    }
}
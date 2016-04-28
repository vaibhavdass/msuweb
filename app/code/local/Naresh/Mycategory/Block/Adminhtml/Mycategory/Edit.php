<?php

class Naresh_Mycategory_Block_Adminhtml_Mycategory_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'mycategory';
        $this->_controller = 'adminhtml_mycategory';
        
        $this->_updateButton('save', 'label', Mage::helper('mycategory')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('mycategory')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('mycategory_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'mycategory_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'mycategory_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('mycategory_data') && Mage::registry('mycategory_data')->getId() ) {
            return Mage::helper('mycategory')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('mycategory_data')->getTitle()));
        } else {
            return Mage::helper('mycategory')->__('Mycategory Style');
        }
    }
}
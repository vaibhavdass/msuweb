<?php

class Naresh_Measurementremember_Block_Adminhtml_Measurementremember_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'measurementremember';
        $this->_controller = 'adminhtml_measurementremember';
        
        $this->_updateButton('save', 'label', Mage::helper('measurementremember')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('measurementremember')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('measurementremember_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'measurementremember_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'measurementremember_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('measurementremember_data') && Mage::registry('measurementremember_data')->getId() ) {
            return Mage::helper('measurementremember')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('measurementremember_data')->getTitle()));
        } else {
            return Mage::helper('measurementremember')->__('Add Measurementremember Rates');
        }
    }
}
<?php

class Naresh_Stitchingservices_Block_Adminhtml_Stitchingservices_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'stitchingservices';
        $this->_controller = 'adminhtml_stitchingservices';
        
        $this->_updateButton('save', 'label', Mage::helper('stitchingservices')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('stitchingservices')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('stitchingservices_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'stitchingservices_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'stitchingservices_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('stitchingservices_data') && Mage::registry('stitchingservices_data')->getId() ) {
            return Mage::helper('stitchingservices')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('stitchingservices_data')->getTitle()));
        } else {
            return Mage::helper('stitchingservices')->__('Add New Stitchingservicess');
        }
    }
}
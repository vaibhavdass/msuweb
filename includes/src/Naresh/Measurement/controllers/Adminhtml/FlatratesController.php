<?php
class Naresh_Measurement_Adminhtml_CustomtitlesController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('measurement/item')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        
        return $this;
    }   
 
    public function indexAction() {
        $this->_initAction()
            ->renderLayout();
    }
    public function editAction() { }
    public function newAction() { }
    public function saveAction() { }
    public function deleteAction() { }
    public function massDeleteAction() { }
    public function massStatusAction() { }
}
?>
<?php
class Naresh_Mycategory_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function getattributevaluesAction()
    {
		$block = $this->getLayout()->createBlock('mycategory/mycategory')->setTemplate('mycategory/getattributevalues.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function loadnextpageAction()
    {
        $block = $this->getLayout()->createBlock('mycategory/mycategory')->setTemplate('mycategory/loadnextpage.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
}
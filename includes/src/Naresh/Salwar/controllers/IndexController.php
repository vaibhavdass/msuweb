<?php
class Naresh_Salwar_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function availstittypesAction()
    {
		$block = $this->getLayout()->createBlock('salwar/salwar')->setTemplate('salwar/availstittypes.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
}
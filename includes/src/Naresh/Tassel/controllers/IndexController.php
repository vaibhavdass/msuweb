<?php
class Naresh_Tassel_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function availstittypesAction()
    {
		$block = $this->getLayout()->createBlock('tassel/tassel')->setTemplate('tassel/availstittypes.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
}
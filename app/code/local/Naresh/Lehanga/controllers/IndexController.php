<?php
class Naresh_Lehanga_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function availstittypesAction()
    {
		$block = $this->getLayout()->createBlock('lehanga/lehanga')->setTemplate('lehanga/availstittypes.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
}
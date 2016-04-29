<?php
class Naresh_Styles_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function availstittypesAction()
    {
		$block = $this->getLayout()->createBlock('styles/styles')->setTemplate('styles/availstittypes.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
}
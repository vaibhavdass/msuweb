<?php
class Naresh_Sleeves_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$block = $this->getLayout()->createBlock('sleeves/sleeves')->setTemplate('sleeves/sleeves.phtml');
        $this->getResponse()->setBody($block->toHtml());
		// $this->loadLayout();     
		// $this->renderLayout();
    }
}
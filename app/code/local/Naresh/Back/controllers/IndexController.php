<?php
class Naresh_Back_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$block = $this->getLayout()->createBlock('back/back')->setTemplate('back/back.phtml');
        $this->getResponse()->setBody($block->toHtml());
		// $this->loadLayout();     
		// $this->renderLayout();
    }
}
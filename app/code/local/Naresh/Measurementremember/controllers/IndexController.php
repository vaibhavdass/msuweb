<?php
class Naresh_Measurementremember_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function availstittypesAction()
    {
		$block = $this->getLayout()->createBlock('measurementremember/measurementremember')->setTemplate('measurementremember/availstittypes.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function previewAction()
    {
        $block = $this->getLayout()->createBlock('measurementremember/measurementremember')->setTemplate('measurementremember/preview.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
}
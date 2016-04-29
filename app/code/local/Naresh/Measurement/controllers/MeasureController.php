o<?php
class Naresh_Measurement_MeasureController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
  //   	$this->loadLayout( array('default','measurement_index_index'));
		// $this->loadLayout();     
		// $this->renderLayout();
    }
    public function measurementsformAction() {
    	// $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/productmeasurements.phtml');
        // $this->getResponse()->setBody($block->toHtml());
  //       $this->loadLayout( array('default','measurement_measure_index'));
		// $this->loadLayout();
		// $this->renderLayout();
    }
    public function frontstylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/frontstyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function backstylesAction(){
		$block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/backstyles.phtml');
		$this->getResponse()->setBody($block->toHtml());
    }
    public function sleevestylesAction(){
		$block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/sleevestyles.phtml');
		$this->getResponse()->setBody($block->toHtml());
    }
    public function getmeasurementsAction(){
		$block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getmeasurements.phtml');
		$this->getResponse()->setBody($block->toHtml());
    }
    public function getsimplemeasurementsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getsimplemeasurements.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getmeasurementunitsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getmeasurementunits.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getcustommeasurementsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getcustommeasurements.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getstandardmeasurementsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getstandardmeasurements.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getreviewblockAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getreviewblock.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function savemeasurementsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/savemeasurements.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function storemeasurementsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/storemeasurements.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function showreviewblockAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/showreviewblock.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getstandardmobilemeasurementsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getstandardmobilemeasurements.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getlehangastylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getlehangastyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getsalwarstylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/getsalwarstyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function gettasselstylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/gettasselstyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function loadnextpageAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/loadnextpage.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
}
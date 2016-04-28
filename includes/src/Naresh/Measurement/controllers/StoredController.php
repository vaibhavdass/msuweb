<?php
class Naresh_Measurement_StoredController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch()
    {
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();
 
        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }
    public function indexAction()
    {
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setTitle($this->__('My Measurements'));
		$this->renderLayout();
    }
    public function editAction()
    {
		$this->loadLayout( array('default','measurement_stored_edit'));
		$this->getLayout()->getBlock('head')->setTitle($this->__('Edit Measurements'));
		$this->renderLayout();
    }
    public function addAction()
    {
        $this->loadLayout( array('default','measurement_stored_add'));
        $this->getLayout()->getBlock('head')->setTitle($this->__('Add New Measurements'));
        $this->renderLayout();
    }
    public function deleteAction()
    {
    	if($wholedata = $this->getRequest()->getParams()){
    		$model = Mage::getModel('measurementremember/measurementremember')->load($wholedata['id']);
    		$model->setAccount(0);
    		$model->save();
    	}
    	$this->_redirect('measurement/stored/');
		$this->loadLayout( array('default','measurement_stored_index'));
		$this->getLayout()->getBlock('head')->setTitle($this->__('Measurements was deleted successfully'));
		$this->renderLayout();
    }
    public function saveeditAction()
    {
    	if($wholedata = $this->getRequest()->getParams()){
    		Mage::log($wholedata);
    		$model = Mage::getModel('measurementremember/measurementremember')->load($wholedata['measurement_id']);
    		$model->setAccount(0);
    		$model->save();

    		$data['stitching_service_id'] = $wholedata['service'];
    		$data['title'] = $wholedata['storing_for'];
    		$data['c_id'] = $wholedata['customer_id'];
    		$data['account'] = 1;
    		$data['email'] = Mage::getModel('customer/customer')->load($wholedata['customer_id'])->getEmail();

    		$model1 = Mage::getModel('measurementremember/measurementremember');
			$model1->setData($data)->setId($this->getRequest()->getParam('id'));
	    	try {
				if ($model1->getCreatedTime == NULL || $model1->getUpdateTime() == NULL) {
					$model1->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model1->setUpdateTime(now());
				}
				$model1->save();
				$data['flatrate_id'] = Mage::getModel('measurementremember/flatrates')->saveeditFlatrates($wholedata, $model1->getId());
				$model1->setFlatrateId($data['flatrate_id']);
				$model1->save();
            } catch (Exception $e) {}
    	}
    	$this->_redirect('measurement/stored/');
		$this->loadLayout( array('default','measurement_stored_edit'));
		$this->getLayout()->getBlock('head')->setTitle($this->__('Measurements was updated successfully'));
		$this->renderLayout();
    }
    public function saveAction()
    {
        if($wholedata = $this->getRequest()->getParams()){
            $params['measurement_type'] = 'custom';
            $data['stitching_service_id'] = $wholedata['service'];
            $data['title'] = $wholedata['storing_for'];
            $data['stitching_type'] = $wholedata['service_type'];
            $data['c_id'] = $wholedata['customer_id'];
            $data['account'] = 1;
            $data['measurment_units'] = $params['measurment_units'];
            $data['email'] = Mage::getModel('customer/customer')->load($wholedata['customer_id'])->getEmail();

            $model1 = Mage::getModel('measurementremember/measurementremember');
            $model1->setData($data)->setId($this->getRequest()->getParam('id'));
            try {
                if ($model1->getCreatedTime == NULL || $model1->getUpdateTime() == NULL) {
                    $model1->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model1->setUpdateTime(now());
                }
                $model1->save();
                $data['flatrate_id'] = Mage::getModel('measurementremember/flatrates')->addsaveFlatrates($wholedata, $model1->getId());
                $model1->setFlatrateId($data['flatrate_id']);
                $model1->save();
            } catch (Exception $e) {}
        }
        $this->_redirect('measurement/stored/add');
        $this->renderLayout();
    }
    public function getcustommeasurementsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/getcustommeasurements.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getservicetypesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/getservicetypes.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getfrontstylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/frontstyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getbackstylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/backstyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getsleevestylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/sleevestyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getlehangastylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/getlehangastyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function getsalwarstylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/getsalwarstyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function gettasselstylesAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/gettasselstyles.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
    public function unitsAction(){
        $block = $this->getLayout()->createBlock('measurement/measurement')->setTemplate('measurement/stored/units.phtml');
        $this->getResponse()->setBody($block->toHtml());
    }
}
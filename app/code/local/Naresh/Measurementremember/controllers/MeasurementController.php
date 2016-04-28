<?php
class Naresh_Measurementremember_MeasurementController extends Mage_Core_Controller_Front_Action
{
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	}
    public function saveAction()
    {
    	if ($params = $this->getRequest()->getPost()) {
    		if ($params['existing_measurements'] == 'new') {
    			$data = array();
		    	$data1 = array();
		    	$_product = Mage::getModel('catalog/product')->load($params['product_id']);
		    	$data['title'] = $params['storing_for'];
		    	$data['c_id'] = $params['customer_id'];
		    	if (isset($params['order_id'])) {
		    		$data['order_id'] = $params['order_id'];
		    		$_order = Mage::getModel('sales/order')->load($params['order_id']);
		    		$data['quote_id'] = $_order->getQuoteId();
		    		$data['increment_id'] = $_order->getRealOrderId();
		    	} else{
		    		$data['quote_id'] = Mage::getSingleton('checkout/session')->getQuoteId();
		    	}
		    	$data['stitching_type'] = $params['stitching_type'];
		    	$data['product_id'] = $_product->getId();
		    	$data['sku'] = $_product->getSku();
		    	$data['stitching_service_id'] = $params['service'];
				$data['email'] = Mage::getModel('customer/customer')->load($params['customer_id'])->getEmail();
				$data['account'] = 1;

		    	$model = Mage::getModel('measurementremember/measurementremember');
				$model->setData($data)->setId($this->getRequest()->getParam('id'))->save();
				$data['flatrate_id'] = Mage::getModel('measurementremember/flatrates')->saveFlatrates($params, $model->getId());
		    	try {
					if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
						$model->setCreatedTime(now())
							->setUpdateTime(now());
					} else {
						$model->setUpdateTime(now());
					}
					$model->setFlatrateId($data['flatrate_id']);
					$model->save();
					$order1 = '';
					if (!is_null($params['order_id'])) {
						$order1 = "&order_id=".$params['order_id'];
					}
					$this->_redirect("measurement?product_id=".$_product->getId().$order1);
					Mage::getSingleton('core/session')->addSuccess(Mage::helper('measurementremember')->__('Your Measurements was successfully saved'));
	            } catch (Exception $e) {}
    		} else if($params['existing_measurements'] > 0) {
    			$data1 = Mage::getModel('measurementremember/measurementremember')->load($params['existing_measurements']);
    			$data1 = $data1->getData();
				foreach ($data1 as $key => $value) {
					$data[$key] = $value;
				}
    			$data['measurementremember_id'] = NULL;
    			$data['created_time'] = NULL;
    			$data['update_time'] = NULL;
    			$_product = Mage::getModel('catalog/product')->load($params['product_id']);
    			if (isset($params['order_id'])) {
		    		$data['order_id'] = $params['order_id'];
		    		$_order = Mage::getModel('sales/order')->load($params['order_id']);
		    		$data['quote_id'] = $_order->getQuoteId();
		    		$data['increment_id'] = $_order->getRealOrderId();
		    	} else{
		    		$data['quote_id'] = Mage::getSingleton('checkout/session')->getQuoteId();
		    	}
				$data['c_id'] = $params['customer_id'];
				$data['stitching_type'] = $params['stitching_type'];
				$data['product_id'] = $_product->getId();
				$data['sku'] = $_product->getSku();
				$data['account'] = 0;
    			$model = Mage::getModel('measurementremember/measurementremember');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				$model->save();
				$data['flatrate_id'] = Mage::getModel('measurementremember/flatrates')->saveexistingFlatrates($params, $model->getId());
		    	try {
					if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
						$model->setCreatedTime(now())
							->setUpdateTime(now());
					} else {
						$model->setUpdateTime(now());
					}
					$model->setFlatrateId($data['flatrate_id']);
					$model->save();
					if (!is_null($params['order_id'])) {
						$order1 = "&order_id=".$params['order_id'];
					}
					$this->_redirect("measurement?product_id=".$_product->getId().$order1);
					Mage::getSingleton('core/session')->addSuccess(Mage::helper('measurementremember')->__('Your Measurements was successfully saved'));
	            } catch (Exception $e) {}
    		}
	    }
    }
    public function editAction()
    {
    	if ($params = $this->getRequest()->getPost()) {
	    	$data = array();
	    	$model1 = Mage::getModel('measurementremember/measurementremember')->load($params['measurement_id']);
    		$model1->setAccount(0)->save();
	    	$_product = Mage::getModel('catalog/product')->load($params['product_id']);
	    	$data['title'] = $params['storing_for'];
	    	$data['c_id'] = $params['customer_id'];
	    	$data['quote_id'] = Mage::getSingleton('checkout/session')->getQuoteId();
	    	$data['product_id'] = $_product->getId();
	    	$data['stitching_type'] = $params['stitching_type'];
	    	$data['sku'] = $_product->getSku();
	    	$data['stitching_service_id'] = $params['service'];
			$data['email'] = Mage::getModel('customer/customer')->load($params['customer_id'])->getEmail();
			$data['account'] = 1;

	    	$model = Mage::getModel('measurementremember/measurementremember')->load($params['measurement_id']);
    		$model->setData($data)->save();
    		$data['flatrate_id'] = Mage::getModel('measurementremember/flatrates')->editFlatrates($params, $model->getId());
	    	try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->setFlatrateId($data['flatrate_id']);
				$model->save();
				$this->_redirect("measurement?product_id=".$_product->getId());
				Mage::getSingleton('core/session')->addSuccess(Mage::helper('measurementremember')->__('Your Measurements was successfully saved'));
            } catch (Exception $e) {}
	    }
    }
}
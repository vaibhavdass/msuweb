<?php
class Naresh_Measurementremember_Adminhtml_MeasurementrememberController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('measurementremember/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('measurementremember/measurementremember')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			Mage::register('measurementremember_data', $model);
			$this->loadLayout();
			$this->_setActiveMenu('measurementremember/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('measurementremember/adminhtml_measurementremember_edit'))
				->_addLeft($this->getLayout()->createBlock('measurementremember/adminhtml_measurementremember_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('measurementremember')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			Mage::log($data);
			$data['order_id'] = Mage::getSingleton('sales/order')->loadByIncrementId($data['increment_id'])->getEntityId();
			$model = Mage::getModel('measurementremember/measurementremember');
			$model->setData($data)->setId($this->getRequest()->getParam('id'));
			if ($this->getRequest()->getParam('id') > 0) {
				$model1 = Mage::getSingleton('measurementremember/measurementremember')->load($this->getRequest()->getParam('id'));
				$flatrate_id = $model1->getFlatrateId();
			}else{
				$flatrate_id = NULL;
			}
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->save();

				Mage::getModel('measurementremember/flatrates')->saveAdminEditedFlatrates($data, $flatrate_id);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('measurementremember')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('measurementremember')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('measurementremember/measurementremember');
				// $mode->deleteVal($this->getRequest()->getParam('id'));
				$path = Mage::getBaseDir('media') . '/'.$this->getRequest()->getParam('id').'.jpg' ;
				unlink($path);
				$model->setId($this->getRequest()->getParam('id'))->delete();
				//$model1 = Mage::getModel('measurementremember/flatrates');
				//$model1->setId($this->getRequest()->getParam('id'))->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
    public function massDeleteAction() {
        $measurementrememberIds = $this->getRequest()->getParam('measurementremember');
        if(!is_array($measurementrememberIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($measurementrememberIds as $measurementrememberId) {
                	// Mage::getModel('measurementremember/measurementremember')->deleteVal($measurementrememberId);
                    $measurementremember = Mage::getModel('measurementremember/measurementremember')->load($measurementrememberId);
                    $measurementremember->delete();
                    $path = Mage::getBaseDir('media') . '/'.$measurementrememberId.'.jpg' ;
					unlink($path);
                    //$measurementremember1 = Mage::getModel('measurementremember/flatrates')->load($measurementrememberId);
                    //$measurementremember1->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($measurementrememberIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    public function massStatusAction()
    {
        $measurementrememberIds = $this->getRequest()->getParam('measurementremember');
        if(!is_array($measurementrememberIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($measurementrememberIds as $measurementrememberId) {
                    $measurementremember = Mage::getSingleton('measurementremember/measurementremember')
                        ->load($measurementrememberId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($measurementrememberIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
<?php
class Naresh_Measurement_Adminhtml_MeasurementController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('measurement/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('measurement/measurement')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			Mage::register('measurement_data', $model);
			if ($model->getId() > 0) {
				$data['image'] = 'measurement_'.$id.'.jpg';
				$model->setImage($data['image'])->save();
			}
			$this->loadLayout();
			$this->_setActiveMenu('measurement/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('measurement/adminhtml_measurement_edit'))
				->_addLeft($this->getLayout()->createBlock('measurement/adminhtml_measurement_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('measurement')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			if($this->getRequest()->getParam('id') > 0) {
				$data['image'] = 'measurement_'.$this->getRequest()->getParam('id').'.jpg';
			}
			$model = Mage::getModel('measurement/measurement');
			$model->setData($data)->setId($this->getRequest()->getParam('id'));
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->save();
				if(isset($_FILES['image']['name']) and (file_exists($_FILES['image']['tmp_name']))) {
					try {
						$uploader = new Varien_File_Uploader('image');
						$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
						$uploader->setAllowRenameFiles(false);
						// setAllowRenameFiles(true) -> move your file in a folder the magento way
						// setAllowRenameFiles(true) -> move your file directly in the $path folder
						$uploader->setFilesDispersion(false);
						$path = Mage::getBaseDir('media') . '/' ;
						$uploader->save($path, 'measurement_'.$model->getId().'.jpg');
						$model->setImage('measurement_'.$model->getId().'.jpg');
						$model->save();
					}catch(Exception $e) {
						print_r($e);
						die;
					}
				}
				else {       
					if(isset($data['image']['delete']) && $data['image']['delete'] == 1)
					$data['image_main'] = '';
					else
					unset($data['image']);
				}
				if($data['dropdown_type'] == 'custom'){
					Mage::getModel('measurement/customtitles')->saveMultipleCustomtitles($data, $model->getId());
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('measurement')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('measurement')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {

				$model = Mage::getModel('measurement/measurement');
				$path = Mage::getBaseDir('media') . '/measurement_'.$this->getRequest()->getParam('id').'.jpg' ;
				unlink($path);
				$custom_titles = Mage::getModel('measurement/customtitles')->getCollection()->addFieldToFilter('measurement_id',$this->getRequest()->getParam('id'));
				foreach ($custom_titles as $_custom_title) {
					Mage::getModel('measurement/customtitles')->load($_custom_title->getCustomTitleId())->delete();
				}
				$model->setId($this->getRequest()->getParam('id'))->delete();
					 
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
        $measurementIds = $this->getRequest()->getParam('measurement');
        if(!is_array($measurementIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($measurementIds as $measurementId) {
					$custom_titles = Mage::getModel('measurement/customtitles')->getCollection()->addFieldToFilter('measurement_id',$measurementId);
					foreach ($custom_titles as $_custom_title) {
					Mage::getModel('measurement/customtitles')->load($_custom_title->getCustomTitleId())->delete();
					}
                    $measurement = Mage::getModel('measurement/measurement')->load($measurementId);
                    $measurement->delete();
                    $path = Mage::getBaseDir('media') . '/measurement_'.$measurementId.'.jpg' ;
					unlink($path);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($measurementIds)
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
        $measurementIds = $this->getRequest()->getParam('measurement');
        if(!is_array($measurementIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($measurementIds as $measurementId) {
                    $measurement = Mage::getSingleton('measurement/measurement')
                        ->load($measurementId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($measurementIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
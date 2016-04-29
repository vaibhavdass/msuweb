<?php
class Naresh_Sleeves_Adminhtml_SleevesController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('sleeves/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('sleeves/sleeves')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			if ($model->getId() > 0) {
				$data['image'] = 'sleeves_'.$id.'.jpg';
				$model->setImage($data['image'])->save();
			}
			Mage::register('sleeves_data', $model);
			$this->loadLayout();
			$this->_setActiveMenu('sleeves/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('sleeves/adminhtml_sleeves_edit'))
				->_addLeft($this->getLayout()->createBlock('sleeves/adminhtml_sleeves_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sleeves')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			if($this->getRequest()->getParam('id') > 0) {
				$data['image'] = 'sleeves_'.$this->getRequest()->getParam('id').'.jpg';
			}
			$_attrs = $data['measurement_attr'];
			$data['measurement_attr'] = '';
			foreach ($_attrs as $key => $_attr) {
				if ($key == 0) {
					$data['measurement_attr'] = $_attr;
				}else{
					$data['measurement_attr'] .= ','.$_attr;
				}
			}
			$model = Mage::getModel('sleeves/sleeves');
			$model->setData($data)->setId($this->getRequest()->getParam('id'));
			$model->setFrontId($data['front_id']);
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
						$uploader->save($path, 'sleeves_'.$model->getId().'.jpg');
						$model->setImage('sleeves_'.$model->getId().'.jpg');
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

				// Mage::getModel('sleeves/flatrates')->saveMultipleFlatrates($data, $model->getId(),$this->getRequest()->getParam('cat_id'));
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('sleeves')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('sleeves')) {
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sleeves')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('sleeves/sleeves');
				// $mode->deleteVal($this->getRequest()->getParam('id'));
				$path = Mage::getBaseDir('media') . '/sleeves_'.$this->getRequest()->getParam('id').'.jpg' ;
				unlink($path);
				$model->setId($this->getRequest()->getParam('id'))->delete();
				//$model1 = Mage::getModel('sleeves/flatrates');
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
        $sleevesIds = $this->getRequest()->getParam('sleeves');
        if(!is_array($sleevesIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($sleevesIds as $sleevesId) {
                	// Mage::getModel('sleeves/sleeves')->deleteVal($sleevesId);
                    $sleeves = Mage::getModel('sleeves/sleeves')->load($sleevesId);
                    $sleeves->delete();
                    $path = Mage::getBaseDir('media') . '/sleeves_'.$sleevesId.'.jpg' ;
					unlink($path);
                    //$sleeves1 = Mage::getModel('sleeves/flatrates')->load($sleevesId);
                    //$sleeves1->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($sleevesIds)
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
        $sleevesIds = $this->getRequest()->getParam('sleeves');
        if(!is_array($sleevesIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($sleevesIds as $sleevesId) {
                    $sleeves = Mage::getSingleton('sleeves/sleeves')
                        ->load($sleevesId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($sleevesIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
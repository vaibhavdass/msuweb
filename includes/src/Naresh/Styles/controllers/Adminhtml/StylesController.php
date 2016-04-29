<?php
class Naresh_Styles_Adminhtml_StylesController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('styles/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('styles/styles')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			// $data['image'] = 'front_'.$id.'.jpg';
			if (!empty($data)) {
				$model->setData($data);
			}
			Mage::register('styles_data', $model);
			if ($model->getId() > 0) {
				$data['image'] = 'front_'.$id.'.jpg';
				$model->setImage($data['image'])->save();
			}
			$this->loadLayout();
			$this->_setActiveMenu('styles/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('styles/adminhtml_styles_edit'))
				->_addLeft($this->getLayout()->createBlock('styles/adminhtml_styles_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('styles')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			if($this->getRequest()->getParam('id') > 0) {
				$data['image'] = 'front_'.$this->getRequest()->getParam('id').'.jpg';
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
			$_attrs = $data['stitching_service'];
			$data['stitching_service'] = '';
			foreach ($_attrs as $key => $_attr) {
				if ($key == 0) {
					$data['stitching_service'] = $_attr;
				}else{
					$data['stitching_service'] .= ','.$_attr;
				}
			}
			$model = Mage::getModel('styles/styles');
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
						$uploader->save($path, 'front_'.$model->getId().'.jpg');
						$model->setImage('front_'.$model->getId().'.jpg');
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

				// Mage::getModel('styles/flatrates')->saveMultipleFlatrates($data, $model->getId(),$this->getRequest()->getParam('cat_id'));
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('styles')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('styles')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('styles/styles');
				// $mode->deleteVal($this->getRequest()->getParam('id'));
				$path = Mage::getBaseDir('media') . '/front_'.$this->getRequest()->getParam('id').'.jpg' ;
				Mage::log($path);
				unlink($path);
				$model->setId($this->getRequest()->getParam('id'))->delete();
				//$model1 = Mage::getModel('styles/flatrates');
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
        $stylesIds = $this->getRequest()->getParam('styles');
        if(!is_array($stylesIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($stylesIds as $stylesId) {
                	// Mage::getModel('styles/styles')->deleteVal($stylesId);
                    $styles = Mage::getModel('styles/styles')->load($stylesId);
                    $styles->delete();
                    $path = Mage::getBaseDir('media') . '/front_'.$stylesId.'.jpg' ;
					unlink($path);
                    //$styles1 = Mage::getModel('styles/flatrates')->load($stylesId);
                    //$styles1->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($stylesIds)
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
        $stylesIds = $this->getRequest()->getParam('styles');
        if(!is_array($stylesIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($stylesIds as $stylesId) {
                    $styles = Mage::getSingleton('styles/styles')
                        ->load($stylesId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($stylesIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
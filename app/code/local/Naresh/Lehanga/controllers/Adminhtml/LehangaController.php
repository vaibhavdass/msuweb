<?php
class Naresh_Lehanga_Adminhtml_LehangaController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('lehanga/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('lehanga/lehanga')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			// $data['image'] = 'lehanga_'.$id.'.jpg';
			if (!empty($data)) {
				$model->setData($data);
			}
			Mage::register('lehanga_data', $model);
			if ($model->getId() > 0) {
				$data['image'] = 'lehanga_'.$id.'.jpg';
				$model->setImage($data['image'])->save();
			}
			$this->loadLayout();
			$this->_setActiveMenu('lehanga/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('lehanga/adminhtml_lehanga_edit'))
				->_addLeft($this->getLayout()->createBlock('lehanga/adminhtml_lehanga_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('lehanga')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
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
			if($this->getRequest()->getParam('id') > 0) {
				$data['image'] = 'lehanga_'.$this->getRequest()->getParam('id').'.jpg';
			}
			$model = Mage::getModel('lehanga/lehanga');
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
						$uploader->save($path, 'lehanga_'.$model->getId().'.jpg');
						$model->setImage('lehanga_'.$model->getId().'.jpg');
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

				// Mage::getModel('lehanga/flatrates')->saveMultipleFlatrates($data, $model->getId(),$this->getRequest()->getParam('cat_id'));
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('lehanga')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('lehanga')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('lehanga/lehanga');
				// $mode->deleteVal($this->getRequest()->getParam('id'));
				$path = Mage::getBaseDir('media') . '/lehanga_'.$this->getRequest()->getParam('id').'.jpg' ;
				Mage::log($path);
				unlink($path);
				$model->setId($this->getRequest()->getParam('id'))->delete();
				//$model1 = Mage::getModel('lehanga/flatrates');
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
        $lehangaIds = $this->getRequest()->getParam('lehanga');
        if(!is_array($lehangaIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($lehangaIds as $lehangaId) {
                	// Mage::getModel('lehanga/lehanga')->deleteVal($lehangaId);
                    $lehanga = Mage::getModel('lehanga/lehanga')->load($lehangaId);
                    $lehanga->delete();
                    $path = Mage::getBaseDir('media') . '/lehanga_'.$lehangaId.'.jpg' ;
					unlink($path);
                    //$lehanga1 = Mage::getModel('lehanga/flatrates')->load($lehangaId);
                    //$lehanga1->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($lehangaIds)
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
        $lehangaIds = $this->getRequest()->getParam('lehanga');
        if(!is_array($lehangaIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($lehangaIds as $lehangaId) {
                    $lehanga = Mage::getSingleton('lehanga/lehanga')
                        ->load($lehangaId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($lehangaIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
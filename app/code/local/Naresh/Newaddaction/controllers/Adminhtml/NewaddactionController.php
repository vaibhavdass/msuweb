<?php
class Naresh_Newaddaction_Adminhtml_NewaddactionController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('newaddaction/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('newaddaction/newaddaction')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			Mage::register('newaddaction_data', $model);
			$this->loadLayout();
			$this->_setActiveMenu('newaddaction/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('newaddaction/adminhtml_newaddaction_edit'))
				->_addLeft($this->getLayout()->createBlock('newaddaction/adminhtml_newaddaction_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('newaddaction')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('newaddaction/newaddaction');
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
						$uploader->save($path, $model->getId().'.jpg');
						$model->setImage($model->getId().'.jpg');
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

				// Mage::getModel('newaddaction/flatrates')->saveMultipleFlatrates($data, $model->getId(),$this->getRequest()->getParam('cat_id'));
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('newaddaction')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('newaddaction')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('newaddaction/newaddaction');
				// $mode->deleteVal($this->getRequest()->getParam('id'));
				$path = Mage::getBaseDir('media') . '/'.$this->getRequest()->getParam('id').'.jpg' ;
				unlink($path);
				$model->setId($this->getRequest()->getParam('id'))->delete();
				//$model1 = Mage::getModel('newaddaction/flatrates');
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
        $newaddactionIds = $this->getRequest()->getParam('newaddaction');
        if(!is_array($newaddactionIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($newaddactionIds as $newaddactionId) {
                	// Mage::getModel('newaddaction/newaddaction')->deleteVal($newaddactionId);
                    $newaddaction = Mage::getModel('newaddaction/newaddaction')->load($newaddactionId);
                    $newaddaction->delete();
                    $path = Mage::getBaseDir('media') . '/'.$newaddactionId.'.jpg' ;
					unlink($path);
                    //$newaddaction1 = Mage::getModel('newaddaction/flatrates')->load($newaddactionId);
                    //$newaddaction1->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($newaddactionIds)
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
        $newaddactionIds = $this->getRequest()->getParam('newaddaction');
        if(!is_array($newaddactionIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($newaddactionIds as $newaddactionId) {
                    $newaddaction = Mage::getSingleton('newaddaction/newaddaction')
                        ->load($newaddactionId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($newaddactionIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
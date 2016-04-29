<?php
class Naresh_Mycategory_Adminhtml_MycategoryController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('mycategory/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('mycategory/mycategory')->load($id);
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (isset($data['attr1_values'])) {
				$temp['attr1_values'] = '';
				foreach ($data['attr1_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr1_values'] = $_attr;
					}else{
						$temp['attr1_values'] .= ','.$_attr;
					}
				}
				$data['attr1_values'] = $temp['attr1_values'];
			}
			if (isset($data['attr2_values'])) {
				$temp['attr2_values'] = '';
				foreach ($data['attr2_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr2_values'] = $_attr;
					}else{
						$temp['attr2_values'] .= ','.$_attr;
					}
				}
				$data['attr2_values'] = $temp['attr2_values'];
			}
			if (isset($data['attr3_values'])) {
				$temp['attr3_values'] = '';
				foreach ($data['attr3_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr3_values'] = $_attr;
					}else{
						$temp['attr3_values'] .= ','.$_attr;
					}
				}
				$data['attr3_values'] = $temp['attr3_values'];
			}
			if (isset($data['attr4_values'])) {
				$temp['attr4_values'] = '';
				foreach ($data['attr4_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr4_values'] = $_attr;
					}else{
						$temp['attr4_values'] .= ','.$_attr;
					}
				}
				$data['attr4_values'] = $temp['attr4_values'];
			}
			if (isset($data['attr5_values'])) {
				$temp['attr5_values'] = '';
				foreach ($data['attr5_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr5_values'] = $_attr;
					}else{
						$temp['attr5_values'] .= ','.$_attr;
					}
				}
				$data['attr5_values'] = $temp['attr5_values'];
			}
			if (!empty($data)) {
				$model->setData($data);
			}
			Mage::register('mycategory_data', $model);
			$this->loadLayout();
			$this->_setActiveMenu('mycategory/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('mycategory/adminhtml_mycategory_edit'))
				->_addLeft($this->getLayout()->createBlock('mycategory/adminhtml_mycategory_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mycategory')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$new_product_collection = Mage::getModel('catalog/product')->getCollection()
                                                ->addAttributeToSelect('*')
                                                ->addAttributeToFilter('status', 1)
                                                ->addAttributeToFilter('visibility', 4);
			Mage::log('Size',null,'cat.log');
			Mage::log(sizeof($curent_product_collection),null,'cat.log');
			if($data['product_type'] == 1) {
				$new_product_collection->joinField('category_id','catalog/category_product','category_id','product_id=entity_id',null,'left')
										->addAttributeToFilter('category_id', array('in' => $data['_rootcatID']));
			}else{
				$category = new Mage_Catalog_Model_Category();
				$category->load($data['category']);
				$curent_product_collection = $category->getProductCollection();
				Mage::log(sizeof($curent_product_collection),null,'cat.log');
				foreach ($curent_product_collection as $_product) {
					Mage::getModel('catalog/category_api')->removeProduct($data['category'],$_product->getId());
				}
				// $process = Mage::getModel('index/process')->load(3)->reindexAll();
				// $process = Mage::getModel('index/process')->load(6)->reindexAll();
				// $process = Mage::getModel('index/process')->load(7)->reindexAll();
				$curent_product_collection = $category->getProductCollection();
				Mage::log('Size1',null,'cat.log');
				Mage::log(sizeof($curent_product_collection),null,'cat.log');
			}

			if (isset($data['attr1_values'])) {
				Mage::log('attr1',null,'cat.log');
				$new_product_collection->addAttributeToFilter($data['attr1'], array('in' => $data['attr1_values']));
				Mage::log(sizeof($new_product_collection),null,'cat.log');
			}
			if (isset($data['attr2_values'])) {
				Mage::log('attr2',null,'cat.log');
				$new_product_collection->addAttributeToFilter($data['attr2'], array('in' => $data['attr2_values']));
				Mage::log(sizeof($new_product_collection),null,'cat.log');
			}
			if (isset($data['attr3_values'])) {
				Mage::log('attr3',null,'cat.log');
				$new_product_collection->addAttributeToFilter($data['attr3'], array('in' => $data['attr3_values']));
			}
			if (isset($data['attr4_values'])) {
				Mage::log('attr4',null,'cat.log');
				$new_product_collection->addAttributeToFilter($data['attr4'], array('in' => $data['attr4_values']));
			}
			if (isset($data['attr5_values'])) {
				Mage::log('attr5',null,'cat.log');
				$new_product_collection->addAttributeToFilter($data['attr5'], array('in' => $data['attr5_values']));
			}
			if ($data['sale'] == 1) {
			 	$todayDate = date('m/d/y');
                $tomorrow = mktime(0, 0, 0, date('m'), date('d')+1, date('y'));
                $tomorrowDate = date('m/d/y', $tomorrow);
                $new_product_collection->addAttributeToFilter('special_price', array('neq' => ""))
                                        ->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate))
                                        ->addAttributeToFilter('special_to_date', array('or'=> array(
                                            0 => array('date' => true, 'from' => $tomorrowDate),
                                            1 => array('is' => new Zend_Db_Expr('null')))
                                        ), 'left');
			}
			Mage::log('End',null,'cat.log');
			Mage::log(sizeof($new_product_collection),null,'cat.log');
			$new_product_collection->getSelect()->limit($data['limit']);
			if(sizeof($new_product_collection) > 0) {
				foreach ($new_product_collection as $_new_product) {
					Mage::getModel('catalog/category_api')->assignProduct($data['category'],$_new_product->getId());
				}
				// $process = Mage::getModel('index/process')->load(3)->reindexAll();
				// $process = Mage::getModel('index/process')->load(6)->reindexAll();
				// $process = Mage::getModel('index/process')->load(7)->reindexAll();
			}


			if (isset($data['attr1_values'])) {
				$temp['attr1_values'] = '';
				foreach ($data['attr1_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr1_values'] = $_attr;
					}else{
						$temp['attr1_values'] .= ','.$_attr;
					}
				}
				$data['attr1_values'] = $temp['attr1_values'];
			}
			if (isset($data['attr2_values'])) {
				$temp['attr2_values'] = '';
				foreach ($data['attr2_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr2_values'] = $_attr;
					}else{
						$temp['attr2_values'] .= ','.$_attr;
					}
				}
				$data['attr2_values'] = $temp['attr2_values'];
			}
			if (isset($data['attr3_values'])) {
				$temp['attr3_values'] = '';
				foreach ($data['attr3_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr3_values'] = $_attr;
					}else{
						$temp['attr3_values'] .= ','.$_attr;
					}
				}
				$data['attr3_values'] = $temp['attr3_values'];
			}
			if (isset($data['attr4_values'])) {
				$temp['attr4_values'] = '';
				foreach ($data['attr4_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr4_values'] = $_attr;
					}else{
						$temp['attr4_values'] .= ','.$_attr;
					}
				}
				$data['attr4_values'] = $temp['attr4_values'];
			}
			if (isset($data['attr5_values'])) {
				$temp['attr5_values'] = '';
				foreach ($data['attr5_values'] as $key => $_attr) {
					if ($key == 0) {
						$temp['attr5_values'] = $_attr;
					}else{
						$temp['attr5_values'] .= ','.$_attr;
					}
				}
				$data['attr5_values'] = $temp['attr5_values'];
			}
			$model = Mage::getModel('mycategory/mycategory');
			$model->setData($data)->setId($this->getRequest()->getParam('id'));
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mycategory')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mycategory')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('mycategory/mycategory');
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
        $mycategoryIds = $this->getRequest()->getParam('mycategory');
        if(!is_array($mycategoryIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($mycategoryIds as $mycategoryId) {
                    $mycategory = Mage::getModel('mycategory/mycategory')->load($mycategoryId);
                    $mycategory->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($mycategoryIds)
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
        $mycategoryIds = $this->getRequest()->getParam('mycategory');
        if(!is_array($mycategoryIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($mycategoryIds as $mycategoryId) {
                    $mycategory = Mage::getSingleton('mycategory/mycategory')
                        ->load($mycategoryId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($mycategoryIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
<?php
class Naresh_Cardholder_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			Mage::log($data,null,'cardholder.log');
			$model = Mage::getModel('cardholder/cardholder');
			if(!is_null($this->getRequest()->getPost('id'))) {
				$id = $this->getRequest()->getPost('id');
			}else{
				$id = sizeof($model->getCollection())+1;
			}
			$model->setData($data)->setId($id);
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				return;
            } catch (Exception $e) {
                return;
            }
        }
	}
}
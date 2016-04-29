<?php
class Naresh_Measurementremember_Model_Flatrates extends Mage_Core_Model_Abstract
{    public function _construct() { 
        parent::_construct();       
        $this->_init('measurementremember/flatrates');   
    }
    public function saveFlatrates($params,$id){
        $data['measurementremember_id'] = $id;
        $data['front_id'] = $data['back_id'] = $data['sleeve_id'] = $data['salwar_id'] = $data['lehanga_id'] = $data['tassel_id'] = 0;
        if(isset($params['front_id'])){
            $data['front_id'] = $params['front_id'];
        }
        if(isset($params['back_id'])){
            $data['back_id'] = $params['back_id'];
        }
        if(isset($params['sleeve_id'])){
            $data['sleeve_id'] = $params['sleeve_id'];
        }
        if(isset($params['salwar_id'])){
            $data['salwar_id'] = $params['salwar_id'];
        }
        if(isset($params['lehanga_id'])){
            $data['lehanga_id'] = $params['lehanga_id'];
        }
        if(isset($params['tassel_id'])){
            $data['tassel_id'] = $params['tassel_id'];
        }
        $data['measurement_type'] = $params['measurement_type'];
        $data['measurment_units'] = $params['measurment_units'];
        foreach ($params[$params['service']] as $key => $value) {
            $data[$key] = $value;
        }
        // $next_id = sizeof(Mage::getModel('measurementremember/flatrates')->getCollection())+1;
        // $model = Mage::getModel('measurementremember/flatrates')->setData($data)->setId($next_id)->save();
        $model = Mage::getModel('measurementremember/flatrates')->setData($data)->setId($params['id'])->save();
        try {
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                $model->setCreatedTime(now())
                        ->setUpdateTime(now());
            } else {
                $model->setUpdateTime(now());
            }
            $model->save();
            return $model->getFlatrateId();
        } catch (Exception $e) {}
    }
    public function saveAdminEditedFlatrates($params,$id){
        // Mage::log($params);
        // $data['measurementremember_id'] = $id;
        // $data['front_id'] = $params['front_id'];
        // $data['back_id'] = $params['back_id'];
        // $data['sleeve_id'] = $params['sleeve_id'];
        // $data['salwar_id'] = $params['salwar_id'];
        // $data['lehanga_id'] = $params['lehanga_id'];
        // $data['tassel_id'] = $params['tassel_id'];
        // $data['measurement_type'] = $params['measurement_type'];
        // $data['measurment_units'] = $params['measurment_units'];
        // foreach ($params[$params['service']] as $key => $value) {
        //     $data[$key] = $value;
        // }
        $data = $params['attr'];
        $model = Mage::getModel('measurementremember/flatrates')->setData($data)->setId($id)->save();
        try {
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                $model->setCreatedTime(now())
                        ->setUpdateTime(now())->save();
            } else {
                $model->setUpdateTime(now())->save();
            }
            // $model->save();
            return $model->getFlatrateId();
        } catch (Exception $e) {}
    }
    public function addsaveFlatrates($params,$id){
        $data['measurementremember_id'] = $id;
        $data['front_id'] = $params['front_id'];
        $data['back_id'] = $params['back_id'];
        $data['sleeve_id'] = $params['sleeve_id'];
        $data['salwar_id'] = $params['salwar_id'];
        $data['lehanga_id'] = $params['lehanga_id'];
        $data['tassel_id'] = $params['tassel_id'];
        $data['measurement_type'] = 'custom';
        $data['measurment_units'] = $params['measurment_units'];
        foreach ($params[$params['service']] as $key => $value) {
            $data[$key] = $value;
        }
        $model = Mage::getModel('measurementremember/flatrates')->setData($data)->setId($params['id'])->save();
        try {
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                $model->setCreatedTime(now())
                        ->setUpdateTime(now());
            } else {
                $model->setUpdateTime(now());
            }
            $model->save();
            return $model->getFlatrateId();
        } catch (Exception $e) {}
    }
    public function saveexistingFlatrates($params,$id){
        $data1 = Mage::getModel('measurementremember/flatrates')->getCollection()->addFieldToFilter('measurementremember_id',$params['existing_measurements'])->getFirstItem()->getData();
        foreach ($data1 as $key => $value) {
            $data[$key] = $value;
        }
        $data['flatrate_id'] = NULL;
        $data['created_time'] = NULL;
        $data['update_time'] = NULL;
        $data['measurementremember_id'] = $id;
        foreach ($params[$params['service']] as $key => $value) {
            $data[$key] = $value;
        }
        $model = Mage::getModel('measurementremember/flatrates')->setData($data)->setId($params['id'])->save();
        try {
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                $model->setCreatedTime(now())
                        ->setUpdateTime(now());
            } else {
                $model->setUpdateTime(now());
            }
            $model->save();
            return $model->getFlatrateId();
        } catch (Exception $e) {}
    }
    public function editFlatrates($params,$id){
        $data['measurementremember_id'] = $id;
        $data['front_id'] = $params['front_id'];
        $data['back_id'] = $params['back_id'];
        $data['sleeve_id'] = $params['sleeve_id'];
        $data['salwar_id'] = $params['salwar_id'];
        $data['lehanga_id'] = $params['lehanga_id'];
        $data['tassel_id'] = $params['tassel_id'];
        $data['measurement_type'] = $params['measurement_type'];
        $data['measurment_units'] = $params['measurment_units'];
        foreach ($params[$params['service']] as $key => $value) {
            $data[$key] = $value;
        }
        $model = Mage::getModel('measurementremember/flatrates')->setData($data)->setId($params['id'])->save();
        try {
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                $model->setCreatedTime(now())
                        ->setUpdateTime(now());
            } else {
                $model->setUpdateTime(now());
            }
            $model->save();
            return $model->getFlatrateId();
        } catch (Exception $e) {}
    }
    public function saveeditFlatrates($params,$id){
        $data['measurementremember_id'] = $id;
        $flatrate = Mage::getModel('measurementremember/flatrates')->getCollection()->addFieldToFilter('measurementremember_id',$params['measurement_id'])->getFirstItem();
        $data['front_id'] = $flatrate->getFrontId();
        $data['back_id'] = $flatrate->getBackId();
        $data['sleeve_id'] = $flatrate->getSleeveId();
        $data['salwar_id'] = $flatrate->getSalwarId();
        $data['lehanga_id'] = $flatrate->getLehangaId();
        $data['tassel_id'] = $flatrate->getTasselId();
        $data['measurement_type'] = 'custom';
        $data['measurment_units'] = $params['measurment_units'];
        foreach ($params[$params['service']] as $key => $value) {
            $data[$key] = $value;
        }
        $model = Mage::getModel('measurementremember/flatrates')->setData($data)->setId($params['id'])->save();
        try {
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                $model->setCreatedTime(now())
                        ->setUpdateTime(now());
            } else {
                $model->setUpdateTime(now());
            }
            $model->save();
            return $model->getFlatrateId();
        } catch (Exception $e) {}
    }
    public function deleteVal($id){
        
    }
}
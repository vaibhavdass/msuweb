<?php 
class Naresh_Mycategory_Block_Product_List extends Mage_Catalog_Block_Product_List {

    protected function _getProductCollection() { // trying to override this method
        if (is_null($this->_productCollection)) {
            $layer = $this->getLayer();
            /* @var $layer Mage_Catalog_Model_Layer */
            if ($this->getShowRootCategory()) {
                $this->setCategoryId(Mage::app()->getStore()->getRootCategoryId());
            }

            // if this is a product view page
            if (Mage::registry('product')) {
                // get collection of categories this product is associated with
                $categories = Mage::registry('product')->getCategoryCollection()
                    ->setPage(1, 1)
                    ->load();
                // if the product is associated with any category
                if ($categories->count()) {
                    // show products from this category
                    $this->setCategoryId(current($categories->getIterator()));
                }
            }

            $origCategory = null;
            if ($this->getCategoryId()) {
                $category = Mage::getModel('catalog/category')->load($this->getCategoryId());
                if ($category->getId()) {
                    $origCategory = $layer->getCurrentCategory();
                    $layer->setCurrentCategory($category);
                    $this->addModelTags($category);
                }
            }
            $this->_productCollection = $layer->getProductCollection();
            // Mage::log($layer->getCurrentCategory()->getId());
            $mycategory = Mage::getSingleton('mycategory/mycategory')->getCollection()
                                    ->addFieldToFilter('category', $layer->getCurrentCategory()->getId())
                                    ->addFieldToFilter('status',1)
                                    ->getFirstItem();
            if(isset($mycategory) && $mycategory->getMycategoryId() > 0) {
                if($mycategory->getProductType() == 2) {
                    $this->_productCollection = Mage::getSingleton('catalog/product')->getCollection()
                                                            ->addAttributeToSelect('*')
                                                            ->addAttributeToFilter('status', 1)
                                                            ->addAttributeToFilter('visibility', 4)
                                                            ->setOrder('name', 'ASC');
                }
                if($mycategory->getSale() == 1) {
                    $todayDate = date('m/d/y');
                    $tomorrow = mktime(0, 0, 0, date('m'), date('d')+1, date('y'));
                    $tomorrowDate = date('m/d/y', $tomorrow);
                    $this->_productCollection->addAttributeToFilter('special_price', array('neq' => ""))
                                            ->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate))
                                            ->addAttributeToFilter('special_to_date', array('or'=> array(
                                                0 => array('date' => true, 'from' => $tomorrowDate),
                                                1 => array('is' => new Zend_Db_Expr('null')))
                                            ), 'left')
                                            ->setOrder('name', 'ASC');
                    // $this->_productCollection->addFinalPrice()
                    //                         ->getSelect()
                    //                         ->where('price_index.final_price < price_index.price');
                }
                if(strlen($mycategory->getAttr1()) > 0 && strlen($mycategory->getAttr1Values()) > 0) {
                    $attr1 = explode(',', $mycategory->getAttr1Values());
                    $this->_productCollection->addAttributeToFilter($mycategory->getAttr1(), array('in' => $attr1));
                }
                if(strlen($mycategory->getAttr2()) > 0 && strlen($mycategory->getAttr2Values()) > 0) {
                    $attr2 = explode(',', $mycategory->getAttr2Values());
                    $this->_productCollection->addAttributeToFilter($mycategory->getAttr2(), array('in' => $attr2));
                }
                if(strlen($mycategory->getAttr3()) > 0 && strlen($mycategory->getAttr3Values()) > 0) {
                    $attr3 = explode(',', $mycategory->getAttr3Values());
                    $this->_productCollection->addAttributeToFilter($mycategory->getAttr3(), array('in' => $attr3));
                }
                if(strlen($mycategory->getAttr4()) > 0 && strlen($mycategory->getAttr4Values()) > 0) {
                    $attr4 = explode(',', $mycategory->getAttr4Values());
                    $this->_productCollection->addAttributeToFilter($mycategory->getAttr4(), array('in' => $attr4));
                }
                if(strlen($mycategory->getAttr5()) > 0 && strlen($mycategory->getAttr5Values()) > 0) {
                    $attr5 = explode(',', $mycategory->getAttr5Values());
                    $this->_productCollection->addAttributeToFilter($mycategory->getAttr5(), array('in' => $attr5));
                }

            }

            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

            if ($origCategory) {
                $layer->setCurrentCategory($origCategory);
            }
        }

        return $this->_productCollection;
    }

}
?>
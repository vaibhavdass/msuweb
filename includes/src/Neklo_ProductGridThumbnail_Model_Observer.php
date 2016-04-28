<?php

class Neklo_ProductGridThumbnail_Model_Observer
{
    public function productGridAddColumn(Varien_Event_Observer $observer)
    {
        if (!$observer->getBlock()) {
            return null;
        }

        if (!$this->isProductGrid($observer->getBlock())) {
            return null;
        }
        $observer->getBlock()->addColumnAfter(
            'thumbnail',
            array(
                'header'   => Mage::helper('neklo_productgridthumbnail')->__('Thumbnail'),
                'index'    => 'thumbnail',
                'width'    => 110,
                'filter'   => false,
                'sortable' => false,
                'renderer' => 'neklo_productgridthumbnail_adminhtml/grid_renderer_thumbnail',
            ),
            'entity_id'
        );
    }

    public function isProductGrid($block)
    {
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Grid) {
            return true;
        }
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Related) {
            return true;
        }
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Upsell) {
            return true;
        }
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Crosssell) {
            return true;
        }
        if ($block instanceof Mage_Adminhtml_Block_Catalog_Category_Tab_Product) {
            return true;
        }
        return false;
    }

    public function productCollectionAddThumbnail(Varien_Event_Observer $observer)
    {
        $observer->getCollection()->addAttributeToSelect('thumbnail');
    }
}
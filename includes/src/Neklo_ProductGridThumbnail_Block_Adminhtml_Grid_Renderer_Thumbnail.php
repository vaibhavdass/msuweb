<?php
class Neklo_ProductGridThumbnail_Block_Adminhtml_Grid_Renderer_Thumbnail extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    const IMAGE_WIDTH = 100;
    const NO_SELECTION = 'no_selection';

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('neklo/productgridthumbnail/grid/renderer/thumbnail.phtml');
    }

    public function render(Varien_Object $row)
    {
        $this->setProduct($row);
        return $this->toHtml();
    }

    public function getImage()
    {
        return $this->getProduct()->getData($this->getColumn()->getIndex());
    }

    public function canRender()
    {
        if (!$this->getImage()) {
            return false;
        }
        if ($this->getImage() === self::NO_SELECTION) {
            return false;
        }
        return true;
    }

    public function setProduct($product)
    {
        return parent::setProduct($product);
    }

    public function getProduct()
    {
        return parent::getProduct();
    }

    public function getImageWidth()
    {
        return self::IMAGE_WIDTH;
    }
}
<?php
class Pwa_PaywithAmazon_Model_Lookup_Options
{
  /**
   * Provide available options as a value/label array
   *
   * @return array
   */
  public function toOptionArray()
  {
    return array(
      array('value'=>'kg', 'label'=>'Kg'),
      array('value'=>'gram', 'label'=>'Gram'),             
    );
  }
}

<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS `product_stitching_services` (
  `service_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `base_currency` varchar(4) NOT NULL,
  `current_currency` varchar(4) NOT NULL,
  `total` decimal(12,4) NOT NULL,
  `base_total` decimal(12,4) NOT NULL,
  `weight` decimal(6,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

    ");

$installer->endSetup(); 
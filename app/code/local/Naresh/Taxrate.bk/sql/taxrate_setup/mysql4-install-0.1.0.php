<?php

$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS `taxrate` (
  `taxrate_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cat_id` text NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `gst_perc` DECIMAL(5,2) unsigned NOT NULL,
  `tax_default_perc` DECIMAL(5,2) unsigned NOT NULL,
  `handling_fee` DECIMAL(11,2) unsigned NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`taxrate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

    ");

$installer->endSetup(); 
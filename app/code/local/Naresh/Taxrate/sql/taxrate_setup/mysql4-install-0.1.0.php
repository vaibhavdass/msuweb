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

CREATE TABLE IF NOT EXISTS `ddp_refference` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `product_id` int(255) NOT NULL,
  `price_inr` float(150,2) NOT NULL,
  `cur_pric` float(150,2) NOT NULL,
  `cur_type` tinytext NOT NULL,
  `order_id` tinytext NOT NULL,
  `autoincrementid` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `taxrate_flatrates` (
  `autotaxrate_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `price_from` varchar(255) NOT NULL,
  `price_to` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `percentage` varchar(255) NOT NULL,
  `taxrate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`autotaxrate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

    ");

$installer->endSetup(); 
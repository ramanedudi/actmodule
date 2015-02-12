<?php
$installer = $this;
$installer->startSetup();

$installer->run("CREATE TABLE `{$installer->getTable('edudi_auction/bid')}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Bid Id',
  `customer_id` int(10) unsigned NOT NULL COMMENT 'Customer Id',
  `entity_id` int(10) unsigned NOT NULL COMMENT 'Product Id',
  `bid_amount` decimal(12,4) NOT NULL COMMENT 'Bid Amount',
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT 'Bid Status',
  PRIMARY KEY (`id`)
)");

$installer->endSetup();
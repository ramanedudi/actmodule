<?php
$installer = $this;

$installer->startSetup();

$installer->run("
CREATE TABLE `{$installer->getTable('edudi_auction/mapping')}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Bid Id',
  `bid_amount` decimal(12,4) NOT NULL COMMENT 'Bid Amount',
  `increment_amount` decimal(12,4) NOT NULL COMMENT 'Increment Amount',
  PRIMARY KEY (`id`)
)
");

$installer->endSetup();
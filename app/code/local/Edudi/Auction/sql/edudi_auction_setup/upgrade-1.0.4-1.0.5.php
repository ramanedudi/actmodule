<?php
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE `{$installer->getTable('edudi_auction/mapping')}` 
ADD COLUMN `bidding_amount_from` decimal(12,4) NOT NULL COMMENT 'Bid Amount FROM'
AFTER `bid_amount`");

$installer->endSetup();
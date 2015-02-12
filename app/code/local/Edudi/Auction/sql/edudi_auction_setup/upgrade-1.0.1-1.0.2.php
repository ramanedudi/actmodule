<?php
$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE {$installer->getTable('edudi_auction/bid')}
ADD COLUMN `bid_id` VARCHAR(255) NOT NULL AFTER `id`,
ADD COLUMN `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`;
");

/* Add attribute group to attribute set */
$productAttributesInfo =
    array(
        'auction_bid_id'                   =>   array(
             'group'                      => 'General',
             'label'                      => 'Auction Bid Id',
             'type'                       => 'varchar',
             'input'                      => 'text',
             'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
             'visible'                    => false,
             'required'                   => false,
             'user_defined'               => true,
             'sort_order'                  => 905,
             'searchable'                 => false,
             'visible_in_advanced_search' => false,
             'used_in_product_listing'    => false,
             'is_configurable'            => false,
             'apply_to'                   => 'simple',
        )
    );

foreach ($productAttributesInfo as $attributeCode => $attributeParams) {
    $installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, $attributeParams);
}

$installer->endSetup();

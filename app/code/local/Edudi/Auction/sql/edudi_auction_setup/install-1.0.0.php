<?php
$installer = $this;

$installer->startSetup();

/* Add attribute group to attribute set */
$productAttributesInfo =
    array(
        'enable_auction'                 => array(
            'group'                      => 'General',
            'label'                      => 'Is In Auction ?',
            'type'                       => 'int',
            'input'                      => 'select',
            'source'                     => 'eav/entity_attribute_source_boolean',
            'visible'                    => true,
            'required'                   => false,
            'user_defined'               => true,
            'sort_order'                 => 900,
            'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
            'searchable'                 => false,
            'visible_in_advanced_search' => false,
            'used_in_product_listing'    => true,
            'is_configurable'            => false,
            'apply_to'                   => 'simple'
        ),
        'auction_end_time'                   =>   array(
             'group'                      => 'General',
             'label'                      => 'Auction Valid Upto',
             'type'                       => 'varchar',
             'input'                      => 'text',
             'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
             'visible'                    => true,
             'required'                   => false,
             'user_defined'               => true,
             'sort_order'                  => 901,
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
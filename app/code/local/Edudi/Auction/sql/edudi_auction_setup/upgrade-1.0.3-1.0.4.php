<?php
$installer = $this;

$installer->startSetup();

/* Add attribute group to attribute set */
$productAttributesInfo =
    array(
        'is_bidding_allowed'                 => array(
            'group'                      => 'General',
            'label'                      => 'Is Bidding Allowed ?',
            'type'                       => 'int',
            'input'                      => 'select',
            'source'                     => 'eav/entity_attribute_source_boolean',
            'visible'                    => true,
            'required'                   => false,
            'user_defined'               => true,
            'sort_order'                 => 903,
            'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
            'searchable'                 => false,
            'visible_in_advanced_search' => false,
            'used_in_product_listing'    => true,
            'is_configurable'            => false,
            'apply_to'                   => 'simple'
        ),
    );

foreach ($productAttributesInfo as $attributeCode => $attributeParams) {
    $installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, $attributeParams);
}

$installer->endSetup();
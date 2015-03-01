<?php
class Edudi_Auction_Block_Adminhtml_Product_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'edudi_auction';
		$this->_controller = 'adminhtml_product_product';
		$this->_headerText = Mage::helper('edudi_auction')->__('Auction Product');
		
		$this->_addButton('btnAdd', array(
        	'label' => Mage::helper('edudi_auction')->__('Add Auction Product'),
        	'onclick' => "setLocation('" . $this->getUrl('*/catalog_product/new/set/4/type/simple/', array('page_key' => 'collection')) . "')",
        	'class' => 'add'
    	));
		parent::__construct();
		
		$this->_removeButton('add');
	}
}
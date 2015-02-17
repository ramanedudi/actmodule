<?php
class Edudi_Auction_Block_Adminhtml_Auction_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();

		$this->_objectId = 'id';
		$this->_blockGroup = 'edudi_auction';
		$this->_controller = 'adminhtml_auction';

		$this->_updateButton('save', 'label', Mage::helper('edudi_auction')->__('Save Item'));
		$this->_updateButton('delete', 'label', Mage::helper('edudi_auction')->__('Delete Item'));
	}

	public function getHeaderText()
	{
		if( Mage::registry('edudi_auction_data') && Mage::registry('edudi_auction_data')->getId() ) {
			return Mage::helper('edudi_auction')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('edudi_auction_data')->getTitle()));
		} else {
			return Mage::helper('edudi_auction')->__('Add Item');
		}
	}
}
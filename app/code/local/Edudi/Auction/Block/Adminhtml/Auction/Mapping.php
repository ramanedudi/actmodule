<?php
class Edudi_Auction_Block_Adminhtml_Auction_Mapping extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'edudi_auction';
		$this->_controller = 'adminhtml_auction_mapping';
		$this->_headerText = Mage::helper('edudi_auction')->__('Auction Increment Mapping');

		parent::__construct();
	}
}
<?php
class Edudi_Auction_Model_Resource_Bid extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		$this->_init('edudi_auction/bid', 'id');
	}
}
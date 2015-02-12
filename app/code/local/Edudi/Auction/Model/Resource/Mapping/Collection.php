<?php
class Edudi_Auction_Model_Resource_Mapping_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('edudi_auction/mapping');
	}
}
<?php
class Edudi_Auction_Model_Bid extends Mage_Core_Model_Abstract
{
	protected function _construct()
	{
		$this->_init('edudi_auction/bid');
	}

	public function loadByCustomerProduct($customerId=null, $productId=null, $bidId=null)
	{
		$collection = $this->getCollection()
			->addFieldToFilter('customer_id', $customerId)
			->addFieldToFilter('entity_id', $productId)
			->addFieldToFilter('bid_id', $bidId)
			->setPageSize(1);

		if ($collection->getData()) {
			$model = $collection->getFirstItem();
			return $model;
		}
		return $this;
	}
}
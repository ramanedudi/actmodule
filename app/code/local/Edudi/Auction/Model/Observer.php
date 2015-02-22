<?php
class Edudi_Auction_Model_Observer
{
	public function saveAuctionExpiry(Varien_Event_Observer $observer)
	{
		$product = $observer->getEvent()->getProduct();
		$isEnabled = (bool) $product->getEnableAuction();
		if ($isEnabled) {
			$date=date_create(date('d-m-Y H:i:s'));
			date_add($date,date_interval_create_from_date_string("72 hours"));
			$product->setAuctionEndTime(date_format($date,"d-m-Y H:i:s"));
			$product->setAuctionBidId(microtime(true));
		}
	}
	
	public function getBidWinners()
	{
		$collection = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect('auction_bid_id')
			->addAttributeToFilter('auction_end_time', array('lt' => date('d-m-Y H:i:s')))
			->addAttributeToFilter('enable_auction', 1)
			->addAttributeToFilter('is_bidding_allowed', 1);
		
		$product = Mage::getModel('catalog/product');
		foreach ($collection as $_product) {
			$product->load($_product->getEntityId());
			Mage::helper('edudi_auction')->disableAuction($product);
		}
	}
}
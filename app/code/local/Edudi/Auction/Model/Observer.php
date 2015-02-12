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
}
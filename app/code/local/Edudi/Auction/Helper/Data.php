<?php
class Edudi_Auction_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getProductCollection()
	{
		$collection = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect('*')
			->addAttributeToFilter('enable_auction', 1);
		return $collection;
	}

	public function getSubmitUrl($product)
	{
		$url = Mage::getBaseUrl() . 'eauction/index/placebid/product/' . $product->getId();

		return $url;
	}

	public function getLoginCheckUrl()
	{
		return Mage::getUrl('eauction/index/checkLogin');
	}

	public function getBiddingUpdates()
	{
		return Mage::getUrl('eauction/index/getUpdates');
	}

	public function getSuggestedPrice($price)
	{
		$collection = Mage::getModel('edudi_auction/mapping')->getCollection()
			->addFieldToFilter('bid_amount', array('lt' => $price))
			->setOrder('bid_amount', 'DESC')
			->setPageSize(1);

		$data = $collection->getFirstItem();

		if ($data) {
			return ($price + $data->getIncrementAmount());
		}

		return ($price + 25);
	}

	public function isAllowedBidding($product=null)
	{
		if ($product)
		{
			if ($product->getIsBiddingAllowed()) {
				return true;
			}
		}

		return false;
	}

	public function disableAuction($product=null)
	{
		if ($product) {
			try {
				Mage::getModel('edudi_auction/bid')->announceWinner($product);
				$product->setIsBiddingAllowed(0);
				$product->save();
			} catch (Exception $e) {
				Mage::logException($e);
			}
		}
	}
}
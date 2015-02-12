<?php
class Edudi_Auction_Block_Bid extends Mage_Core_Block_Template
{
	public function getProduct()
	{
		$postData = $this->getRequest()->getPost();
		$productId = $postData['product'];

		if ($productId) {
			return Mage::getModel('catalog/product')->load($productId);
		}

		return 0;
	}

	public function getSubmitUrl()
	{
		$url = Mage::getBaseUrl() . 'eauction/index/confirmbid';
		return $url;
	}
	
	public function allowBidding($product=null)
	{
		$collection = Mage::getModel('edudi_auction/bid')->getCollection()
			->addFieldToFilter('bid_id', $product->getAuctionBidId())
			->addFieldToFilter('entity_id', $product->getId())
			->setOrder('created_at', 'DESC')
			->setPageSize(1);
		
		if ($collection) {
			$model = $collection->getFirstItem();
			$customerId = Mage::getSingleton('customer/session')->getCustomerId();
			if ($model->getCustomerId() == $customerId) {
				return false;
			}
		}
		
		return true;
	}
	
	public function getBidCount($product=null)
	{
		$collection = Mage::getModel('edudi_auction/bid')->getCollection()
			->addFieldToSelect('id')
			->addFieldToFilter('bid_id', $product->getAuctionBidId())
			->addFieldToFilter('entity_id', $product->getId())
			->getSize();	
		return $collection;
	}
}
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

	public function announceWinner($product=null)
	{
		if ($product) {
			$bidId = $product->getAuctionBidId();

			$collection = $this->getCollection()
			->addFieldToFilter('bid_id', $bidId)
			->addFieldToFilter('entity_id', $product->getId())
			->addFieldToFilter('status', 0)
			->setOrder('created_at', 'DESC')
			->setPageSize(1);

			$data = $collection->getFirstItem();

			if ($data->getBidId()) {
				$customerSession = null;

				if(Mage::getSingleton('customer/session')->isLoggedIn()) {
					$customerSession = Mage::getSingleton('customer/session');
			     	$customerSesId = $customerSession->getCustomer()->getId();
				}

				$customerId = $data->getCustomerId();
				$customer = Mage::getModel('customer/customer')->load($customerId);
				$data->setStatus(1)->save();

				$buyRequest = array('qty' => 1);
				if ($customerId == $customerSesId) {
					$cart = Mage::getSingleton('checkout/cart');
					$cart->init();
					$cart->addProduct($product, $buyRequest);
					$customerSession->setCartWasUpdated(true);
					$cart->save();
				} else {
					$quote = Mage::getModel('sales/quote')->setStoreId(Mage::app()->getStore('default')->getId());
					$quote->assignCustomer($customer);
					$quote->addProduct($product, new Varien_Object($buyRequest));
					$quote->collectTotals()->save();
				}
				
				Mage::helper('edudi_auction')->sendWinnerEmailNotification($customer, $product, $data);
				
			}

		}
	}
}
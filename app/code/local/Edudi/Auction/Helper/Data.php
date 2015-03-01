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
			->addFieldToFilter('bidding_amount_from', array('lt' => $price))
			->setOrder('bidding_amount_from', 'DESC')
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
	
	public function sendWinnerEmailNotification($customer=null, $product=null, $bidModel)
	{
		/*
		 * Loads the html file named 'auction_winner_template.html' from
		 * app/locale/en_US/template/email/auction_winner_email.html
		 */ 
		$emailTemplate  = Mage::getModel('core/email_template')->loadDefault('auction_winner_template');
		 
		//Create an array of variables to assign to template
		$winnerVars = array();
		$winnerVars['customer_name'] = $customer->getFirstname() . ' ' . $customer->getLastname();
		$winnerVars['product'] = $product;
		$winnerVars['product_price'] = Mage::helper('core')->currency($product->getPrice(), true, false);
		$winnerVars['bid_details'] = $bidModel;

		/**
		 * The best part :)
		 * Opens the activecodeline_custom_email1.html, throws in the variable array 
		 * and returns the 'parsed' content that you can use as body of email
		 */
		$processedTemplate = $emailTemplate->getProcessedTemplate($winnerVars);
		 
		/*
		 * Or you can send the email directly, 
		 * note getProcessedTemplate is called inside send()
		 */
		$emailTemplate->send($customer->getEmail(),$winnerVars['customer_name'], $winnerVars);
	}
	
	public function sendOutBidEmail($product=null, $bidId=null)
	{
		$collection = Mage::getModel('edudi_auction/bid')->getCollection()
			->addFieldToFilter('entity_id', $product->getId())
			->addFieldToFilter('bid_id', $bidId)
			->setPageSize(1);

		$data = $collection->getFirstItem();

		if ($data->getId()) {
			$customerId = Mage::getSingleton('customer/session')->getCustomerId();
			$bidCustId = $data->getCustomerId();
			
			if ($customerId != $bidCustId) {
				$customer = Mage::getModel('customer/customer')->load($bidCustId);
				/*
				 * Loads the html file named 'auction_outbid_template.html' from
				 * app/locale/en_US/template/email/auction_outbid_email.html
				 */ 
				$emailTemplate  = Mage::getModel('core/email_template')->loadDefault('auction_outbid_template');
				 
				//Create an array of variables to assign to template
				$winnerVars = array();
				$winnerVars['customer_name'] = $customer->getFirstname() . ' ' . $customer->getLastname();
				$winnerVars['product'] = $product;
				$winnerVars['product_price'] = Mage::helper('core')->currency($product->getPrice(), true, false);
				$winnerVars['bid_details'] = $data;
		
				$processedTemplate = $emailTemplate->getProcessedTemplate($winnerVars);
				 
				$emailTemplate->send($customer->getEmail(),$winnerVars['customer_name'], $winnerVars);
			}
		}
	}
}
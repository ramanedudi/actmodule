<?php
class Edudi_Auction_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}

	public function placebidAction()
	{
		if ($this->getRequest()->getPost() && $this->getRequest()->isAjax()) {
			$postData = $this->getRequest()->getPost();
			$this->loadLayout();
			$this->renderLayout();
		}
	}

	public function confirmbidAction()
	{
		if ($this->getRequest()->getPost() && $this->getRequest()->isAjax()) {
			$postData = $this->getRequest()->getPost();
			$response = array();

			if (!Mage::helper('customer')->isLoggedIn()) {
				$response['returnUrl'] = Mage::getUrl('customer/account');
				Mage::getSingleton('customer/session')->addNotice("Please login to place Bid.");
				echo json_encode($response); exit;
			}

			try {
				$customerId = Mage::getSingleton('customer/session')->getCustomerId();
				$product = Mage::getModel('catalog/product')->load($postData['product_id']);
				$bidAmount = $postData['confirmbidamount'];
				$finalPrice = $product->getPrice();
				if ($bidAmount > $finalPrice) {
					$productId = $product->getId();
					$bidId = $product->getAuctionBidId();
					$model = Mage::getModel('edudi_auction/bid')->loadByCustomerProduct($customerId, $productId, $bidId);
					if ($model->getId()) {
						$model->setBidAmount($bidAmount);
						$model->setCreatedAt(date('Y-m-d H:i:s'));
					} else {
						$model->setCustomerId($customerId);
						$model->setEntityId($product->getId());
						$model->setBidAmount($bidAmount);
						$model->setBidId($bidId);
						$model->setCreatedAt(date('Y-m-d H:i:s'));
					}
					$model->save();

					$product->setPrice($bidAmount);
					$product->save();
					Mage::getSingleton('customer/session')->addSuccess("Bid placed successfully.");
					$response['msg'] = "Bid placed successfully.";
					$response['status'] = true;
				} else {
					$response['msg'] = "Please place higher Bid Amount.";
					$response['status'] = false;
				}



				echo json_encode($response); exit;
			} catch(Exception $e) {
				Mage::logException($e);
			}
		}
	}

	public function checkLoginAction()
	{
		if (!Mage::helper('customer')->isLoggedIn()) {
			$returnUrl = Mage::getUrl('customer/account');
			Mage::getSingleton('customer/session')->addNotice("Please login to place Bid.");
			echo json_encode($returnUrl); exit;
		}

		echo json_encode(true); exit;
	}

	public function testAction()
	{
		$collection = Mage::getModel('edudi_auction/bid')->getCollection();

		foreach ($collection as $_data)
		{
			echo '<pre>'; print_r($_data->getData());
		}
	}

	public function getUpdatesAction()
	{
		if ($this->getRequest()->getPost() && $this->getRequest()->isAjax()) {
			$postData = $this->getRequest()->getPost();
			$productId = $postData['product_id'];
			$result = array();

			$product = Mage::getModel('catalog/product')->load($productId);
			$suggestedPrice = Mage::helper('edudi_auction')->getSuggestedPrice($product->getPrice());
			$result['price'] = Mage::helper('core')->currency($product->getPrice(), true, false);
			$result['bidprice'] = Mage::helper('core')->currency($suggestedPrice, true, false);
			$result['suggestedprice'] = $suggestedPrice;
			echo json_encode($result);
		}
	}
}
<?php
class Edudi_Auction_Adminhtml_MappingController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('auctionmapping/auctionmapping')
		->_title($this->__('Auction'))->_title($this->__('Auction Increment Mapping'))
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Mapping Manager'), Mage::helper('adminhtml')->__('Mapping Manager'));
		return $this;
	}

	public function indexAction()
	{
		$this->_initAction();
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('edudi_auction/adminhtml_auction_mapping'));
        $this->renderLayout();
	}

	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('edudi_auction/adminhtml_auction_mapping_grid')->toHtml()
		);
	}

	public function editAction()
	{
		$mapId     = $this->getRequest()->getParam('id');
		$mapModel  = Mage::getModel('edudi_auction/mapping')->load($mapId);

		if ($mapModel->getId() || $mapId == 0) {

			Mage::register('edudi_auction_data', $mapModel);

			$this->loadLayout();
			$this->_setActiveMenu('auctionmapping/auctionmapping');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Mapping Manager'), Mage::helper('adminhtml')->__('Mapping Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Increment Map'), Mage::helper('adminhtml')->__('Increment Map'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('edudi_auction/adminhtml_auction_edit'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('edudi_auction')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function saveAction()
	{
		if ( $this->getRequest()->getPost() ) {
			try {
				$postData = $this->getRequest()->getPost();
				$mapModel = Mage::getModel('edudi_auction/mapping');

				$mapModel->setId($this->getRequest()->getParam('id'))
				->setBiddingAmountFrom($postData['bidding_amount_from'])
				->setBidAmount($postData['bid_amount'])
				->setIncrementAmount($postData['increment_amount'])
				->save();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setEdudiAuctionData(false);

				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setEdudiAuctionData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		$this->_redirect('*/*/');
	}

	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$mapModel = Mage::getModel('edudi_auction/mapping');

				$mapModel->setId($this->getRequest()->getParam('id'))
				->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
}
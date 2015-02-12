<?php
class Edudi_Auction_Adminhtml_MappingController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->_title($this->__('Auction'))->_title($this->__('Auction Increment Mapping'));
        $this->loadLayout();
        $this->_setActiveMenu('auctionmapping/auctionmapping');
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
}
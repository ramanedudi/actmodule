<?php
class Edudi_Auction_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('auctionmapping/auctionmapping')
		->_title($this->__('Auction'))->_title($this->__('Auction Products'))
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Auction Products'), Mage::helper('adminhtml')->__('Auction Products'));
		return $this;
	}
	
	public function indexAction()
	{
		$this->_initAction();
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('edudi_auction/adminhtml_product_product'));
        $this->renderLayout();
	}
}
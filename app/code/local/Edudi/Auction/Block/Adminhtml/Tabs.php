<?php
class Edudi_Auction_Block_Adminhtml_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs
{
	protected function _prepareLayout()
	{
		$parent = parent::_prepareLayout();
		$this->addTab('edudi_auction', array(
			'label' => Mage::helper('edudi_auction')->__('Auction Bidders'),
			'content' => $this->getLayout()->createBlock('edudi_auction/adminhtml_tabs_bidders')->toHtml()
		));
		
		return $parent;
	}
}
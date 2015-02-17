<?php
class Edudi_Auction_Block_Adminhtml_Auction_Mapping_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('edudi_auction_grid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('edudi_auction/mapping')->getCollection();
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}

	protected function _prepareColumns()
	{
		$helper = Mage::helper('edudi_auction');

		$this->addColumn('id', array(
				'header' => $helper->__('MapId #'),
				'index'  => 'id'
		));

		$this->addColumn('bid_amount', array(
				'header' => $helper->__('Bid Amount'),
				'index'  => 'bid_amount'
		));

		$this->addColumn('increment_amount', array(
				'header' => $helper->__('Increment Amount'),
				'index'  => 'increment_amount'
		));

		return parent::_prepareColumns();
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}
<?php
class Edudi_Auction_Block_Adminhtml_Auction_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
		)
		);

		$form->setUseContainer(true);
		$this->setForm($form);

		$fieldset = $form->addFieldset('edudi_auction_form', array('legend'=>Mage::helper('edudi_auction')->__('Item information')));

		$fieldset->addField('bid_amount', 'text', array(
				'label'     => Mage::helper('edudi_auction')->__('Bid Amount'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'bid_amount',
		));

		$fieldset->addField('increment_amount', 'text', array(
				'label'     => Mage::helper('edudi_auction')->__('Increment Amount'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'increment_amount',
		));


		if ( Mage::getSingleton('adminhtml/session')->getEdudiAuctionData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getEdudiAuctionData());
			Mage::getSingleton('adminhtml/session')->setEdudiAuctionData(null);
		} elseif ( Mage::registry('edudi_auction_data') ) {
			$form->setValues(Mage::registry('edudi_auction_data')->getData());
		}
		return parent::_prepareForm();
		}
}
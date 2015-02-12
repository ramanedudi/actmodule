<?php
class Edudi_Auction_Block_Adminhtml_Tabs_Bidders extends Mage_Adminhtml_Block_Widget
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('edudi/catalog/product/bidders.phtml');
	}	
    
    public function getBidders()
    {
    	$request = Mage::app()->getRequest()->getParams();
        $pid = (isset($request['id']) ? $request['id'] : '');
        $collection = Mage::getModel('edudi_auction/bid')->getCollection()
        	->addFieldToFilter('main_table.entity_id', $pid);
        
        $collection->getSelect()  
         ->join(array('cust' => 'customer_entity'),'main_table.customer_id = cust.entity_id','cust.email')
         ->order('main_table.created_at DESC');

        return $collection;
    }
}
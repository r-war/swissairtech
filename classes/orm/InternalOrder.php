<?php

require 'orm/om/BaseInternalOrder.php';


/**
 * Skeleton subclass for representing a row from the 'internal_order' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class InternalOrder extends BaseInternalOrder {

	/**
	 * Initializes internal state of InternalOrder object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getStatusView()
	{
		switch ($this->getStatus())
		{
			case 1 : 
				return 'Pending';
				break;
			case 2 : 
				return 'Processed';
				break;
			case 3 : 
				return 'Processed';
				break;
			case 4 : 
				return 'Delivered';
				break;
			case 9 : 
				return 'Cancelled';
				break;
		}
	}
	
	public function getPriceView()
	{
		return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getPrice());
	}
	
	public function getDiscView()
	{
		return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getDisc());
	}
	
	public function getShippingCostView()
	{
		return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getShippingCost());
	}
		
	public function getTotalView()
	{
		return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getTotal());
	}
	
	public function getPaymentViewNumeric()
	{
		switch ($this->getPayment())
		{
			case 1 :
				return 'Credit Card';
				break;
			case 2 :
				return 'Bank Transfer';
				break;
			case 2 :
				return 'Cheque';
				break;
		}
	}
	
	public function getPaypalDatas()
	{
		if($this->getPaypalData())
		{
			$aData = json_decode($this->getPaypalData(), true);
			if(is_array($aData))
				return $aData;
		}
		
		return false;
	}
	
	public function getPaypalStatus($bInfo = false)
	{
		if($aData = $this->getPaypalDatas())
		{
			if($aData['ACK'] == 'Success')
			{
				if(!$bInfo)
					return true;
				else
					return 'Success ('.$aData['PAYMENTSTATUS'].')';
			}
		}
	}
	
	public function getTransactionId()
	{
		if($aData = $this->getPaypalData())
		{
			return $aData['TRANSACTIONID'];
		}
	}
	
	public function getBeforeGst()
	{
		return $this->getPrice() / 1.07;
	}
	
	public function getBeforeGstView()
	{
		return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getBeforeGst());
	}
	
	public function getGst()
	{
		return $this->getPrice()-($this->getBeforeGst());
	}
	
	public function getGstView()
	{
		return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getGst());
	}

} // InternalOrder

<?php

require 'orm/om/BaseOrderDetail.php';


/**
 * Skeleton subclass for representing a row from the 'order_detail' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class OrderDetail extends BaseOrderDetail {

	/**
	 * Initializes internal state of OrderDetail object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getPriceView()
	{
		if($this->getPrice())
			return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getPrice());
	}
	
	public function getSubTotal()
	{
		return $this->getPrice() * $this->getQty();
	}
	
	public function getSubTotalView()
	{
		if($this->getSubTotal())
			return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getSubTotal());
	}
	
	public function getThumbnailURL($iWidth = null, $iHeight = null, $bFixedSize = false)
	{
		$oProductDetail = $this->getProductDetail();

		if($oProductDetail instanceof ProductDetail)
			return $oProductDetail->getThumbnailURL($iWidth, $iHeight, $bFixedSize);
	}
	
	public function getProductName()
	{
		$oProduct = $this->getProduct();
		if($oProduct instanceof Product)
			$sName = $oProduct->getName();
	 	
		$oProductDetail = $this->getProductDetail();
		if($oProductDetail instanceof ProductDetail)
		{
			if($sName != $oProductDetail->getName())
			{
				$sName .= ' - '.$oProductDetail->getName();
				if($oProductDetail->getName2() && $oProductDetail->getName2() != '-')
					$sName .= ' - '.$oProductDetail->getName2();
			}	
			$sName .= ' ['.$oProductDetail->getSku().']';
		}		
			
	 	return $sName;	
	}
	
	public function getTotalWeight()
	{
		$oProductDetail = $this->getProductDetail();
		if($oProductDetail instanceof ProductDetail)
			return $oProductDetail->getNetweight() * $this->getQty();
	}
	
	public function getProduct()
	{
		$oProductDetail = $this->getProductDetail();
		if($oProductDetail instanceof ProductDetail)
			return $oProductDetail->getProduct();
	}
	
	public function getProductId()
	{
		$oProduct = $this->getProduct();
		if($oProduct instanceof Product)
			return $oProduct->getId();
	}
} // OrderDetail

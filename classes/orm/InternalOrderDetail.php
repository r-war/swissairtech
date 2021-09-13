<?php

require 'orm/om/BaseInternalOrderDetail.php';


/**
 * Skeleton subclass for representing a row from the 'internal_order_detail' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class InternalOrderDetail extends BaseInternalOrderDetail {

	/**
	 * Initializes internal state of InternalOrderDetail object.
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
				$sName .= ' - '.$oProductDetail->getName();
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
} // InternalOrderDetail

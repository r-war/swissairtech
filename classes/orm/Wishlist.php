<?php

require 'orm/om/BaseWishlist.php';


/**
 * Skeleton subclass for representing a row from the 'wishlist' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Wishlist extends BaseWishlist {

	/**
	 * Initializes internal state of Wishlist object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getProduct()
	{
		$oProductDetail = $this->getProductDetail();
		if($oProductDetail instanceof ProductDetail)
			return $oProductDetail->getProduct();
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
} // Wishlist

<?php

require 'orm/om/BasePromoProduct.php';


/**
 * Skeleton subclass for representing a row from the 'promo_product' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class PromoProduct extends BasePromoProduct {

	/**
	 * Initializes internal state of PromoProduct object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}
	
	public function getName()
	{
		$oProduct = $this->getProduct();
		if($oProduct instanceof Product)
			return $oProduct->getName();
	}

} // PromoProduct

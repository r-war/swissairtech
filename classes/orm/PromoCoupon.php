<?php

require 'orm/om/BasePromoCoupon.php';


/**
 * Skeleton subclass for representing a row from the 'promo_coupon' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class PromoCoupon extends BasePromoCoupon {

	/**
	 * Initializes internal state of PromoCoupon object.
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
		return $this->getCode();
	}
	
	public function getUnlimitedView()
	{
		if($this->getUnlimited())
			return 'Yes';
		else
			return 'No';
	}
} // PromoCoupon

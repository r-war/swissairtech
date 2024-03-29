<?php

require 'orm/om/BaseProductPrice.php';


/**
 * Skeleton subclass for representing a row from the 'product_price' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductPrice extends BaseProductPrice {

	/**
	 * Initializes internal state of ProductPrice object.
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
		else
			return 'POA';
	}

} // ProductPrice

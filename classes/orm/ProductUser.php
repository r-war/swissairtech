<?php

require 'orm/om/BaseProductUser.php';


/**
 * Skeleton subclass for representing a row from the 'product_user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductUser extends BaseProductUser {

	/**
	 * Initializes internal state of ProductUser object.
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
		return $this->getUserName().' - '.$this->getProductName();
	}

	public function getProductName()
	{
		$oProduct = $this->getProduct();
		if($oProduct instanceof Product)
			return $oProduct->getName();
	}
	
	public function getUserName()
	{
		$oUser = $this->getUser();
		if($oUser instanceof User)
			return $oUser->getName();
	}

} // ProductUser

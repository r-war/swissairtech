<?php

require 'orm/om/BaseUser.php';


/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class User extends BaseUser {

	/**
	 * Initializes internal state of User object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function save(PropelPDO $con = null)
	{
		if($this->isNew() || $this->isColumnModified(UserPeer::PASSWORD))
		{
			if(strlen($this->getPassword()) == 0)
			{
				$this->resetModified(UserPeer::PASSWORD);
			}
			else
			{
				$this->setPassword(md5($this->getPassword()));
			}
		}
		return parent::save($con);
	}
	
	public function getTotalOrder()
	{
		$oCrit = new Criteria();
		$oCrit->add(OrderHeaderPeer::STATUS, 2);
		$aOrder = $this->getOrderHeaders($oCrit);
		$sTotal = 0;
		foreach($aOrder as $oOrder)
		{
			$sTotal += $oOrder->getTotal();
		}
		return $sTotal;
	}
	
	public function getTotalOrderView()
	{
		return ConfigurationPeer::getCurrency().' '.$this->getTotalOrder();
	}
	
	public function countProperty()
	{
		$oCrit = new Criteria();
		$oCrit->add(ProductUserPeer::USER_ID, $this->getId());
		return ProductUserPeer::doCount($oCrit);
	}
} // User

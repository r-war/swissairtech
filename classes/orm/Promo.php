<?php

require 'orm/om/BasePromo.php';


/**
 * Skeleton subclass for representing a row from the 'promo' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Promo extends BasePromo {

	/**
	 * Initializes internal state of Promo object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getDiscTypeView()
	{
		switch($this->getDiscType())
		{
			case 1 :
				$sName = 'Promo Product';
				break;
			case 2 :
				$sName = 'Promo Coupon';
				break;
		}
		
		if($sName)
			return $sName;
	}
	
	public function getUrl()
	{
		if(Attributes::REWRITE)
			return $sUrl.'/'.$this->getId().'-'.Common::parseSaveURLString($this->getName());
		else
			return $sUrl.'&id='.$this->getId();
	}
	
	
} // Promo

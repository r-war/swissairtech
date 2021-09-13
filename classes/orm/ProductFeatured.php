<?php

require 'orm/om/BaseProductFeatured.php';


/**
 * Skeleton subclass for representing a row from the 'product_featured' table.
 *
 * Featured Product Table
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductFeatured extends BaseProductFeatured {

	/**
	 * Initializes internal state of ProductFeatured object.
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
	
	public function getPicture($sType)
	{
		$sExtra = $this->getExtra();
		if($sExtra)
		{
			$aExtra = json_decode($sExtra,true);
			if(isset($aExtra[$sType]))
				return $aExtra[$sType];
		}
	}
	
	public function getPicUrl($sType)
	{
		$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$this->getPicture($sType);
		if(is_file($sFile))
		{
			return '/'.$sFile;
		}
	}
	
	public function isFeatured()
	{
		if($this->getType() == 'featured_apps')
			return true;
	}
	
	public function getUrl()
	{
		$oProduct = $this->getProduct();
		
		$sName = Common::parseSaveURLString($oProduct->getName()).'.html';
		return '/'.$oProduct->getId().'/'.$sName;
	}
	
	
	
} // ProductFeatured

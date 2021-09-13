<?php

require 'orm/om/BaseConfiguration.php';


/**
 * Skeleton subclass for representing a row from the 'configuration' table.
 *
 * Configuration Table
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Configuration extends BaseConfiguration {

	/**
	 * Initializes internal state of Configuration object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getJsonData($sType = null)
	{
		if($this->getValue())
		{
			$aData = json_decode($this->getValue(), true);
			if($sType)
				return $aData[$sType];
			else
				return $aData;
		}
		else
		{
			if($sType) return '';
			else return array();
		}
			
	}
	
	public function getFileUrl()
	{
		if($sFile = $this->getJsonData('file'))
		{
			$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$sFile;
			if(is_file($sFile))
			{
				return '/'.$sFile;
			}
			return false;
		}
	}
	
} // Configuration

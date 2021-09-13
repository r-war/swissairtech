<?php

require 'orm/om/BaseConfigurationPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'configuration' table.
 *
 * Configuration Table
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ConfigurationPeer extends BaseConfigurationPeer {
	
	const FILE_TYPE_IMAGE = 'jpg,jpeg,png,gif,bmp';
	const FILE_TYPE_DOCUMENT = 'pdf,zip,rar,doc';
	
	static function getAll()
	{
		$oCrit = new Criteria();
		
		return self::doSelect($oCrit);
	}
	
	static function getByDomain($sDomain)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::DOMAIN, $sDomain);
		
		return self::doSelect($oCrit);
	}
	
	static function getByDomainAndKey($sDomain,$sKey)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::DOMAIN, $sDomain);
		$oCrit->add(self::KEY_NAME, $sKey);
		
		return self::doSelectOne($oCrit);
	}
	
	static function getValueByDomainAndKey($sDomain,$sKey)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::DOMAIN, $sDomain);
		$oCrit->add(self::KEY_NAME, $sKey);
		
		$oConf = self::doSelectOne($oCrit);
		if($oConf instanceof Configuration)
			return $oConf->getValue();
	}
	
	static function getValueByKey($sKey)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::KEY_NAME, $sKey);
		
		$oConf = self::doSelectOne($oCrit);
		if($oConf instanceof Configuration)
			return $oConf->getValue();
	}	
	
	static function getCurrency()
	{
		$oConf = self::getByDomainAndKey(Attributes::CONFIG_WEB, 'currency');
		if($oConf instanceof Configuration)
			return $oConf->getValue();
	}
} // ConfigurationPeer

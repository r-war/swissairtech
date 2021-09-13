<?php

require 'orm/om/BasePasswordPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'password' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class PasswordPeer extends BasePasswordPeer {

	static function getByUser(User $oUser, PropelPDO $con = null)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::USER_ID, $oUser->getId());
	
		return self::doSelectOne($oCrit, $con);
	}
	
	static function getByCode($sCode, PropelPDO $con = null)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::CODE, $sCode);
	
		return self::doSelectOne($oCrit, $con);
	}
} // PasswordPeer

<?php

require 'orm/om/BaseUserPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class UserPeer extends BaseUserPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addAscendingOrderByColumn(self::ID);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::EMAIL , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCriterion->addOr($oCrit->getNewCriterion(self::PHONE , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
		}
		
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function validateLogin($sUsername = null, $sPassword = null, PropelPDO $con = null)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::EMAIL, $sUsername);
		$oCrit->add(self::PASSWORD, md5($sPassword));
	
		return self::doSelectOne($oCrit, $con);
	}
	
	static function getByEmail($sUsername = null, PropelPDO $con = null)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::EMAIL, $sUsername);
	
		return self::doSelectOne($oCrit, $con);
	}
} // UserPeer

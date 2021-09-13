<?php

require 'orm/om/BaseSubscriberPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'subscriber' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class SubscriberPeer extends BaseSubscriberPeer {

static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
// 		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addAscendingOrderByColumn(self::NAME);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCrit->add(self::NAME, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getByNameAndEmail($sName, $sEmail)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::NAME, $sName);
		$oCrit->add(self::EMAIL, $sEmail);
		
		return self::doSelectOne($oCrit);
	}
	
	static function getByEmail($sEmail)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::EMAIL, $sEmail);
	
		return self::doSelectOne($oCrit);
	}
	
} // SubscriberPeer

<?php

require 'orm/om/BaseServicePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'service' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ServicePeer extends BaseServicePeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addAscendingOrderByColumn(self::INDEX);
	
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
	
	static function getByCode($sCode)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::CODE, $sCode);
		
		return self::doSelectOne($oCrit);
	}
} // ServicePeer

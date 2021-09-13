<?php

require 'orm/om/BaseNewsPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'news' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class NewsPeer extends BaseNewsPeer {
		
	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addDescendingOrderByColumn(self::DATE);
	
		if($oParam instanceof Parameter)
		{
			if ($oParam->isExists('type')) {
				$oCrit->add(self::TYPE, $oParam->get('type'));
			}

			if ($oParam->isExists('keywords')) {
				$oCrit->add(self::NAME, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
		}

		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}

	static function getByType($type = 'news', Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		if ( empty($type) )
			$type = 'news';
		$oParam->set('type', $type);
		return static::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function getByCode($sCode)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::CODE, $sCode);
		
		return self::doSelectOne($oCrit);
	}
} // NewsPeer

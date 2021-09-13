<?php

require 'orm/om/BaseBlogPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'blog' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class BlogPeer extends BaseBlogPeer {
	
	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
// 		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addDescendingOrderByColumn(self::DATE);
		// $oCrit->addDescendingOrderByColumn(self::ID);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCrit->add(self::NAME, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
			if($oParam->isExists('month') && $oParam->isExists('year'))
			{
				$oDate = new DateTime($oParam->get('year').'-'.$oParam->get('month').'-01');
				$sStart = $oDate->format('Y-m-').'01 00:00:00';
				$oDate->modify('+1 month');
				$sEnd = $oDate->format('Y-m-').'01 00:00:00';

				$oCrit->add(self::DATE,$sStart,Criteria::GREATER_EQUAL);
				$oCrit->addAnd(self::DATE,$sEnd,Criteria::LESS_THAN);
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
	
	
	static function getArchives()
	{
		$oCrit = new Criteria();
		$oCrit->addDescendingOrderByColumn(self::DATE);
		$oCrit->addGroupByColumn('MONTH('.self::DATE.')-'.'YEAR('.self::DATE.')');
		
		$aList = self::getList($oCrit);
		return $aList;
	}
	
	static function countSameMonth(Blog $oBlog)
	{
		$oDate = new DateTime($oBlog->getDate('Y-m-').'01');
		$sStart = $oDate->format('Y-m-').'01 00:00:00';
		$oDate->modify('+1 month');
		$sEnd = $oDate->format('Y-m-').'01 00:00:00';
		
		$oCrit = new Criteria();
		$oCrit->add(self::DATE,$sStart,Criteria::GREATER_EQUAL);
		$oCrit->addAnd(self::DATE,$sEnd,Criteria::LESS_THAN);
		
		return self::doCount($oCrit);
	}
	
} // BlogPeer

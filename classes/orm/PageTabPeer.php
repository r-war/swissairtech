<?php

require 'orm/om/BasePageTabPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'page_tab' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class PageTabPeer extends BasePageTabPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();
	
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addAscendingOrderByColumn(self::NAME);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::INDEX , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('pageid'))
			{
				$oCrit->add(self::PAGE_ID, $oParam->get('pageid'));
			}
			elseif($oParam->isExists('pageidarray'))
			{
				$oCrit->add(self::PAGE_ID, $oParam->get('pageidarray'), Criteria::IN);
			}
			if($oParam->isExists('idnot'))
			{
				$oCrit->add(self::ID, $oParam->get('idnot'), Criteria::NOT_EQUAL);
			}
	
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getByPage($oPage = null , Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		if($oPage instanceof Page)
			$oPage = $oPage->getId();
	
		if($oPage)
			$oParam->set('pageid', $oPage);
	
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}	
} // PageTabPeer

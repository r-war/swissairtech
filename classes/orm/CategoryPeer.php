<?php

require 'orm/om/BaseCategoryPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'category' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class CategoryPeer extends BaseCategoryPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
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
			if($oParam->isExists('havepicture'))
			{
				$oCrit->add(self::PICTURE, null, Criteria::ISNOTNULL);
			}
			
			
		}
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getByParent(Category $oCategory = null, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addAscendingOrderByColumn(self::NAME);
	
		if($oCategory instanceof Category)
			$oCrit->add(self::PARENT_ID, $oCategory->getId());
		else
			$oCrit->add(self::PARENT_ID, null, Criteria::ISNULL);
		
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::INDEX , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
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

	static function getByParentIdAndCode($iParentId, $sCode)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::CODE, $sCode);
		$oCrit->add(self::PARENT_ID, $iParentId);
		
		return self::doSelectOne($oCrit);
	}
	
} // CategoryPeer
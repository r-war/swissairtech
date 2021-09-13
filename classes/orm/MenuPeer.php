<?php

require 'orm/om/BaseMenuPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'menu' table.
 *
 * Menu Table
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class MenuPeer extends BaseMenuPeer {
	
	static function getByGroup($sGroup = null, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCrit->add(self::NAME, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
			if($oParam->isExists('parentId'))
			{
				$oCrit->add(self::PARENT_ID, $oParam->get('parentId'));
			}
			else {
				$oCrit->add(self::PARENT_ID, NULL, Criteria::ISNULL);
			}
		}
		else
			$oCrit->add(self::PARENT_ID, NULL, Criteria::ISNULL);
	
		$oCrit->add(self::GROUP, $sGroup);
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addDescendingOrderByColumn(self::ID);
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getByParent(Menu $oMenu)
	{
		$oParam = new Parameter();
		$oParam->set('parentId', $oMenu->getId());
		$aList = self::getByGroup($oMenu->getGroup(),$oParam);
		return $aList;
	}

	static function getByParentId($id) {
		$oCrit = new Criteria();
		$oCrit->add(self::PARENT_ID, $id);
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addDescendingOrderByColumn(self::ID);
	
		$aList = self::getList($oCrit);
		return $aList;
	}

	static function getByValue( $value ) {
		$oCrit = new Criteria();
		$oCrit->add(self::VALUE, $value);
		return self::doSelectOne($oCrit);
	}
	
} // MenuPeer

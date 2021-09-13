<?php

require 'orm/om/BaseAdminPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'admin' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class AdminPeer extends BaseAdminPeer {

	static function getDataModel(RunData $oData = null, AbstractModule $oMod, PropelPDO $oCon = null)
	{
		$oCrit = new Criteria();
		$aColumn = array(null,self::USERNAME, self::PASSWORD,null);
		
		if($oData->get('iSortCol_0') >= 0)
		{
			for($i=0; $i<intval($oData->get('iSortingCols')); $i++ )
			{
				if($oData->get('bSortable_'.intval($oData->get('iSortCol_'.$i))) == "true" && $aColumn[intval($oData->get('iSortCol_'.$i))] != null)
				{
					if($oData->get('sSortDir_'.$i) == 'asc')
						$oCrit->addAscendingOrderByColumn($aColumn[intval($oData->get('iSortCol_'.$i))]);
					else
						$oCrit->addDescendingOrderByColumn($aColumn[intval($oData->get('iSortCol_'.$i))]);
				}
			}
		}
		
		if ($oData->isExists('sSearch') && $oData->get('sSearch') != "" )
		{
			$idx = 0;
			foreach ($aColumn as $sColumn)
			{
				if($sColumn != null)
				{
					if($idx == 0)
						$oCriterion = $oCrit->getNewCriterion($sColumn, '%'.$oData->get('sSearch').'%', Criteria::LIKE);
					else
						$oCriterion->addOr($oCrit->getNewCriterion($sColumn, '%'.$oData->get('sSearch').'%', Criteria::LIKE));
				
					$idx++;
				}
			}
			if($idx > 0)
				$oCrit->add($oCriterion);
		}
		
		$iCount = self::doCount($oCrit, $oCon);
		
		if($oData->get('iDisplayStart') >= 0 && $oData->get('iDisplayLength') != '-1')
		{
			$oCrit->setOffset($oData->get('iDisplayStart'));
			$oCrit->setLimit($oData->get('iDisplayLength'));
		}
		
		$aObj = self::doSelect($oCrit, $oCon);
		
		$aData = array();
		foreach($aObj as $oObj)
		{
			$aData[] = array(
						'<input type="checkbox" name="c[]" value="'.$oObj->getPrimaryKey().'" id="c"/>',
						$oObj->getUsername(), 
						$oObj->getPassword(),
						'<input type="button" value="Edit" class="btn" onclick="redirect(\''.$oMod->getPage($oMod->getModule(),'select='.$oObj->getPrimaryKey()).'\')"/>&nbsp;<input type="button" value="Delete" class="btn" onclick="doDelete(\''.$oMod->getPage($oMod->getModule(),'delete='.$oObj->getPrimaryKey()).'\',\''.$oObj->getUsername().'\')"/>'
					);
		}
		$sContent = array(
				'sEcho' => $oData->get('sEcho'),
				'iTotalRecords' => self::doCount(new Criteria()),
				'iTotalDisplayRecords' => $iCount,
				'aaData' => $aData
		);
		
		return json_encode($sContent);
	}
	
	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addAscendingOrderByColumn(self::ID);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCrit->add(self::USERNAME, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
		}
		
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function validateLogin($sUsername = null, $sPassword = null, PropelPDO $con = null)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::USERNAME, $sUsername);
		$oCrit->add(self::PASSWORD, md5($sPassword));
	
		return self::doSelectOne($oCrit, $con);
	}
	
} // AdminPeer
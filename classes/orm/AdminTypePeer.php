<?php

require 'orm/om/BaseAdminTypePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'admin_type' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class AdminTypePeer extends BaseAdminTypePeer {
	
	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addAscendingOrderByColumn(self::ID);
	
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
	
} // AdminTypePeer

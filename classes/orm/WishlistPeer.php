<?php

require 'orm/om/BaseWishlistPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'wishlist' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class WishlistPeer extends BaseWishlistPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();
	
		$oCrit->addAscendingOrderByColumn(self::DATE);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::ORDER_ID , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCriterion->addOr($oCrit->getNewCriterion(self::EMAIL , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('userid'))
			{
				$oCrit->add(self::USER_ID, $oParam->get('userid'));
			}
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getByUser(User $oUser, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();

		$oParam->set('userid', $oUser->getId());
		
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function getByUserAndPId(User $oUser, $iPid)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::USER_ID, $oUser->getId());
		$oCrit->add(self::PRODUCT_DETAIL_ID, $iPid);

		return self::doSelectOne($oCrit);
	}
	
	static function getByUserAndId(User $oUser, $iId)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::USER_ID, $oUser->getId());
		$oCrit->add(self::ID, $iId);

		return self::doSelectOne($oCrit);
	}
		
} // WishlistPeer

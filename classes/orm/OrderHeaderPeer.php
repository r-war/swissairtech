<?php

require 'orm/om/BaseOrderHeaderPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'order_header' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class OrderHeaderPeer extends BaseOrderHeaderPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();
	
		$oCrit->addDescendingOrderByColumn(self::DATE);
	
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
			if($oParam->isExists('status'))
			{
				$iStatus = $oParam->get('status');
				if($iStatus == 1)
				{
					$oCrit->add(self::POA, false);
					$oCrit->add(self::STATUS, $iStatus);
				}
				else
					$oCrit->add(self::STATUS, $iStatus);
			}
			if($oParam->isExists('poa'))
			{
				$oCrit->add(self::POA, true);
			}
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getOrderByTransIdAndAmount($sPaypalToken, $sAmount)
	{
		$oCrit = new Criteria();
	
		$oCrit->add(self::PAYPAL_TOKEN, $sPaypalToken);
		$oCrit->add(self::TOTAL, $sAmount);
	
		$aList = self::doSelectOne($oCrit);
		return $aList;
	}
	
	static function getByUser(User $oUser, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();

		$oParam->set('userid', $oUser->getId());
		
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function getByUserAndPK(User $oUser, $sId)
	{
		$oCrit = new Criteria();
	
		$oCrit->add(self::ID, $sId);
		$oCrit->add(self::USER_ID, $oUser->getId());
	
		$aList = self::doSelectOne($oCrit);
		return $aList;
	}

	static function getByOrderId($sId)
	{
		$oCrit = new Criteria();
	
		$oCrit->add(self::ORDER_ID, $sId);
	
		$aList = self::doSelectOne($oCrit);
		return $aList;
	}

} // OrderHeaderPeer

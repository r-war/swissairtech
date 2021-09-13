<?php

require 'orm/om/BasePromoCouponPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'promo_coupon' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class PromoCouponPeer extends BasePromoCouponPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();
	
		$oCrit->addAscendingOrderByColumn(self::ID);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::ID , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::CODE , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('promoid'))
			{
				$oCrit->add(self::PROMO_ID, $oParam->get('promoid'));
			}
			elseif($oParam->isExists('promoidarray'))
			{
				$oCrit->add(self::PROMO_ID, $oParam->get('promoidarray'), Criteria::IN);
			}
			if($oParam->isExists('idnot'))
			{
				$oCrit->add(self::ID, $oParam->get('idnot'), Criteria::NOT_EQUAL);
			}
		}
		
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getByPromo($iProduct = null , Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		if($iProduct instanceof Promo)
			$iProduct = $iProduct->getId();
	
		if($iProduct)
			$oParam->set('promoid', $iProduct);
	
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function getNotSelf(PromoCoupon $oPromoCoupon)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::CODE, $oPromoCoupon->getCode());
		if(!$oPromoCoupon->isNew())
			$oCrit->add(self::ID, $oPromoCoupon->getId(), Criteria::NOT_EQUAL);
		
		return self::doSelectOne($oCrit);
	}
	
	static function getByPidAndAid($iPid, $iAid)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::PRODUCT_ID, $iPid);
		$oCrit->add(self::ID, $iAid);
		
		return self::doSelectOne($oCrit);
	}
	
	static function getByPromoAndCode(Promo $oPromo, $sCoupon)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::CODE, $sCoupon);
		$oCrit->add(self::PROMO_ID, $oPromo->getId());
		
		return self::doSelectOne($oCrit);
	}
	
	
	
} // PromoCouponPeer

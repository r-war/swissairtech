<?php

require 'orm/om/BasePromoPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'promo' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class PromoPeer extends BasePromoPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();

		$oCrit->addAscendingOrderByColumn(self::END_DATE);
		
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::DESCRIPTION , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('idnot'))
			{
				$oCrit->add(self::ID, $oParam->get('idnot'), Criteria::NOT_EQUAL);
			}
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getAllProduct(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addJoin(self::ID, PromoProductPeer::PROMO_ID);
		$oCrit->addJoin(PromoProductPeer::PRODUCT_ID, ProductPeer::ID);
		$oCrit->addAscendingOrderByColumn(ProductPeer::INDEX);
		$oCrit->addAscendingOrderByColumn(ProductPeer::NAME);
		$oCrit->setDistinct();
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(ProductPeer::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(ProductPeer::DESCRIPTION , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('promoid'))
			{
				$oCrit->add(self::ID, $oParam->get('promoid'));
			}
			if($oParam->isExists('publicview'))
			{
				$oCrit->add(ProductPeer::ACTIVE, true);
			}
			if($oParam->isExists('sort'))
			{
				$oCrit->clearOrderByColumns(ProductPeer::INDEX);
				$oCrit->clearOrderByColumns(ProductPeer::NAME);
				$oCrit->clearOrderByColumns(ProductPeer::DATE);
				if($oParam->get('sort') == 'price')
				{
					$oCrit->addJoin(ProductPeer::ID, ProductDetailPeer::PRODUCT_ID);
					$oCrit->addAscendingOrderByColumn(ProductDetailPeer::PRICE);
				}elseif($oParam->get('sort') == 'name')
				{
					$oCrit->addAscendingOrderByColumn(ProductPeer::NAME);
				}elseif($oParam->get('sort') == 'date')
				{
					$oCrit->addDescendingOrderByColumn(ProductPeer::DATE);
				}
				
			}
		}
	
		$aList = ProductPeer::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getForProduct(Product $oProduct)
	{
		$oDate = new DateTime();
		$oCrit = new Criteria();
		$oCrit->add(self::START_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::LESS_EQUAL);
		$oCrit->add(self::END_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::GREATER_EQUAL);
//		$oCrit->add(self::MIN_AMOUNT, false);
		$oCrit->addJoin(self::ID, PromoProductPeer::PROMO_ID);
		$oCrit->add(PromoProductPeer::PRODUCT_ID, $oProduct->getId());
		
		return self::doSelectOne($oCrit);
	}
	
	static function getAnyForProduct(Product $oProduct)
	{
		$oDate = new DateTime();
		$oCrit = new Criteria();
		$oCrit->addJoin(self::ID, PromoProductPeer::PROMO_ID);
		$oCrit->add(PromoProductPeer::PRODUCT_ID, $oProduct->getId());
		
		return self::doSelectOne($oCrit);
	}
	
	static function getByCoupon($sCode)
	{
		$oDate = new DateTime();
		$oCrit = new Criteria();
		$oCrit->add(self::START_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::LESS_EQUAL);
		$oCrit->add(self::END_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::GREATER_EQUAL);
		$oCrit->addJoin(self::ID, PromoCouponPeer::PROMO_ID);
		$oCrit->add(PromoCouponPeer::CODE, $sCode);

		$oCriterion1 = $oCrit->getNewCriterion(PromoCouponPeer::UNLIMITED , true);
		$oCriterion2 = $oCrit->getNewCriterion(PromoCouponPeer::UNLIMITED , false);
		$oCriterion2->addAnd($oCrit->getNewCriterion(PromoCouponPeer::USED , 1, Criteria::LESS_THAN));
		$oCriterion1->addOr($oCriterion2);
		$oCrit->add($oCriterion1);
		
		return self::doSelectOne($oCrit);
	}
	
	static function getNewPromoProduct()
	{
		$oDate = new DateTime();
		$oCrit = new Criteria();
		$oCrit->add(self::END_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::GREATER_EQUAL);
		$oCrit->add(self::DISC_TYPE, 1);
		$oCrit->addAscendingOrderByColumn(self::START_DATE);
		
		return self::doSelect($oCrit);
	}
	
	static function getProductByPromo($oPromo = null, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		if($oPromo instanceof Promo)
			$oParam->set('promoid', $oPromo->getId());
	
		return self::getAllProduct($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
} // PromoPeer

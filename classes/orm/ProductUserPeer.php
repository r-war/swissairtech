<?php

require 'orm/om/BaseProductUserPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'product_user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductUserPeer extends BaseProductUserPeer {
		
	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addJoin(self::USER_ID, UserPeer::ID, Criteria::LEFT_JOIN);
		$oCrit->addJoin(self::PRODUCT_ID, ProductPeer::ID, Criteria::LEFT_JOIN);
		$oCrit->addDescendingOrderByColumn(self::ID);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(UserPeer::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(UserPeer::EMAIL , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCriterion->addOr($oCrit->getNewCriterion(UserPeer::PHONE , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCriterion->addOr($oCrit->getNewCriterion(ProductPeer::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('productid'))
			{
				$oCrit->add(self::PRODUCT_ID, $oParam->get('productid'));
			}
			if($oParam->isExists('userid'))
			{
				$oCrit->add(self::USER_ID, $oParam->get('userid'));
			}
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}

	static function getNotSelfByUserProduct(ProductUser $oProductUser, User $oUser, Product $oProduct)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::USER_ID, $oUser->getId());
		$oCrit->add(self::PRODUCT_ID, $oProduct->getId());
		if(!$oProductUser->isNew())
			$oCrit->add(self::ID, $oProductUser->getId(), Criteria::NOT_EQUAL);
		
		return self::doSelectOne($oCrit);
	}
} // ProductUserPeer

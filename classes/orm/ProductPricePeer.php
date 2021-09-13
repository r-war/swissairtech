<?php

require 'orm/om/BaseProductPricePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'product_price' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductPricePeer extends BaseProductPricePeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();
	
		$oCrit->addAscendingOrderByColumn(self::MIN);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::MIN , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::MAX , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('productid'))
			{
				$oCrit->add(self::PRODUCT_ID, $oParam->get('productid'));
			}
			elseif($oParam->isExists('productidarray'))
			{
				$oCrit->add(self::PRODUCT_ID, $oParam->get('productidarray'), Criteria::IN);
			}
			if($oParam->isExists('idnot'))
			{
				$oCrit->add(self::ID, $oParam->get('idnot'), Criteria::NOT_EQUAL);
			}
	
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getByProduct($iProduct = null , Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		if($iProduct instanceof Product)
			$iProduct = $iProduct->getId();
	
		if($iProduct)
			$oParam->set('productid', $iProduct);
	
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function getByProductAndQty($iProduct = null, $iQty = 1)
	{
		if($iProduct instanceof Product)
			$iProduct = $iProduct->getId();
		
		if($iProduct)
		{
			$oCrit = new Criteria();
			$oCrit->add(self::PRODUCT_ID, $iProduct);
			$oCrit->add(self::MIN, $iQty, Criteria::LESS_EQUAL);
			$oCrit->addDescendingOrderByColumn(self::MIN);
			
			return self::doSelectOne($oCrit);
		}
	}
} // ProductPricePeer

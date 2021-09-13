<?php

require 'orm/om/BaseProductDetailPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'product_detail' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductDetailPeer extends BaseProductDetailPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();
	
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addAscendingOrderByColumn(self::NAME);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::SKU , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
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
			if($oParam->isExists('groupby'))
			{
				$oCrit->addGroupByColumn($oParam->get('groupby'));
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
	
	static function getByPidAndSid($iPid, $iSid)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::PRODUCT_ID, $iPid);
		$oCrit->add(self::ID, $iSid);
		
		return self::doSelectOne($oCrit);
	}
	
	static function getByPidAndSku($iPid, $sSku)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::PRODUCT_ID, $iPid);
		$oCrit->add(self::SKU, $sSku);
		
		return self::doSelectOne($oCrit);
	}
	
	static function getBySku($sSku)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::SKU, $sSku);
		
		return self::doSelectOne($oCrit);
	}
	
	static function retrieveByPKLockedByOrderDetail(OrderDetail $oOrderDetail)
	{
		return $oOrderDetail->getProductDetail();
	}

	static function getByProductColorSize($iPid, $sColor = null, $sSize, $bStock = true)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::PRODUCT_ID, $iPid);
		$oCrit->add(self::NAME, $sSize);
		if($sColor)
			$oCrit->add(self::NAME2, $sColor);
		if($bStock)
			$oCrit->add(self::STOCK, 1, Criteria::GREATER_EQUAL);
		
		return self::doSelectOne($oCrit);
	}
} // ProductDetailPeer

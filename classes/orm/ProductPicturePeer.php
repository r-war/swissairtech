<?php

require 'orm/om/BaseProductPicturePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'product_picture' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductPicturePeer extends BaseProductPicturePeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();
	
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addAscendingOrderByColumn(self::NAME);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::PICTURE , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('productid'))
			{
				$oCrit->add(self::PRODUCT_ID, $oParam->get('productid'));
			}
			elseif($oParam->isExists('productidarray'))
			{
				$oCrit->addJoin(self::PRODUCT_STOCK_ID, ProductStockPeer::ID);
				$oCrit->addJoin(ProductStockPeer::PRODUCT_ID, ProductPeer::ID);
				$oCrit->add(ProductPeer::PRODUCT_ID, $oParam->get('productidarray'), Criteria::IN);
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

	static function getByProductDetail($iProductDetail = null , Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		if($iProductDetail instanceof ProductDetail)
			$iProductDetail = $iProductDetail->getId();
	
		if($iProductDetail)
			$oParam->set('productdetailid', $iProductDetail);
	
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
		
	static function getByProductOrProductDetail($iProduct = null , $iProductDetail = null , Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		if($iProductDetail)
		{
			if($iProductDetail instanceof ProductDetail)
				$iProductDetail = $iProductDetail->getId();
		
			if($iProductDetail)
				$oParam->set('productdetailid', $iProductDetail);
		}
		else
		{
			if($iProduct instanceof Product)
				$iProduct = $iProduct->getId();
		
			if($iProduct)
				$oParam->set('productid', $iProduct);
			
			$sNull = 'null';
			$oParam->set('productdetailid', $sNull);
		}
	
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}

} // ProductPicturePeer

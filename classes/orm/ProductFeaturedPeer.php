<?php

require 'orm/om/BaseProductFeaturedPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'product_featured' table.
 *
 * Featured Product Table
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductFeaturedPeer extends BaseProductFeaturedPeer {
	
	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addAscendingOrderByColumn(self::INDEX);
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCrit->add(self::INDEX, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
			if($oParam->isExists('type'))
			{
				$oCrit->add(self::TYPE, $oParam->get('type'));
			}

		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}

	static function getAllProduct(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
		$oCrit->addJoin(self::PRODUCT_ID, ProductPeer::ID);
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->setDistinct();
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCrit->add(self::INDEX, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
			if($oParam->isExists('publicview'))
			{
				$oCrit->add(ProductPeer::ACTIVE, true);
			}
			if($oParam->isExists('type'))
			{
				$oCrit->add(self::TYPE, $oParam->get('type'));
			}
			if($oParam->isExists('sort'))
			{
				$oCrit->clearOrderByColumns(self::INDEX);
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
	
	static function getByType($sType, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
		
		$oParam->set('type', $sType);
		
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}

	static function getProductByType($sType, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		$oParam->set('type', $sType);
	
		return self::getAllProduct($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function getNotSelfByTypeAndProduct(ProductFeatured $oProductFeatured, $sType, Product $oProduct)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::TYPE, $sType);
		$oCrit->add(self::PRODUCT_ID, $oProduct->getId());
		if(!$oProductFeatured->isNew())
			$oCrit->add(self::ID, $oProductFeatured->getId(), Criteria::NOT_EQUAL);
		
		return self::doSelectOne($oCrit);
	}
	
	static function countByType($sType)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::TYPE, $sType);
	
		return self::doCount($oCrit);
	}
} // ProductFeaturedPeer

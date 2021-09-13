<?php

require 'orm/om/BaseProductPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'product' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductPeer extends BaseProductPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		$oCrit = new Criteria();
	
		$oCrit->addJoin(self::ID, ProductCategoryPeer::PRODUCT_ID);
		$oCrit->addJoin(ProductCategoryPeer::CATEGORY_ID, CategoryPeer::ID);
		
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addAscendingOrderByColumn(self::NAME);
		// $oCrit->addDescendingOrderByColumn(self::DATE);
		$oCrit->setDistinct();
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				
				$oCriterion = $oCrit->getNewCriterion(self::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE);
				$oCriterion->addOr($oCrit->getNewCriterion(self::DESCRIPTION , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCriterion->addOr($oCrit->getNewCriterion(self::ID , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCriterion->addOr($oCrit->getNewCriterion(CategoryPeer::NAME , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCriterion->addOr($oCrit->getNewCriterion(CategoryPeer::DESCRIPTION , '%'.$oParam->get('keywords').'%',Criteria::LIKE));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('userid'))
			{
				$oCrit->addJoin(self::ID, ProductUserPeer::PRODUCT_ID);
				$oCrit->add(ProductUserPeer::USER_ID, $oParam->get('userid'));
			}
			if($oParam->isExists('min'))
			{
				$oCrit->add(ProductDetailPeer::PRICE, $oParam->get('min'), Criteria::GREATER_EQUAL);
			}
			if($oParam->isExists('max'))
			{
				if($oParam->isExists('min'))
					$oCrit->addAnd(ProductDetailPeer::PRICE, $oParam->get('max'), Criteria::LESS_THAN);
				else
					$oCrit->add(ProductDetailPeer::PRICE, $oParam->get('max'), Criteria::LESS_THAN);
			}
			if($oParam->isExists('categoryid'))
			{
				$oCrit->addJoin(self::ID, ProductCategoryPeer::PRODUCT_ID);
				$oCrit->add(ProductCategoryPeer::CATEGORY_ID, $oParam->get('categoryid'));
			}
			elseif($oParam->isExists('categoryidarray'))
			{
				$oCrit->addJoin(self::ID, ProductCategoryPeer::PRODUCT_ID);
				$oCrit->add(ProductCategoryPeer::CATEGORY_ID, $oParam->get('categoryidarray'), Criteria::IN);
			}
			if($oParam->isExists('idnot'))
			{
				$oCrit->add(self::ID, $oParam->get('idnot'), Criteria::NOT_EQUAL);
			}
			if($oParam->isExists('invoiceid'))
			{
				$oCrit->add(self::INVOICE_ID, $oParam->get('invoiceid'));
			}
			if($oParam->isExists('price'))
			{
				$oCrit->add(self::SHORT_DESCRIPTION, $oParam->get('price'));
			}
			if($oParam->isExists('publicview'))
			{
				$oCriterion = $oCrit->getNewCriterion(self::ACTIVE, 1);
				$oCriterion->addOr($oCrit->getNewCriterion(self::ACTIVE, 2));
				$oCrit->add($oCriterion);
			}
			elseif($oParam->isExists('internalview'))
			{
				$oCrit->clearOrderByColumns(self::INDEX);
				$oCrit->addAscendingOrderByColumn(self::NAME);
				$oCriterion = $oCrit->getNewCriterion(self::ACTIVE, 1);
				$oCriterion->addOr($oCrit->getNewCriterion(self::ACTIVE, 3));
				$oCrit->add($oCriterion);
			}
			if($oParam->isExists('sort'))
			{
				$oCrit->clearOrderByColumns(self::INDEX);
				$oCrit->clearOrderByColumns(self::NAME);
				$oCrit->clearOrderByColumns(self::DATE);
				if($oParam->get('sort') == 'bestbuy')
				{
					$oCrit->addJoin(self::ID, QuotationDetailPeer::PRODUCT_ID);
					$oCrit->addGroupByColumn(self::ID);
					$oCrit->addDescendingOrderByColumn('COUNT('.self::ID.')');
				}elseif($oParam->get('sort') == 'newest')
				{
					$oDate = new DateTime();
					$oDate->modify('-30days');
					$oCrit->add(self::DATE, $oDate->format('Y-m-d H:i:s'), Criteria::GREATER_THAN);
					$oCrit->addDescendingOrderByColumn(self::DATE);
				}elseif($oParam->get('sort') == 'price')
				{
					$oCrit->addAscendingOrderByColumn(ProductDetailPeer::PRICE);
				}elseif($oParam->get('sort') == 'name')
				{
					$oCrit->addAscendingOrderByColumn(self::NAME);
				}elseif($oParam->get('sort') == 'date')
				{
					$oCrit->addDescendingOrderByColumn(self::DATE);
				}
				
			}
			if($oParam->isExists('status'))
			{
				if($oParam->get('status') == 1)
				{
					$oDate = new DateTime();
					$oCrit->add(self::EXPIRED_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::GREATER_EQUAL);
					$oDate->modify('+1 month');
					$oCrit->addAnd(self::EXPIRED_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::LESS_EQUAL);
				}
				else if($oParam->get('status') == 2)
				{
					$oDate = new DateTime();
					$oCrit->add(self::EXPIRED_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::LESS_THAN);
						
				}
				else if($oParam->get('status') == 3)
				{
					$oCrit->add(self::SOLD_STATUS, 3);
				}
				else if($oParam->get('status') == 4)
				{
					$oDate = new DateTime();
					$oCrit->add(self::EXPIRED_DATE, $oDate->format('Y-m-d H:i:s'), Criteria::GREATER_EQUAL);
					$oCrit->add(self::SOLD_STATUS, null, Criteria::ISNULL);
					$oCrit->addOr(self::SOLD_STATUS, 3, Criteria::LESS_THAN);
				}
			}
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	function getCategoryRecursive($iCategory, &$aId)
	{
		$aId[$iCategory->getId()] = $iCategory->getId();
		if($iCategory->haveSub())
		{
			$aSub = $iCategory->getSub();
			foreach ($aSub as $oSub)
			{
				$aId[$oSub->getId()] = $oSub->getId();
				self::getCategoryRecursive($oSub,$aId);
			}
		}
	}
	
	static function getByCategory($iCategory = null , Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		if($iCategory instanceof Category)
		{
			$aId = array();
			self::getCategoryRecursive($iCategory, $aId);
			$oParam->set('categoryidarray', $aId);
		}	
		elseif($iCategory)
		{
			$oParam->set('categoryid', $iCategory);
		}	
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function getBestBuy()
	{
		$oParam = new Parameter();
		$sSortType = 'bestbuy';
		$oParam->set('sort',$sSortType);
						
		return self::getAll($oParam,null,1,$null,10);
	}
	
	static function getNewest(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1, &$oPager = null,$iRows = 20)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
		$sSortType = 'newest';
		$oParam->set('sort', $sSortType);
	
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function getRelatedProduct(Product $oProduct)
	{
		/*
		$oCategory = $oProduct->getCategory();
		
		if($oCategory instanceof Category)
		{
			$oParam = new Parameter();
			$bTrue = 1;
			$oParam->set('categoryid', $oCategory->getId());
			$oParam->set('idnot', $oProduct->getId());
			$oParam->set('publicview',$bTrue);
			$aTemp = self::getAll($oParam);
			shuffle($aTemp);
			$iMax = (count($aTemp) > 5 ? 5 : count($aTemp));
			for($i = 0; $i < $iMax; $i++)
			{
				$aProduct[$i] = $aTemp[$i];
			}
			
			return $aProduct;
		}
		*/
		return ProductFeaturedPeer::getProductByType('product_'.$oProduct->getId());
	}
	
	static function getByCode($sCode)
	{
		$oCrit = new Criteria();
		$oCrit->add(self::CODE, $sCode);
		
		return self::doSelectOne($oCrit);
	}	
	
	static function getByUserAndCode(User $oUser, $sCode)
	{
		$oCrit = new Criteria();
		$oCrit->addJoin(self::ID, ProductUserPeer::PRODUCT_ID);
		$oCrit->add(self::CODE, $sCode);
		$oCrit->add(ProductUserPeer::USER_ID, $oUser->getId());
		
		return self::doSelectOne($oCrit);
	}
	
	static function getByUser($iUser = null , Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1, &$oPager = null,$iRows = 12)
	{
		if(!$oParam instanceof Parameter)
			$oParam = new Parameter();
	
		if($iUser instanceof User)
		{
			$iUser = $iUser->getId();
		}
		
		if($iUser)
		{
			$oParam->set('userid', $iUser);
		}	
		return self::getAll($oParam, $oSortable, $iPage, $oPager, $iRows);
	}
	
	static function retrieveByPKLockedByOrderDetail(OrderDetail $oOrderDetail)
	{
		return $oOrderDetail->getProduct();
	}

} // ProductPeer

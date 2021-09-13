<?php

require 'orm/om/BaseProductCategoryPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'product_category' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductCategoryPeer extends BaseProductCategoryPeer {
	
	static function getByProductAndCategory($iPid, $iCid)
	{
		if($iPid instanceof Product)
			$iPid = $iPid->getId();
		if($iCid instanceof Category)
			$iCid = $iCid->getId();
			
		$oCrit = new Criteria();
		$oCrit->add(self::PRODUCT_ID, $iPid);
		$oCrit->add(self::CATEGORY_ID, $iCid);
		
		return self::doSelectOne($oCrit);
	}
	
	static function getByProduct($iPid)
	{
		if($iPid instanceof Product)
			$iPid = $iPid->getId();
			
		$oCrit = new Criteria();
		$oCrit->add(self::PRODUCT_ID, $iPid);
		
		return self::doSelect($oCrit);
	}
	
	static function deleteByProduct($iPid)
	{
		if($iPid instanceof Product)
			$iPid = $iPid->getId();
			
		$oCrit = new Criteria();
		$oCrit->add(self::PRODUCT_ID, $iPid);
		
		return self::doDelete($oCrit);
	}
} // ProductCategoryPeer

<?php

require 'orm/om/BaseTestimonialPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'testimonial' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class TestimonialPeer extends BaseTestimonialPeer {

	static function getAll(Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();

		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCrit->add(self::NAME, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
		}
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getNewest(Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}

	static function getByCategory($category) {
		$crit = new Criteria();
		$crit->add(self::EMAIL, $category);
		return self::getList($crit);
	}
	
	static function getRandom()
	{
		$oCrit = new Criteria();
        $oCrit->addDescendingOrderByColumn(self::ID);
        $oTempTestimonial = self::doSelectOne($oCrit);
        $iTry = 0;
        
        if($oTempTestimonial instanceof Testimonial)
        {
	        $oTestimonial = null;
	        $aTestimonial = array();
	        while(count($aTestimonial) < 1 && $iTry < 10)
	        {
	        	$oTestimonial = self::retrieveByPK(rand(1,$oTempTestimonial->getId()));
	        	if($oTestimonial instanceof Testimonial && $oTestimonial != $aTestimonial[0])
	        		$aTestimonial[] = $oTestimonial;
	        	$iTry++;
	        }
	        
	        return $aTestimonial;
        }
	}
	
	static function getOneRandom()
	{
		$aTestimonial = self::getRandom();
		return $aTestimonial[0];
	}
} // TestimonialPeer

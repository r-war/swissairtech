<?php

require 'orm/om/BaseGalleryPicturePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'gallery_picture' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class GalleryPicturePeer extends BaseGalleryPicturePeer {

	const FILE_TYPE_IMAGE = 'jpg,jpeg,png,gif,bmp,ico';
	
	static function getByGroup(Gallery $oGallery, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$oCrit = new Criteria();
	
		if($oParam instanceof Parameter)
		{
			if($oParam->isExists('keywords'))
			{
				$oCrit->add(self::PICTURE, '%'.$oParam->get('keywords').'%', Criteria::LIKE);
			}
		}
	
		if($oGallery instanceof Gallery)
			$oCrit->add(self::GALLERY_ID, $oGallery->getId());
		$oCrit->addAscendingOrderByColumn(self::INDEX);
		$oCrit->addDescendingOrderByColumn(self::ID);
	
		$aList = self::getList($oCrit,$oSortable,$iPage,$oPager,$iRows);
		return $aList;
	}
	
	static function getRandomByType($sType, Parameter $oParam = null, Sortable $oSortable = null, $iPage = -1,&$oPager = null,$iRows = 20)
	{
		$aList = self::getByType($sType,null,null,-1);
		return $aList[array_rand($aList)];
	}
} // GalleryPicturePeer

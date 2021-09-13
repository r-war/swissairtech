<?php

require 'orm/om/BaseGallery.php';


/**
 * Skeleton subclass for representing a row from the 'gallery' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Gallery extends BaseGallery {

	/**
	 * Initializes internal state of Gallery object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getUrl()
	{
		if(Attributes::REWRITE)
			return $sUrl.'/'.$this->getCode();
		else
			return $sUrl.'&id='.$this->getId();
	}
	
	public function getParent()
	{
		if($this->getParentId())
			return GalleryPeer::retrieveByPK($this->getParentId());
	}
	
	public function haveSub()
	{
		$aSub = GalleryPeer::getByParent($this);
		if(is_array($aSub) && count($aSub) > 0)
			return true;
	}
	
	public function getSub()
	{
		return CategoryPeer::getByParent($this);
	}
	
	public function canHaveSub()
	{
		$idx = 0;
		$oParent = $this;
		while($oParent instanceof Category)
		{
			$idx++;
			$oParent = $oParent->getParent();
		}
		
		if($idx < 0) return true;
	}

	public function getPictures()
	{
		$aGallery = GalleryPicturePeer::getByGroup($this);
		
		return $aGallery;
	}
	
	public function getDefaultPicture()
	{
		$aGallery = $this->getPictures();
		
		return $aGallery[0];
	}

} // Gallery

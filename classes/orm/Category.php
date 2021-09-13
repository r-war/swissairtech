<?php

require 'orm/om/BaseCategory.php';


/**
 * Skeleton subclass for representing a row from the 'category' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Category extends BaseCategory {

	/**
	 * Initializes internal state of Category object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getPictureUrl()
	{
		$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$this->getPicture();
		if(is_file($sFile))
		{
			return '/'.$sFile;
		}
		return false;
	}
	
	public function getThumbnailURL($iWidth = null, $iHeight = null, $bFixedSize = false)
	{
		$sPic = $this->getPicture();
		$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/_thumbs/'.$iWidth.'x'.$iHeight.'_'.$sPic;
		if(!is_file($sFile))
		{
			$sFileReal= 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$sPic;
			if(is_file($sFileReal))
			{
				$aImageData = getimagesize($sFileReal);
				if($iWidth && $iHeight)
				{
					if($aImageData[0] / $aImageData[1] >= 1)
					{
						$iHeight = $aImageData[1]/$aImageData[0]*$iWidth;
					}
					else
					{
						$iWidth = $aImageData[0]/$aImageData[1]*$iHeight;
					}
				}
				else
				{
					if($iHeight)
						$iWidth = $aImageData[0]/$aImageData[1]*$iHeight;
					elseif($iWidth)
					$iHeight = $aImageData[1]/$aImageData[0]*$iWidth;
					else
					{
						$iWidth = $aImageData[0];
						$iHeight = $aImageData[1];
					}
				}
	
				ImageTool::generateThumbnail(
				$sFileReal,
				$sFile,
				array($iWidth,$iHeight)
				);
					
				/*
				 ,
				null,
				true
				);
				*/
			}
		}
	
		if(!is_file($sFile))
			$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$sPic;
			
		return '/'.$sFile;
	}
	
	public function getUrl()
	{
		if(Attributes::REWRITE)
			return $sUrl.'/'.$this->getCode();
		else
			return $sUrl.'&id='.$this->getId();
	}
	
	/* */	
	
	public function getProducts()
	{
		return ProductPeer::getByCategory($this);
	}
	
	public function getParent()
	{
		if($this->getParentId())
			return CategoryPeer::retrieveByPK($this->getParentId());
	}
	
	public function haveSub()
	{
		$aSub = CategoryPeer::getByParent($this);
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
} // Category

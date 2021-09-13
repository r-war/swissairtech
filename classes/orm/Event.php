<?php

require 'orm/om/BaseEvent.php';


/**
 * Skeleton subclass for representing a row from the 'event' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Event extends BaseEvent {

	/**
	 * Initializes internal state of Event object.
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
		$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$iWidth.'x'.$iHeight.'_'.$sPic;
		if(!is_file($sFile))
		{
			$sFileReal= 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$sPic;
			if(is_file($sFileReal))
			{
				$aImageData = getimagesize($sFileReal);
				if($iWidth && $iHeight)
				{
					if(!$bFixedSize)
					{
						if($aImageData[0] / $aImageData[1] >= $iWidth/$iHeight)
						{
							$iHeight = $aImageData[1]/$aImageData[0]*$iWidth;
						}
						else
						{
							$iWidth = $aImageData[0]/$aImageData[1]*$iHeight;
						}
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
						array($iWidth,$iHeight),
						null,
						$bFixedSize
					); 
			}
		}
		
		if(!is_file($sFile))
			$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/'.$sPic;
			
		return '/'.$sFile;
	}

	
	public function getUrl()
	{
		if(Attributes::REWRITE)
			return '/'.$this->getCode();
		else
			return '&id='.$this->getCode();
	}

	public function getDaysuf($cdnl)
	{
		$test_c = abs($cdnl) % 10;
	    $ext = ((abs($cdnl) %100 < 21 && abs($cdnl) %100 > 4) ? 'th'
	            : (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1)
	            ? 'th' : 'st' : 'nd' : 'rd' : 'th'));
	    return $ext; 
	}
	
	public function getName($sLang = 'en')
 	{
 		if(!$sLang)
 			return parent::getName();
 		else
 		{
 			$sDesc = parent::getName();
 			$aDesc = json_decode($sDesc,true);
 			if(is_array($aDesc))
	 			return $aDesc[$sLang];
			else 
				return parent::getName();
 		}
 	}
 	
 	public function setName($sDesc, $sLang = 'en')
 	{
 		if(!$sLang)
 			parent::setName($sDesc);
 		else
 		{
 			$sAllDesc = parent::getName();
 			$aDesc = json_decode($sAllDesc,true);
 			if(!is_array($aDesc)) $aDesc = array();
 			$aDesc[$sLang] = $sDesc;
 			
 			parent::setName(json_encode($aDesc));
 		}
 	}
	
 	public function getDescription($sLang = 'en')
 	{
 		if(!$sLang)
 			return parent::getDescription();
 		else
 		{
 			$sDesc = parent::getDescription();
 			$aDesc = json_decode($sDesc,true);
 			if(is_array($aDesc))
	 			return $aDesc[$sLang];
			else 
				return parent::getDescription();
 		}
 	}
 	
 	public function setDescription($sDesc, $sLang = 'en')
 	{
 		if(!$sLang)
 			parent::setDescription($sDesc);
 		else
 		{
 			$sAllDesc = parent::getDescription();
 			$aDesc = json_decode($sAllDesc,true);
 			if(!is_array($aDesc)) $aDesc = array();
 			$aDesc[$sLang] = $sDesc;
 			
 			parent::setDescription(json_encode($aDesc));
 		}
 	}

} // Event

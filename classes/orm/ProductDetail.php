<?php

require 'orm/om/BaseProductDetail.php';


/**
 * Skeleton subclass for representing a row from the 'product_detail' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class ProductDetail extends BaseProductDetail {

	/**
	 * Initializes internal state of ProductDetail object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getPriceView()
	{
		return ConfigurationPeer::getCurrency().' '.Common::parseDot($this->getPrice());
	}
	
	public function getSoldPrice()
	{
		$oProduct = $this->getProduct();
		return $oProduct->getSoldPrice($this);
	}
	
	public function getThumbnailURL($iWidth = null, $iHeight = null, $bFixedSize = false)
	{
		$aPicture = ProductPicturePeer::getByProductDetail($this);
		if(!is_array($aPicture) || count($aPicture) == 0)
			$aPicture = ProductPicturePeer::getByProductOrProductDetail($this->getProduct());
		if(is_array($aPicture) && count($aPicture) > 0)
			$oPic = $aPicture[0];
		
		if($oPic instanceof ProductPicture)
		{
			$sPic = $oPic->getPicture();
			$sFile = 'contents/'.$_SESSION[Attributes::SESSION_DOMAIN].'/images/_thumbs/'.$iWidth.'x'.$iHeight.'_'.$sPic;
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
	}

	public function getUrl()
	{
		$sUrl = $this->getProduct()->getUrl();
		
		if(Attributes::REWRITE)
			return $sUrl.'/'.$this->getSku();
		else
			return $sUrl.'&sid='.$this->getSku();
	}
	
	public function getProductName($bSku = true)
	{
		$oProduct = $this->getProduct();
		if($oProduct instanceof Product)
			$sName = $oProduct->getName();
	 	
		if($sName != $this->getName())
			$sName .= ' - '.$this->getName();
		
		if($bSku)
			$sName .= ' ['.$this->getSku().']';
			
	 	return $sName;	
	}
	
} // ProductDetail

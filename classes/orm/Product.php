<?php

require 'orm/om/BaseProduct.php';


/**
 * Skeleton subclass for representing a row from the 'product' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Product extends BaseProduct {

	/**
	 * Initializes internal state of Product object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function countUser()
	{
		$oCrit = new Criteria();
		$oCrit->add(ProductUserPeer::PRODUCT_ID, $this->getId());
		return ProductUserPeer::doCount($oCrit);
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
	
	

	public function getDetail()
	{
		$aDetails = $this->getProductDetails();
		if(is_array($aDetails) && isset($aDetails[0]))
		{
			return $aDetails[0];
		}
	}
	
	public function  getProductDetailId()
	{
		if($oDetail = $this->getDetail())
		return $oDetail->getId();
	}
	
	public function getNetWeight()
	{
		if($oDetail = $this->getDetail())
		{
			return $oDetail->getNetweight();
		}
	}
	
	public function getPrice($oDetail = null)
	{
		if($oDetail instanceof ProductDetail && $oDetail->getProductId() == $this->getId())
			return $oDetail->getPrice();
		else
		{
			if($oDetail = $this->getDetail())
			{
				return $oDetail->getPrice();
			}
		}
	}
	public function getPriceView($oDetail = null)
	{
		$dPrice = $this->getPrice($oDetail);
		if($dPrice)
			return ConfigurationPeer::getCurrency().' '.Common::parseDot($dPrice);
	}
	
	public function getSoldPrice($oDetail = null)
	{
		$dPrice = $this->getPrice($oDetail);
		
		if($dPrice)
		{
			$oPromo = PromoPeer::getForProduct($this);
			if($oPromo instanceof Promo)
			{
				if($oPromo->getPercent())
					$dPrice = (100 - $oPromo->getDiscAmount()) * $dPrice / 100;
				else
					$dPrice = $dPrice - $oPromo->getDiscAmount();
			}

			return $dPrice;
		}
		return false;
	}
	
	public function getSoldPriceView($oDetail = null)
	{
		$sReturn = '';
		$dPrice = $this->getPrice($oDetail); 
		$dSoldPrice = $this->getSoldPrice($oDetail);
		if($dPrice)
		{
			if($dPrice != $dSoldPrice)
			{
				$sReturn .= '<span class="price-product-old"><s>'.ConfigurationPeer::getCurrency().' '.Common::parseDot($dPrice).'</s></span>&nbsp;';
				$sReturn .= '<span class="price-product-disc">'.ConfigurationPeer::getCurrency().' '.Common::parseDot($dSoldPrice).'</span>';
			}	
			else
			{
				$sReturn .= '<span class="price-product">'.ConfigurationPeer::getCurrency().' '.Common::parseDot($dSoldPrice).'</span>';
			}
			
		}
		
		return $sReturn;
	}
	
	public function getDisc($oDetail = null)
	{
		$dPrice = $this->getPrice($oDetail); 
		$dSoldPrice = $this->getSoldPrice($oDetail);
		if($dPrice != $dSoldPrice)
			return number_format(($dPrice-$dSoldPrice)*100/$dPrice, 0);
	}
	
	public function isPromo()
	{
		$dPrice = $this->getPrice(); 
		$dSoldPrice = $this->getSoldPrice();
		
		if($dPrice != $dSoldPrice) return true;
	}
	
	public function isBestSeller()
	{
		return false;
	}
	
	public function isNewProduct()
	{
		$iNow = time('U');
		$iDate = $this->getDate('U');
		$iDiff = 60 * 60 * 24 * 30 * 1;
		
		if($iNow-$iDate-$iDiff <0)return true;
		else return false;
		
	}
	
	public function isHaveBadge()
	{
		if($this->isPromo() || $this->isBestSeller() || $this->isNewProduct())
			return true;
		
		return false;
	}
	
	public function getBadge()
	{
		if($this->isPromo())
			return 'promo';
		elseif($this->isBestSeller())
			return 'best';
		elseif($this->isNewProduct())
			return 'new';
		
		return false;
	}
	
	public function setCategory($aId = array())
	{
		$aProductCategory = $this->getProductCategorys();
		if(is_array($aProductCategory))
		{
			foreach($aProductCategory as $oProductCategory)
			{
				$bDelete = true;
				foreach($aId as $idx => $iId)
				{
					if($oProductCategory->getCategoryId() == $iId)
					{
						unset($aId[$idx]);
						$bDelete = false;
						break;
					}
				}
				if($bDelete)
					$oProductCategory->delete();
			}
		}
		
		if(is_array($aId) && count($aId) > 0)
		{
			foreach($aId as $iId)
			{
				$oDetail = new ProductCategory();
				$oDetail->setProduct($this);
				$oDetail->setCategoryId($iId);
				$oDetail->save();
			}
		}
	}
	
	public function getCategoryArray()
	{
		$aReturn = array();
		$aProductCategory = $this->getProductCategorys();
		foreach($aProductCategory as $oProductCategory)
		{
			$aReturn[] = $oProductCategory->getCategoryId();
		}
		
		return $aReturn;
	}
	
	public function getCategory()
	{
		$aProductCategory = $this->getProductCategorys();
		if(is_array($aProductCategory))
			return CategoryPeer::retrieveByPK($aProductCategory[0]->getCategoryId());
	}
	
	public function getCategoryId()
	{
		$aProductCategory = $this->getProductCategorys();
		if(is_array($aProductCategory) && isset($aProductCategory[0]) && $aProductCategory[0] instanceof ProductCategory)
			return $aProductCategory[0]->getCategoryId();
	}
	
	public function getPicture()
	{
		// $oStock = $this->getProductStock();
		$aPicture = ProductPicturePeer::getByProductOrProductDetail($this);
		if(!is_array($aPicture) || count($aPicture) < 1)
			$aPicture = ProductPicturePeer::getByProduct($this);
		if(is_array($aPicture) && count($aPicture) > 0)
		{
			$oPicture = $aPicture[0];
			if($oPicture instanceof ProductPicture)
				return $oPicture->getPicture();
		}
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
			return $sUrl.'/'.$this->getCode();
		else
			return $sUrl.'&id='.$this->getId();
	}
	
	public function getExtravalue($idx)
	{
		if($this->getExtra() != '')
		{
			$aReturn = json_decode($this->getExtra(),true);
			return $aReturn[$idx];
		}	
		return 0;
	}
	
	public function getPriceListing()
	{
		$sReturn = '<table class="simple"><tr><th>Qty</th><th>Price</th></tr>';
		$aPrice = ProductPricePeer::getByProduct($this);
		if(is_array($aPrice) && count($aPrice) > 0)
		{
			foreach($aPrice as $idx => $oPrice)
			{
				if($oOldPrice instanceof ProductPrice)
				{
					$sReturn .= '<tr><td>'.$oOldPrice->getMin().'-'.($oPrice->getMin()-1).'</td><td>'.$oOldPrice->getPriceView().'</td></tr>';
					$oOldPrice = null;
				}
				$oOldPrice = $oPrice;
			}
			$sReturn .= '<tr><td>'.$oPrice->getMin().'++</td><td>'.$oPrice->getPriceView().'</td></tr>';
		}
		else
		{
			$sReturn .= '<tr><td>1+</td><td>POA</td></tr>';
		}
		$sReturn .= '</table>';
		
		return $sReturn;
	}
	
	public function getPid($sSize = null, $sColor = null)
	{
		if($sSize)
		{
			$oCrit = new Criteria();
			$oCrit->add(ProductDetailPeer::PRODUCT_ID, $this->getId());
			$oCrit->add(ProductDetailPeer::NAME, trim($sSize));
			if($sColor)
				$oCrit->add(ProductDetailPeer::NAME2, trim($sColor));
			$oDetail = ProductDetailPeer::doSelectOne($oCrit);
			
			if($oDetail instanceof ProductDetail)
				return $oDetail->getId();
		}
	}	
	
	public function getStock($sSize = null, $sColor = null)
	{
		if($sSize)
		{
			$oCrit = new Criteria();
			$oCrit->add(ProductDetailPeer::PRODUCT_ID, $this->getId());
			$oCrit->add(ProductDetailPeer::NAME, trim($sSize));
			if($sColor)
				$oCrit->add(ProductDetailPeer::NAME2, trim($sColor));
			$oDetail = ProductDetailPeer::doSelectOne($oCrit);
			
			if($oDetail instanceof ProductDetail)
				return $oDetail->getStock();
		}
		elseif($oDetail = $this->getDetail())
		{
			return $oDetail->getStock();
		}
	}
	
} // Product

<?php

require 'orm/om/BaseMenu.php';


/**
 * Skeleton subclass for representing a row from the 'menu' table.
 *
 * Menu Table
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    orm
 */
class Menu extends BaseMenu {

	/**
	 * Initializes internal state of Menu object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function getUrl(AbstractModule $oModule = null, $sPath = null, $bFullPath = true)
	{
		switch ($this->getType()) {
			case 1:
				return $this->getValue();
				break;
			case 2:
				$oPage = PagePeer::retrieveByPK($this->getValue());
				if($oPage instanceof Page)
				{
					if($oModule instanceof AbstractModule)
					{
						return ($bFullPath ? $oModule->getBaseDomain() : '').$oModule->getBasePage('Page',null,$sPath).$oPage->getUrl();;
					}
					else
						return $oPage->getUrl();
				}
				break;
			case 3:
				if($oModule instanceof AbstractModule)
				{
					if($this->getValue() == 'Default')
						return ($bFullPath ? $oModule->getBaseDomain() : '').$oModule->getBasePage(null,null,$sPath);
					else
						return ($bFullPath ? $oModule->getBaseDomain() : '').$oModule->getBasePage($this->getValue(),null,$sPath);
				}
				else
					return $this->getValue();
				break;
			case 4:
				if($oModule instanceof AbstractModule)
				{
					$oCategory = CategoryPeer::retrieveByPK($this->getValue());
					if($oCategory instanceof Category)
						return ($bFullPath ? $oModule->getBaseDomain() : '').$oModule->getBasePage('Category',$oCategory->getUrl(),$sPath);
					else
						return ($bFullPath ? $oModule->getBaseDomain() : '').$oModule->getBasePage('Category',null,$sPath);
				}
				else
					return $this->getValue();
				break;
			case 5:
				if($oModule instanceof AbstractModule)
				{
					$oPromo = PromoPeer::retrieveByPK($this->getValue());
					if($oPromo instanceof Promo)
						return ($bFullPath ? $oModule->getBaseDomain() : '').$oModule->getBasePage('Promo',$oPromo->getUrl(),$sPath);
					else
						return ($bFullPath ? $oModule->getBaseDomain() : '').$oModule->getBasePage('Promo',null,$sPath);
				}
				else
					return $this->getValue();
				break;
			
		}
		
		// {$oMod->getBaseDomain()}{$oMod->getBasePage('Page',null,true)}{$oObj->getUrl()}
	}
	
	public function isActive(AbstractModule $oModule, $oPage = null, $oCategory = null)
	{
		if($oCategory instanceof Menu && $oCategory->getId() == $this->getId()) return true;
		
		switch ($this->getType()) {
			case 1:
				if($_SERVER['REQUEST_URI'] == $this->getValue()) return true;
				break;
			case 2:
				if($oModule->getModule() == 'Page' && $oPage instanceof Page && $oPage->getId() == $this->getValue()) return true;
				break;
			case 3:
				if($oModule->getModule() == $this->getValue()) return true;
				break;
			case 4:
				if($oCategory instanceof Category && $oCategory->getId() == $this->getValue()) return true;
				break;
		}
		return false;
	}
	
	public function getPageName()
	{
		if($this->getType() == 2)
			if($oPage = PagePeer::retrieveByPK($this->getValue()))
				return $oPage->getName();
	}
	
	public function getPageDescription()
	{
		if($this->getType() == 2)
			if($oPage = PagePeer::retrieveByPK($this->getValue()))
				return $oPage->getDescription();
	}
	
	public function countSub()
	{
		$oCrit = new Criteria();
		$oCrit->add(MenuPeer::PARENT_ID, $this->getId());
		return MenuPeer::doCount($oCrit);
	}
	
	public function getSubMenu()
	{
		if($this->getType() == 3 && $this->getValue() == 'Service')
		{
			$aSub = ServicePeer::getAll();
			
			$aMenu = array();
			foreach($aSub as $oSub)
			{
				$oMenu = new Menu();
				$oMenu->setName($oSub->getName('en'),'en');
				$oMenu->setName($oSub->getName('it'),'it');
				$oMenu->setType(1);
				$oMenu->setValue('/service'.$oSub->getUrl());
				$aMenu[]=$oMenu;
			}
			return $aMenu;
		}
		elseif($this->getType() != 4)
		{
			return MenuPeer::getByParent($this);
		}
		else 
		{
			$oCat = CategoryPeer::retrieveByPK($this->getValue());
			if($oCat instanceof Category)
			{
				$aSub = $oCat->getSub();
			}
			else {
				$aSub = CategoryPeer::getByParent();
			}
			
			$aMenu = array();
			foreach($aSub as $oSub)
			{
				$oMenu = new Menu();
				$oMenu->setName($oSub->getName());
				$oMenu->setType(4);
				$oMenu->setValue($oSub->getId());
				$aMenu[]=$oMenu;
			}
			return $aMenu;
		}
	}
	
	public function haveSub()
	{
		if($this->countSub() > 0) return true;
	}
	
	public function getNameTransform($sLang = 'en')
	{
		$sName = $this->getName($sLang);
		if($sLang != 'cn')
		{
			$aName = explode(' ', $sName);
			$sName = '';
			foreach($aName as $iIdx => $sTempName)
			{
				$sName .= '<span>';
				$sName .= substr($sTempName, 0,1);
				$sName .= '</span>';
				$sName .= strtoupper(substr($sTempName, 1)).' ';
			}
		}
		return $sName;
	}
	
	public function canHaveSub()
	{
		$iLevel = 3; 
		if($this->getType() == 'quick') $iLevel = 2;
		$iLevel = 1;
		
		$idx = 0;
		$oParent = $this;
		while($oParent instanceof Menu)
		{
			$idx++;
			$oParent = $oParent->getMenuRelatedByParentId();
		}
		
		if($idx < $iLevel) return true;
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
} // Menu

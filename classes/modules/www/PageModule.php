<?php
include_once 'AbstractCommonModule.php';

class PageModule extends AbstractCommonModule
{
	protected $oPage;
	protected $parent;
	
	public function isRedirect()
	{
		$this->oPage = PagePeer::getByCode($this->oData->get('id'));
    if(!$this->oPage instanceof Page)
			return true;
	}

	public function getRedirectModule()
	{
    return array('','Default');
	}
	
	public function getName()
	{
		$en = $this->oPage->getName("en");
		$cn = $this->oPage->getName("cn");
		
		return $en;

		if ( $cn != "" ) {
			return $en . " (". $cn .")";
		}
		else {
			return $en;
		}
	}
	
	public function getMetaData($sType = 'title')
	{
		if($this->oPage instanceof Page)
		{
			switch($sType)
			{
				case 'title' :
					$sReturn = $this->getName();
					break;
				
				case 'keywords' :
					$sReturn = implode(',',explode(' ',strip_tags($this->oPage->getDescription())));
					break;
	
				case 'description' :
					$sReturn = strip_tags($this->oPage->getDescription());
					break;
			}
			
			return $sReturn;			
		}
		else
			return parent::getMetaData($sType);
	}

	private function getParent($value)
	{
		$oCrit = new Criteria();
		$oCrit->add(MenuPeer::PARENT_ID, NULL, Criteria::ISNOTNULL);
		$oCrit->add(MenuPeer::VALUE, $value);
		$parent = MenuPeer::doSelectOne($oCrit);
		if ($parent) {
			$this->parent = MenuPeer::retrieveByPk($parent->getParentId());

			$menu = MenuPeer::getByParentId($parent->getParentId());
			return $menu;
		}
	}
	
	public function doBuildTemplate()
	{
		$menu = $this->getParent($this->oPage->getId());

		$view = [
			"page" 			=> $this->oPage,
			"page_tabs"	=> $this->oPage->getPageTabs(),
			"parent"		=> $this->parent,
			"sidemenu" 	=> $menu
		];

		$this->aContext += $view;

		/*
		$is_wealth = false;

		$this->aContext['oPage'] = $this->oPage;
		$this->aContext['wmenu'] = MenuPeer::getByGroup('menu');
		$this->aContext['smenu'] = $this->wealth_sidemenu( null );
		
		$oCrit = new Criteria();
		$oCrit->add(MenuPeer::TYPE, 2);
		$oCrit->add(MenuPeer::GROUP, 'menu');
		$oCrit->add(MenuPeer::VALUE, $this->oPage->getId());
		$oMenu = MenuPeer::doSelectOne($oCrit);

		if ( $oMenu instanceof Menu )
		{
			$is_wealth = true;
		}

		$this->aContext['is_wealth'] = $is_wealth;
		
		if($oMenu instanceof Menu)
		{
			$this->aContext['childrens'] = $oMenu->getSubMenu();

			$oMenu = $oMenu->getMenuRelatedByParentId();
			$this->aContext['oParent'] = $oMenu;
		
			if($oMenu instanceof Menu)
			{
				while($oMenu->getParentId())
				{
					$oMenu = $oMenu->getMenuRelatedByParentId();
				}
			}
			$this->aContext['oAncestor'] = $oMenu;
		}
		*/
	}

	public function generateTabs($page)
	{
		$crit = new Criteria;
		$crit->addAscendingOrderByColumn(PageTabPeer::INDEX);
		$tabs = $page->getPageTabs($crit);

		if (count($tabs) <= 0) {
			return $page->getDescription();
		}

		$html = '<ul class="page-tabs">';
		foreach ($tabs as $tab) {
			$html .= '<li>';
			$html .= '	<a href="#">'. $tab->getName() .'</a>';
			$html .= '	<div>'.$tab->getDescription().'</div>';
			$html .= '</li>';
		}
		$html .= '</ul>';

		return str_replace("{tabs}", $html, $page->getDescription());
	}
}
?>
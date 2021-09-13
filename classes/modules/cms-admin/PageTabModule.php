<?php
include_once 'AbstractAdminModule.php';

class PageTabModule extends AbstractAdminModule
{
	protected $oPageTab;
	protected $oPage;
	
	public function isRedirect()
	{
		if(parent::isRedirect()) return true;
		
		$this->oPage = PagePeer::retrieveByPK($this->oData->get('sub'));
		if($this->oPage instanceof Page)
			return false;
	}

	public function getRedirectModule()
	{
		return array('','Page');
	}
	
	public function isAuthorized()
	{
		if($this->isAdminLogin() && !$this->isRedirect())
			return in_array('Page', $this->oLoginAdmin->getPrivilegesArray());
		else
			return parent::isAuthorized();
	}
	
	public function getName()
	{
		$sName = 'Page Tab ';
		if($this->oPage instanceof Page && !$this->oPage->isNew())
			$sName .= ' : '.$this->oPage->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oPageTab = PageTabPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oPageTab instanceof PageTab)
		{
			$this->oPageTab = new PageTab();
		}

		$this->addLink('sub='. $this->oPage->getPrimaryKey());
	}

	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();

				$this->aContext['oPageTab'] = $this->oPageTab;
				break;
		}
	}
	
	
	public function doBuildTemplate()
	{
		if($this->oData->isExists('delete'))
		{
			$this->doDelete();
		}
		else if($this->oData->isExists('deleteChecked'))
		{
			if(is_array($this->oData->get('c')))
			{
				foreach($this->oData->get('c') as $id)
				{
					$this->oPageTab = PageTabPeer::retrieveByPK($id);
					
					if($this->oPageTab instanceof PageTab)
					{
						$this->doDelete();
					}
				}
				$this->oPageTab = new PageTab();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(PageTabPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oPage'] = $this->oPage;
		$this->aContext['aPageTab'] = PageTabPeer::getByPage(
			$this->oPage,
			$this->doHandleParameter(),
			$this->getSortable(),
			$this->getPageList(),
			$oPager
		);

		$this->regPageList(
			$oPager
		);
	}
	
	private function doSave()
	{
		$this->oPageTab->setDescription($this->oData->get('description'));
		$this->doValidate($this->oPageTab);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oPageTab->setPage($this->oPage);
				if($this->oPageTab->getIndex() === null) $this->oPageTab->setIndex(0);
				$this->oPageTab->save();
							
				$oCon->commit();
				
				$this->info('succeed-page_tab-saved',
					array(
						$this->oPageTab->getName()
					)
				);
				
				$this->oPageTab = new PageTab();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				
				$this->error('failed-page_tab-saved',
					array(
						$this->oPageTab->getName(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
	}

	private function doDelete()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
			
			$this->oPageTab->delete();
			$oCon->commit();
			
			$this->info('succeed-page_tab-deleted',
				array(
					$this->oPageTab->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-page_tab-deleted',
				array(
					$this->oPageTab->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oPageTab = new PageTab();
	}
}
?>
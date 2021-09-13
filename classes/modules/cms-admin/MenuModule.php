<?php
include_once 'AbstractAdminModule.php';

class MenuModule extends AbstractAdminModule
{
	protected $oMenu;
	protected $oParentMenu;
	protected $sGroup;
	protected $bMulti = true;

	public function getName()
	{
		$sName = 'Menu';
		
		if($this->sGroup == 'main')
			$sName = 'Main Menu';
		elseif($this->sGroup == 'main')
			$sName = 'Footer Link';
		
		return $sName;
	}
	
	public function init()
	{
		$this->oMenu = MenuPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oMenu instanceof Menu)
		{
			$this->oMenu = new Menu();
		}
		
		$this->oParentMenu = MenuPeer::retrieveByPK($this->oData->get('sub'));
		
		$this->sGroup = $this->oData->get('mode','main');
		$this->addLink('mode='.$this->oData->get('mode'));
		
		if($this->sGroup == 'quick') $this->bMulti = false;
		$this->aContext['bMulti'] = $this->bMulti;
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'product':
				$aData = array();
				$oParam = new Parameter();
				$oParam->set('keywords',$this->oData->get('q'));
				$aPage = PagePeer::getAll(
					$oParam,null,1,$null,$this->oData->get('limit')
				);
				foreach ($aPage as $oPage)
				{
					$aData[] = array( 
						'id' => $oPage->getId(),
						'name' => $oPage->getName()
					);
				}
				$this->aContext['aData'] = $aData;
				break;
				
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();
				
				if($this->oParentMenu instanceof Menu)
					$this->addLink('sub='.$this->oData->get('sub'));
				
				$this->aContext['oMenu'] = $this->oMenu;
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
					$this->oMenu = MenuPeer::retrieveByPK($id);
					
					if($this->oMenu instanceof Menu)
					{
						$this->doDelete();
					}
				}
				$this->oMenu = new Menu();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(MenuPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$oParam = $this->doHandleParameter();
		if($this->oParentMenu instanceof Menu)
		{
			$this->aContext['oParentMenu'] = $this->oParentMenu;
			$oParam->set('parentId',$this->oParentMenu->getId());
			$this->addLink('sub='.$this->oData->get('sub'));
		}	
		
		$this->aContext['aMenu'] = MenuPeer::getByGroup(
			$this->sGroup,
			$oParam,
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
		if($this->oMenu->getType() == 2)
		{
			if($this->oData->get('pageType') == 1)
			{
				if($oPage = PagePeer::retrieveByPK($this->oData->get('productid')))
					$this->oMenu->setValue($oPage->getId());
				else
					$this->errorInline('pageType','not_existed-page');
			}
			else if($this->oData->get('pageType') == 2)
			{
				if(!$this->oData->isExists('pageName'))
					$this->error('required-page_name');
			}
		}
		else if($this->oMenu->getType() == 3)
		{
			$this->oMenu->setValue($this->oData->get('moduleName'));
		}
		else if($this->oMenu->getType() == 4)
		{
			$this->oMenu->setValue($this->oData->get('categoryId'));
		}
		else if($this->oMenu->getType() == 5)
		{
			$this->oMenu->setValue($this->oData->get('promoId'));
		}
		
		/*
		$this->oMenu->setName($this->oData->get('nameen'),'en');
		$this->oMenu->setName($this->oData->get('namecn'),'jp');
		*/
		
		$this->doValidate($this->oMenu);
		
		if(!$this->oMenu->getName('en'))
			$this->errorInline('menuName','required-name');
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				
				if($this->oParentMenu instanceof Menu)
					$this->oMenu->setParentId($this->oParentMenu->getId());
				
				if($this->oMenu->getType() == 2 && $this->oData->get('pageType') == 2)
				{
					$sCode = Common::parseSaveURLString($this->oData->get('pageName'));
					while($oTempPage = PagePeer::getByCode($sCode))
					{
						$sCode = $sCode.rand(1,9);
					}
					
					$oPage = new Page();
					$oPage->setName($this->oData->get('pageName'));
					$oPage->setCode($sCode);
					$oPage->setDescription($this->oData->get('pageDescription'));
					$oPage->save();
					$this->oMenu->setValue($oPage->getId());
				}
				
				$this->oMenu->setGroup($this->sGroup);
				if($this->oMenu->getIndex() === null) $this->oMenu->setIndex(0);
				$this->oMenu->save();
				
				$oCon->commit();
				
				$_POST = null;

				$this->info('succeed-menu-saved',
					array(
						$this->oMenu->getName()
					)
				);
				
				$this->oMenu = new Menu();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				$this->error('failed-menu-saved',
					array(
						$this->oMenu->getName(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
		else
			if($sFile && is_file($sFile))	unlink($sFile);
	}
	
	private function doDelete()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
			$this->oMenu->delete();
			$oCon->commit();
			
			$this->info('succeed-menu-deleted',
				array(
					$this->oMenu->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-menu-deleted',
				array(
					$this->oMenu->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oMenu = new Menu();
	}
}
?>
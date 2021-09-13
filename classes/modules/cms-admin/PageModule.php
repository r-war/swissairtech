<?php
include_once 'AbstractAdminModule.php';

class PageModule extends AbstractAdminModule
{
	protected $oPage;
	
	public function getName()
	{
		$sName = 'Page ';
		if($this->oPage instanceof Page && !$this->oPage->isNew())
			$sName .= ' : '.$this->oPage->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oPage = PagePeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oPage instanceof Page)
		{
			$this->oPage = new Page();
		}
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();
				
				$this->aContext['oPage'] = $this->oPage;
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
					$this->oPage = PagePeer::retrieveByPK($id);
					
					if($this->oPage instanceof Page)
					{
						$this->doDelete();
					}
					else 
					{
						$this->oPage = new Page();
					}
				}
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(PagePeer::getFieldNames(BasePeer::TYPE_COLNAME));
		
		$this->aContext['aPage'] = PagePeer::getAll(
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
		if($this->oPage->getCode() == '')
			$this->oPage->setCode(Common::parseSaveURLString($this->oPage->getName()));
		
		$this->oPage->setDescription($this->oData->get('description'));
		$this->doValidate($this->oPage);
		
		if($_FILES['picture']['name'])
		{
			$sFilename = $this->processUpload(
					'picture',
					'contents/images/',
					explode(',','jpg,jpeg,png,gif,bmp'),
					null,
					false,
					true,
					null,
					array(),
					array(2500, null, 0)
			);
			
			if($sFilename)
			{
				$sFile = 'contents/images/'.$sFilename;
				if($this->oPage->getPicture() != '')
				{
					$sOldFile = 'contents/images/'.$this->oPage->getPicture();
				}
				$this->oPage->setPicture($sFilename);
			}
		}
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oPage->setDate(Application::getFormalDateTime());
				$this->oPage->save();
							
				$oCon->commit();
				
				if($sOldFile && is_file($sOldFile))	unlink($sOldFile);

				$this->info('succeed-page-saved',
					array(
						$this->oPage->getName()
					)
				);
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if($sFile && is_file($sFile))	unlink($sFile);			
				$this->error('failed-page-saved',
					array(
						$this->oPage->getName(),
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
			
			$sFile = 'contents/images/'.$this->oPage->getPicture();
			$this->oPage->delete();
			
			$oCon->commit();
			
			if($sFile && is_file($sFile))	unlink($sFile);
			
			$this->info('succeed-page-deleted',
				array(
					$this->oPage->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-page-deleted',
				array(
					$this->oPage->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oPage = new Page();
	}
}
?>
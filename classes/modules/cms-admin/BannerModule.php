<?php
include_once 'AbstractAdminModule.php';

class BannerModule extends AbstractAdminModule
{
	protected $oBanner;
	protected $sType;

	public function getName()
	{
		$sName = 'banner';

		return $this->oLoc->get($sName);
	}
	
	public function init()
	{
		$this->oBanner = BannerPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oBanner instanceof Banner)
		{
			$this->oBanner = new Banner();
		}
		
		$this->sType = $this->oData->get('mode','sliding');
		$this->addLink('mode='.$this->oData->get('mode'));
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();
				$this->aContext['oBanner'] = $this->oBanner;
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
					$this->oBanner = BannerPeer::retrieveByPK($id);
					
					if($this->oBanner instanceof Banner)
					{
						$this->doDelete();
					}
				}
				$this->oBanner = new Banner();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(BannerPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['aBanner'] = BannerPeer::getByGroup(
			$this->sType,
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
		if($_FILES['picture']['name'])
		{
			$aSize = array(940, null, 1);
			if ($this->sType == 'sliding')
				$aSize = array(1920, null, 1);
			
			$sFilename = $this->processUpload(
					'picture',
					'contents/images/',
					explode(',',BannerPeer::FILE_TYPE_IMAGE),
					null,
					false,
					true,
					null,
					array(),
					$aSize
			);
			
			if($sFilename)
			{
				$sFile = 'contents/images/'.$sFilename;
				if($this->oBanner->getPicture() != '')
				{
					$sOldFile = 'contents/images/'.$this->oBanner->getPicture();
				}
				$this->oBanner->setPicture($sFilename);
			}
		}
		$this->oBanner->setDescription($this->oData->get('description'));
		$this->doValidate($this->oBanner);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				if($this->oBanner->getIndex() === null) $this->oBanner->setIndex(0);
				$this->oBanner->setGroup($this->sType);
				$this->oBanner->save();
				
				$oCon->commit();

				if($sOldFile && is_file($sOldFile))	unlink($sOldFile);
				
				$this->info('succeed-banner-saved',
					array(
						$this->oBanner->getPicture()
					)
				);
				
				$this->oBanner = new Banner();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if($sFile && is_file($sFile))	unlink($sFile);							
				$this->error('failed-banner-saved',
					array(
						$this->oBanner->getPicture(),
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
			
			$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oBanner->getPicture();
			$this->oBanner->delete();
			$oCon->commit();
			
			if($sFile && is_file($sFile))	unlink($sFile);
			
			$this->info('succeed-banner-deleted',
				array(
					$this->oBanner->getPicture()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-banner-deleted',
				array(
					$this->oBanner->getPicture(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oBanner = new Banner();
	}
}
?>
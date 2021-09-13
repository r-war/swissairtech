<?php
include_once 'AbstractAdminModule.php';

class GalleryPictureModule extends AbstractAdminModule
{
	protected $oGalleryPicture;
	protected $oGallery;

	public function isRedirect()
	{
		if(parent::isRedirect()) return true;
		
		$this->oGallery = GalleryPeer::retrieveByPK($this->oData->get('sub'));
		if($this->oGallery instanceof Gallery)
			return false;
	}

	public function getRedirectModule()
	{
		return array('','Gallery');
	}
	
	public function isAuthorized()
	{
		if($this->isAdminLogin() && !$this->isRedirect())
			return in_array('Gallery', $this->oLoginAdmin->getPrivilegesArray());
		else
			return parent::isAuthorized();
	}
	
	public function getName()
	{
		$sName = 'gallery_picture';

		return $this->oLoc->get($sName);
	}
	
	public function init()
	{
		$this->oGalleryPicture = GalleryPicturePeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oGalleryPicture instanceof GalleryPicture)
		{
			$this->oGalleryPicture = new GalleryPicture();
		}
		
		$this->addLink('sub='. $this->oGallery->getPrimaryKey());
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('save'))
					$this->doSave();
				$this->aContext['oGalleryPicture'] = $this->oGalleryPicture;
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
					$this->oGalleryPicture = GalleryPicturePeer::retrieveByPK($id);
					
					if($this->oGalleryPicture instanceof GalleryPicture)
					{
						$this->doDelete();
					}
					else 
					{
						$this->oGalleryPicture = new GalleryPicture();
					}
				}
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(GalleryPicturePeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oGallery'] = $this->oGallery;
		$this->aContext['aGalleryPicture'] = GalleryPicturePeer::getByGroup(
			$this->oGallery,
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
			$aSize = array(1600,900);
			
			$sFilename = $this->processUpload(
					'picture',
					'contents/'.$this->oApp->sDomain.'/images/',
					explode(',',GalleryPicturePeer::FILE_TYPE_IMAGE),
					null,
					false,
					true,
					null,
					array(),
					$aSize
			);
			
			if($sFilename)
			{
				$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$sFilename;
				if($this->oGalleryPicture->getPicture() != '')
				{
					$sOldFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oGalleryPicture->getPicture();
				}
				$this->oGalleryPicture->setPicture($sFilename);
			}
		}
		$this->doValidate($this->oGalleryPicture);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				if($this->oGalleryPicture->getIndex() === null) $this->oGalleryPicture->setIndex(0);
				$this->oGalleryPicture->setGalleryId($this->oGallery->getId());
				$this->oGalleryPicture->save();
				
				$oCon->commit();

				if($sOldFile && is_file($sOldFile))	unlink($sOldFile);
				
				$this->info('succeed-gallery_picture-saved',
					array(
						$this->oGalleryPicture->getPicture()
					)
				);
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if($sFile && is_file($sFile))	unlink($sFile);							
				$this->error('failed-gallery_picture-saved',
					array(
						$this->oGalleryPicture->getPicture(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
			$this->oGalleryPicture = new GalleryPicture();
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
			
			$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oGalleryPicture->getPicture();
			$this->oGalleryPicture->delete();
			$oCon->commit();
			
			if($sFile && is_file($sFile))	unlink($sFile);
			
			$this->info('succeed-gallery_picture-deleted',
				array(
					$this->oGalleryPicture->getPicture()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-gallery_picture-deleted',
				array(
					$this->oGalleryPicture->getPicture(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oGalleryPicture = new GalleryPicture();
	}
}
?>
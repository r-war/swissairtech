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
		$sName = 'Gallery Picture ';
		if($this->oGallery instanceof Gallery && !$this->oGallery->isNew() && !$this->oGalleryPicture->isNew())
			$sName .= ' : '.$this->oGallery->getName();
		return $sName;
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
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
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
				}
				$this->oGalleryPicture = new GalleryPicture();
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
			$sFilename = $this->processUpload(
					'picture',
					'contents/'.$this->oApp->sDomain.'/images/',
					explode(',',BannerPeer::FILE_TYPE_IMAGE),
					null,
					false,
					true
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
		if($this->oGalleryPicture->getPicture() == '')
			$this->errorInline('picture', 'required-picture');
		
		$this->doValidate($this->oGalleryPicture);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oGalleryPicture->setGalleryId($this->oGallery->getId());
				if($this->oGalleryPicture->getIndex() === null) $this->oGalleryPicture->setIndex(0);
				
				$this->oGalleryPicture->save();
							
				$oCon->commit();
				if($sOldFile && is_file($sOldFile))	unlink($sOldFile);
				$this->info('succeed-gallery_picture-saved',
					array(
						$this->oGalleryPicture->getPicture()
					)
				);
				$this->oGalleryPicture = new GalleryPicture();
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
		}
		else {
			if($sFile && is_file($sFile))	unlink($sFile);
		}
	}

	private function doDelete()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
			
			$this->oGalleryPicture->delete();
			$oCon->commit();
			
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
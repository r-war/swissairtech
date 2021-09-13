<?php
include_once 'AbstractAdminModule.php';

class GalleryModule extends AbstractAdminModule
{
	protected $oGallery;
	
	public function getName()
	{
		$sCode = $this->oLoc->get('gallery');
		if($this->oGallery instanceof Gallery && !$this->oGallery->isNew())
			$sCode .= ' : '.$this->oGallery->getCode();
		return $sCode;
	}
	
	public function init()
	{
		$this->oGallery = GalleryPeer::retrieveByPK($this->oData->get('select',$this->oData->get('delete')));
		if(!$this->oGallery instanceof Gallery)
		{
			$this->oGallery = new Gallery();
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
				
				$this->aContext['oGallery'] = $this->oGallery;
				
				break;
		}
	}
	
	public function doBuildTemplate()
	{
		if($this->oData->isExists('delete'))
		{
			$this->doDelete();
		}
		elseif($_FILES['uploadfile']['name'])
		{
			$this->doImport();
		}
		else if($this->oData->isExists('deleteChecked'))
		{
			if(is_array($this->oData->get('c')))
			{
				foreach($this->oData->get('c') as $id)
				{
					$this->oGallery = GalleryPeer::retrieveByPK($id);
					
					if($this->oGallery instanceof Gallery)
					{
						$this->doDelete();
					}
				}
				$this->oGallery = new Gallery();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(
			array_merge(
				GalleryPeer::getFieldNames(BasePeer::TYPE_COLNAME)
			)
		);
		
		$this->aContext['aGallery'] = GalleryPeer::getAll(
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
		if($this->oGallery->isNew()) $bRedirect = true;

		$this->oGallery->setName($this->oData->get('name'),'en');
		$this->oGallery->setDescription($this->oData->get('description'),'en');
		$this->oGallery->setName($this->oData->get('namecn'),'cn');
		$this->oGallery->setDescription($this->oData->get('descriptioncn'),'cn');
		
		$this->oGallery->setCode(Common::parseSaveURLString($this->oGallery->getName('en')));
		$this->doValidate($this->oGallery);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				if($this->oGallery->getIndex() === null) $this->oGallery->setIndex(0);
				$this->oGallery->save();
				$oCon->commit();
				
				$this->info('succeed-gallery-saved',
					array(
						$this->oGallery->getName('en')
					)
				);
				$this->oGallery = new Gallery();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				
				$this->error('failed-gallery-saved',
					array(
						$this->oGallery->getCode(),
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
				
			$this->oGallery->delete();
			$oCon->commit();
			
			$this->info('succeed-gallery-deleted',
				array(
					$this->oGallery->getCode()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-gallery-deleted',
				array(
					$this->oGallery->getCode(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oGallery = new Gallery();
	}
}
?>
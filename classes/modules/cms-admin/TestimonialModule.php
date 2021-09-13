<?php
include_once 'AbstractAdminModule.php';

class TestimonialModule extends AbstractAdminModule
{
	protected $oTestimonial;

	public function getName()
	{
		$sName = 'Testimonial ';
		if($this->oTestimonial instanceof Testimonial && !$this->oTestimonial->isNew())
			$sName .= ' : '.$this->oTestimonial->getName();
		return $sName;		
		
		return $this->oLoc->get($sName);
	}

	public function init()
	{
		$this->oTestimonial = TestimonialPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oTestimonial instanceof Testimonial)
		{
			$this->oTestimonial = new Testimonial();
		}
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('keywords'))
					$this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('save'))
					$this->doSave();
				$this->aContext['oTestimonial'] = $this->oTestimonial;
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
					$this->oTestimonial = TestimonialPeer::retrieveByPK($id);
					
					if($this->oTestimonial instanceof Testimonial)
					{
						$this->doDelete();
					}
				}
				$this->oTestimonial = new Testimonial();
			}
		}
		$this->prepareTestimonial();
	}
	
	private function prepareTestimonial()
	{
		$this->regSortable(TestimonialPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['oTestimonial'] = $this->oTestimonial;
		$this->aContext['aTestimonial'] = TestimonialPeer::getAll(
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
		$this->doValidate($this->oTestimonial);
		if($_FILES['file']['name'])
		{
			$sFilename = $this->processUpload(
					'file',
					'contents/images/',
					explode(',',ConfigurationPeer::FILE_TYPE_IMAGE),
					null,
					false,
					true,
					null,
					array(),
					array(200, 200, true)
			);
			$sFile = 'contents/images/'.$sFilename;
		}
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				if($sFilename)
				{
					$sOldFile = 'contents/images/'.$this->oTestimonial->getPicture();
					$this->oTestimonial->setPicture($sFilename);
				}
				$this->oTestimonial->save();
				
				$oCon->commit();
				if(is_file($sOldFile)) unlink($sOldFile);
				$this->info('succeed-testimonial-saved',
					array(
						$this->oTestimonial->getName()
					)
				);
				
				$this->oTestimonial = new Testimonial();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
							
				$this->error('failed-testimonial-saved',
					array(
						$this->oTestimonial->getName(),
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
			
			$this->oTestimonial->delete();
			
			$oCon->commit();
			
			$this->info('succeed-testimonial-deleted',
				array(
					$this->oTestimonial->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-testimonial-deleted',
				array(
					$this->oTestimonial->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oTestimonial = new Testimonial();
	}
}
?>
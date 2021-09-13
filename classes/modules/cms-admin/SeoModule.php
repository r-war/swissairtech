<?php
include_once 'AbstractAdminModule.php';

class SeoModule extends AbstractAdminModule
{
	protected $oSeo;
	
	public function getName()
	{
		$sName = 'SEO ';
		if($this->oSeo instanceof Seo && !$this->oSeo->isNew())
			$sName .= ' : '.$this->oSeo->getUrl();
		return $sName;
	}
	
	public function init()
	{
		$this->oSeo = SeoPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oSeo instanceof Seo)
		{
			$this->oSeo = new Seo();
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
				
				$this->aContext['oSeo'] = $this->oSeo;
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
					$this->oSeo = SeoPeer::retrieveByPK($id);
					
					if($this->oSeo instanceof Seo)
					{
						$this->doDelete();
					}
				}
				$this->oSeo = new Seo();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(SeoPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		
		$this->aContext['aSeo'] = SeoPeer::getAll(
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
		$this->doValidate($this->oSeo);

		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oSeo->save();
							
				$oCon->commit();
				
				$this->info('succeed-seo-saved',
					array(
						$this->oSeo->getUrl()
					)
				);
				
				$this->oSeo = new Seo();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if($sFile && is_file($sFile))	unlink($sFile);			
				$this->error('failed-seo-saved',
					array(
						$this->oSeo->getUrl(),
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
			
			$this->oSeo->delete();
			
			$oCon->commit();
			
			$this->info('succeed-seo-deleted',
				array(
					$this->oSeo->getUrl()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-seo-deleted',
				array(
					$this->oSeo->getUrl(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oSeo = new Seo();
	}
}
?>
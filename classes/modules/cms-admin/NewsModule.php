 <?php
include_once 'AbstractAdminModule.php';

class NewsModule extends AbstractAdminModule
{
	protected $oNews;

	public function getName()
	{
		$sName = 'News ';
		if ($_GET['mode'] != '')
			$sName = ucfirst($_GET['mode']);

		if($this->oNews instanceof News && !$this->oNews->isNew())
			$sName .= ' : '.$this->oNews->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oNews = NewsPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oNews instanceof News)
		{
			$this->oNews = new News();
			$this->oNews->setDate(Application::getFormalDateTime());
		}

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
				$this->aContext['oNews'] = $this->oNews;
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
					$this->oNews = NewsPeer::retrieveByPK($id);
					
					if($this->oNews instanceof News)
					{
						$this->doDelete();
					}
				}
				$this->oNews = new News();
				$this->oNews->setDate(Application::getFormalDateTime());
			}
		}

		$this->prepareNews();
	}
	
	private function prepareNews()
	{
		$this->regSortable(NewsPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		
		$this->aContext['aNews'] = NewsPeer::getByType(
			$_GET['mode'],
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
		if($this->oNews->isNew())
		{
			$sCode = Common::parseSaveURLString($this->oNews->getName());
			while($oTempPage = NewsPeer::getByCode($sCode))
			{
				$sCode = $sCode.rand(1,9);
			}
			$this->oNews->setCode($sCode);
		}
		else {
			$sCode = Common::parseSaveURLString($this->oNews->getCode());
			$this->oNews->setCode($sCode);
		}
		$this->oNews->setShortDescription($this->oData->get('shortDescription'));
		$this->oNews->setDescription($this->oData->get('description'));
		$this->doValidate($this->oNews);
		if($_FILES['file']['name'])
		{
			$sFilename = $this->processUpload(
					'file',
					'contents/images/',
					explode(',',ConfigurationPeer::FILE_TYPE_IMAGE),
					null,
					false,
					true
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
					$sOldFile = 'contents/images/'.$this->oNews->getPicture();
					$this->oNews->setPicture($sFilename);
				}
				$this->oNews->save();
							
				$oCon->commit();
				if(is_file($sOldFile)) unlink($sOldFile);
				$this->info('succeed-news-saved',
					array(
						$this->oNews->getName()
					)
				);
				
				$this->oNews = new News();
				$this->oNews->setDate(Application::getFormalDateTime());
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if(is_file($sFile)) unlink($sFile);
					
				$this->error('failed-news-saved',
					array(
						$this->oNews->getName(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
		else {
			if(is_file($sFile)) unlink($sFile);
		}
	}
	
	private function doDelete()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
			
			$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oNews->getPicture();
			$this->oNews->delete();
			
			$oCon->commit();
			if(is_file($sFile)) unlink($sFile);
			
			$this->info('succeed-news-deleted',
				array(
					$this->oNews->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-news-deleted',
				array(
					$this->oNews->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oNews = new News();
		$this->oNews->setDate(Application::getFormalDateTime());
	}
}
?>
 <?php
include_once 'AbstractAdminModule.php';

class ServiceModule extends AbstractAdminModule
{
	protected $oService;

	public function getName()
	{
		$sName = 'Service ';
		if($this->oService instanceof Service && !$this->oService->isNew())
			$sName .= ' : '.$this->oService->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oService = ServicePeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oService instanceof Service)
		{
			$this->oService = new Service();
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
				$this->aContext['oService'] = $this->oService;
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
					$this->oService = ServicePeer::retrieveByPK($id);
					
					if($this->oService instanceof Service)
					{
						$this->doDelete();
					}
				}
				$this->oService = new Service();
			}
		}
		$this->prepareService();
	}
	
	private function prepareService()
	{
		$this->regSortable(ServicePeer::getFieldNames(BasePeer::TYPE_COLNAME));
		
		$this->aContext['aService'] = ServicePeer::getAll(
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
		if($this->oService->isNew())
		{
			$sCode = Common::parseSaveURLString($this->oService->getName());
			while($oTempPage = ServicePeer::getByCode($sCode))
			{
				$sCode = $sCode.rand(1,9);
			}
			$this->oService->setCode($sCode);
		}
		$this->oService->setName($this->oData->get('name'),'en');
		$this->oService->setDescription($this->oData->get('description'),'en');
		$this->oService->setName($this->oData->get('namecn'),'it');
		$this->oService->setDescription($this->oData->get('descriptioncn'),'it');

		$this->doValidate($this->oService);
		if($_FILES['file']['name'])
		{
			$aSize = array(242,242,1);
			$sFilename = $this->processUpload(
					'file',
					'contents/'.$this->oApp->sDomain.'/images/',
					explode(',',ConfigurationPeer::FILE_TYPE_IMAGE),
					null,
					false,
					true,
					null,
					array(),
					$aSize
			);
			$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$sFilename;
		}
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				if($sFilename)
				{
					$sOldFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oService->getPicture();
					$this->oService->setPicture($sFilename);
				}
				$this->oService->save();
							
				$oCon->commit();
				if(is_file($sOldFile)) unlink($sOldFile);
				$this->info('succeed-service-saved',
					array(
						$this->oService->getName()
					)
				);
				
				$this->oService = new Service();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if(is_file($sFile)) unlink($sFile);
					
				$this->error('failed-service-saved',
					array(
						$this->oService->getName(),
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
			
			$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oService->getPicture();
			$this->oService->delete();
			
			$oCon->commit();
			if(is_file($sFile)) unlink($sFile);
			
			$this->info('succeed-service-deleted',
				array(
					$this->oService->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-service-deleted',
				array(
					$this->oService->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oService = new Service();
	}
}
?>
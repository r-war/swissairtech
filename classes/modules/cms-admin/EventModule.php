 <?php
include_once 'AbstractAdminModule.php';

class EventModule extends AbstractAdminModule
{
	protected $oEvent;

	public function getName()
	{
		$sName = 'Event ';
		if($this->oEvent instanceof Event && !$this->oEvent->isNew())
			$sName .= ' : '.$this->oEvent->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oEvent = EventPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oEvent instanceof Event)
		{
			$this->oEvent = new Event();
			$this->oEvent->setDate(Application::getFormalDateTime());
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
				$this->aContext['oEvent'] = $this->oEvent;
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
					$this->oEvent = EventPeer::retrieveByPK($id);
					
					if($this->oEvent instanceof Event)
					{
						$this->doDelete();
					}
				}
				$this->oEvent = new Event();
				$this->oEvent->setDate(Application::getFormalDateTime());
			}
		}
		$this->prepareEvent();
	}
	
	private function prepareEvent()
	{
		$this->regSortable(EventPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		
		$this->aContext['aEvent'] = EventPeer::getAll(
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
		if($this->oEvent->isNew())
		{
			$sCode = Common::parseSaveURLString($this->oEvent->getName());
			while($oTempPage = EventPeer::getByCode($sCode))
			{
				$sCode = $sCode.rand(1,9);
			}
			$this->oEvent->setCode($sCode);
		}
				
		$this->oEvent->setName($this->oData->get('name'),'en');
		$this->oEvent->setDescription($this->oData->get('description'),'en');
		$this->oEvent->setName($this->oData->get('namecn'),'it');
		$this->oEvent->setDescription($this->oData->get('descriptioncn'),'it');

		$this->doValidate($this->oEvent);
		if($_FILES['file']['name'])
		{
			$sFilename = $this->processUpload(
					'file',
					'contents/'.$this->oApp->sDomain.'/images/',
					explode(',',ConfigurationPeer::FILE_TYPE_IMAGE),
					null,
					false,
					true
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
					$sOldFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oEvent->getPicture();
					$this->oEvent->setPicture($sFilename);
				}
				$this->oEvent->save();
							
				$oCon->commit();
				if(is_file($sOldFile)) unlink($sOldFile);
				$this->info('succeed-event-saved',
					array(
						$this->oEvent->getName()
					)
				);
				
				$this->oEvent = new Event();
				$this->oEvent->setDate(Application::getFormalDateTime());
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
				if(is_file($sFile)) unlink($sFile);
					
				$this->error('failed-event-saved',
					array(
						$this->oEvent->getName(),
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
			
			$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$this->oEvent->getPicture();
			$this->oEvent->delete();
			
			$oCon->commit();
			if(is_file($sFile)) unlink($sFile);
			
			$this->info('succeed-event-deleted',
				array(
					$this->oEvent->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-event-deleted',
				array(
					$this->oEvent->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oEvent = new Event();
		$this->oEvent->setDate(Application::getFormalDateTime());
	}
}
?>
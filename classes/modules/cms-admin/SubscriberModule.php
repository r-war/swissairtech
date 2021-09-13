<?php
include_once 'AbstractAdminModule.php';

class SubscriberModule extends AbstractAdminModule
{
	protected $oSubscriber;

	public function getName()
	{
		$sName = 'Mailing List';
		if($this->oSubscriber instanceof Subscriber && !$this->oSubscriber->isNew())
			$sName .= ' : '.$this->oSubscriber->getName();
		return $sName;		
		
		return $this->oLoc->get($sName);
	}
	
	public function init()
	{
		$this->oSubscriber = SubscriberPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oSubscriber instanceof Subscriber)
		{
			$this->oSubscriber = new Subscriber();
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
				$this->aContext['oSubscriber'] = $this->oSubscriber;
			break;

		}
	}
	
	public function doBuildTemplate()
	{
		
		if($this->oData->isExists('dl'))
		{
			$this->doDownload();
		}
		else if($this->oData->isExists('delete'))
		{
			$this->doDelete();
		}
		else if($this->oData->isExists('deleteChecked'))
		{
			if(is_array($this->oData->get('c')))
			{
				foreach($this->oData->get('c') as $id)
				{
					$this->oSubscriber = SubscriberPeer::retrieveByPK($id);
					
					if($this->oSubscriber instanceof Subscriber)
					{
						$this->doDelete();
					}
				}
				$this->oSubscriber = new Subscriber();
			}
		}
		$this->prepareSubscriber();
	}
	
	private function prepareSubscriber()
	{
		$this->regSortable(SubscriberPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['aSubscriber'] = SubscriberPeer::getAll(
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
		$this->doValidate($this->oSubscriber);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oSubscriber->setDate(Application::getFormalDateTime());
				$this->oSubscriber->save();
							
				$oCon->commit();

				$this->info('succeed-subscriber-saved',
					array(
						$this->oSubscriber->getName()
					)
				);
				
				$this->oSubscriber = new Subscriber();
 			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
							
				$this->error('failed-subscriber-saved',
					array(
						$this->oSubscriber->getName(),
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
			
			$this->oSubscriber->delete();
			
			$oCon->commit();
			
			$this->info('succeed-subscriber-deleted',
				array(
					$this->oSubscriber->getName()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-subscriber-deleted',
				array(
					$this->oSubscriber->getName(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oSubscriber = new Subscriber();
	}
	
	protected function doDownload()
	{
		$this->useTemplate(false);
		$aWarranty = SubscriberPeer::getAll();
	
		include_once Attributes::CLASS_PATH.'PHPExcel/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Name')
		            ->setCellValue('B1', 'Email')
					->setCellValue('C1', 'Active');
	
		$id = 3;
		foreach ($aWarranty as $oPart)
		{
			$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A'.$id, $oPart->getName())
		            ->setCellValue('B'.$id, $oPart->getEmail())
					->setCellValue('C'.$id, $oPart->getActiveView());
			$id++;
		}
	
		$filename = "subscriber_data";
		$filename .= ".xls";
		
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}		
}
?>
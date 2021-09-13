<?php
include_once 'AbstractAdminModule.php';

class UserModule extends AbstractAdminModule
{
	protected $oUser;

	public function getName()
	{
		$sName = 'User ';
		if($this->oUser instanceof User && !$this->oUser->isNew())
			$sName .= ' : '.$this->oUser->getName();
		return $sName;
	}
	
	public function init()
	{
		$this->oUser = UserPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oUser instanceof User)
		{
			$this->oUser = new User();
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
				
				$this->aContext['oUser'] = $this->oUser;
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
					$this->oUser = UserPeer::retrieveByPK($id);
					
					if($this->oUser instanceof User)
					{
						$this->doDelete();
					}
				}
				$this->oUser = new User();
			}
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(UserPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		
		$this->aContext['aUser'] = UserPeer::getAll(
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
		if($this->oData->isExists('password'))
		{
			if(strlen($this->oData->get('password')) < 6)
				$this->errorInline('password','min_length-password-6');
			elseif($this->oData->get('password') != $this->oData->get('password_confirm'))
				$this->errorInline('password_confirm','not_match-password');
			else
				$this->oUser->setPassword($this->oData->get('password'));
		}			

		if($this->oUser->isNew())
		{
			$sPassword = uniqid().rand(100,999);
			$this->oUser->setPassword($sPassword);
			$bSentEmail = true;
		}	

		$this->doValidate($this->oUser);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oUser->setDate(Application::getFormalDateTime());
				$this->oUser->save();
							
				if($this->doEmail($sPassword))
				{
					$oCon->commit();
					
					$this->info('succeed-user-saved',
						array(
							$this->oUser->getEmail()
						)
					);
					
					
					$this->oUser = new User();
				}
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
							
				$this->error('failed-user-saved',
					array(
						$this->oUser->getEmail(),
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
			
			$this->oUser->delete();
			
			$oCon->commit();
			
			$this->info('succeed-user-deleted',
				array(
					$this->oUser->getEmail()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-user-deleted',
				array(
					$this->oUser->getEmail(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oUser = new User();
	}
	
	protected function doDownload()
	{
		$this->useTemplate(false);
		$aWarranty = UserPeer::getAll();
	
		include_once Attributes::CLASS_PATH.'PHPExcel/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Name')
		            ->setCellValue('B1', 'Email')
					->setCellValue('C1', 'Phone')
					->setCellValue('D1', 'Address')
					->setCellValue('E1', 'Postal')
					->setCellValue('F1', 'Country')
					->setCellValue('G1', 'Total Order');
	
		$id = 3;
		foreach ($aWarranty as $oPart)
		{
			$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A'.$id, $oPart->getName())
		            ->setCellValue('B'.$id, $oPart->getEmail())
					->setCellValue('C'.$id, $oPart->getPhone())
					->setCellValue('D'.$id, $oPart->getAddress())
					->setCellValue('E'.$id, $oPart->getPostal())
					->setCellValue('F'.$id, $oPart->getCountry())
					->setCellValue('G'.$id, $oPart->getTotalOrder())
					;
			$id++;
		}
	
		$filename = "user_data";
		$filename .= ".xls";
		
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	private function doEmail($sPassword)
	{
		$aEmailTo = array();
		$sConfigEmail = $this->aConfig['email_enquiry'];
		$aEmail = explode(',', $sConfigEmail);
		foreach ($aEmail as $sEmailTemp)
		{
			$aEmailTo[] = array(trim($sEmailTemp),trim($sEmailTemp));
		}
		
		$aSmtp['host'] = $this->aConfig['smtp_host'];
   		$aSmtp['username'] = $this->aConfig['smtp_user'];
        $aSmtp['password'] = $this->aConfig['smtp_password'];
		$aSmtp['port'] = $this->aConfig['smtp_port'];
        if($aSmtp['host'] == 'smtp.gmail.com')
        	$aSmtp['isgmail'] = true;
		
		$bSuccess = $this->sendMail(
        		array($this->aConfig['email_from'], $this->aConfig['web_title']),
        		array(array($this->oUser->getEmail(), $this->oUser->getName())),
        		$this->aConfig['web_title']. ' : Your registration.',
        		'register.tpl',
        		array(
        				'oUser' => $this->oUser,
        				'sPassword' => $sPassword,
        				'aConfig' => $this->aConfig,
        				'oMod' => $this,
        				'sTitle' => 'Thank you for registering with '.$this->aConfig['web_title']
        		),
        		'text/html',
        		null, null,
        		$aSmtp
        );
		
		return $bSuccess;
	}
}
?>
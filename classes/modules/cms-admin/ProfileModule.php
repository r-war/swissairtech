<?php
include_once 'AbstractAdminModule.php';

class ProfileModule extends AbstractAdminModule
{
	public function init()
	{

	}
	
	public function getName()
	{
		$sName = 'profile';
		
		return $this->oLoc->get($sName);
	}
	
	public function doBuildTemplate()
	{
		$this->setTemplateLayout('layout/simple.tpl');
		if($this->oData->isExists('save'))
		{
			$this->doSave();
		}
	}
	
	private function doSave()
	{
		if($this->oData->isExists('new_password') || $this->oData->isExists('password'))
		{
			if(md5($this->oData->get('password')) != $this->oLoginAdmin->getPassword())
				$this->error('invalid-password');
			elseif(!$this->oData->isExists('new_password'))
				$this->error('required-new_password');
			elseif(strlen($this->oData->get('new_password')) < 6)
				$this->error('min_length-password-6');
			elseif($this->oData->get('new_password') != $this->oData->get('password_confirm'))
				$this->error('not_match-password');
			else
				$this->oLoginAdmin->setPassword($this->oData->get('new_password'));
		}			
		$this->doValidate($this->oLoginAdmin);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oLoginAdmin->setDate(Application::getFormalDateTime());
				$this->oLoginAdmin->save();
				$this->oLoginAdmin->reload();
				
				$oCon->commit();

				$this->info('succeed-profile-updated',
					array(
						$this->oLoginAdmin->getUsername()
					)
				);
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
							
				$this->error('failed-admin-saved',
					array(
						$this->oLoginAdmin->getUsername(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
	}
}
?>
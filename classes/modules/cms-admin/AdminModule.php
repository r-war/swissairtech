<?php
include_once 'AbstractAdminModule.php';

class AdminModule extends AbstractAdminModule
{
	protected $oAdmin;

	public function getName()
	{
		$sName = 'Admin ';
		if($this->oAdmin instanceof Admin && !$this->oAdmin->isNew())
			$sName .= ' : '.$this->oAdmin->getUsername();
		return $sName;
	}

	public function init()
	{
		$this->oAdmin = AdminPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete')
			)
		);
            
		if(!$this->oAdmin instanceof Admin)
		{
			$this->oAdmin = new Admin();
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
				
				$this->aContext['oAdmin'] = $this->oAdmin;
				$this->aContext['aAdminType'] = AdminTypePeer::getAll();
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
					$this->oAdmin = AdminPeer::retrieveByPK($id);
					
					if($this->oAdmin instanceof Admin)
					{
						$this->doDelete();
					}
				}
				$this->oAdmin = new Admin();
			}
		}

		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(AdminPeer::getFieldNames(BasePeer::TYPE_COLNAME));
		$this->aContext['aAdmin'] = AdminPeer::getAll(
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
				$this->oAdmin->setPassword($this->oData->get('password'));
		}
		else
			$this->doValidate($this->oAdmin);
		
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$this->oAdmin->setDate(Application::getFormalDateTime());
				$this->oAdmin->save();
							
				$oCon->commit();

				$this->info('succeed-admin-saved',
					array(
						$this->oAdmin->getUsername()
					)
				);
				
				$this->oAdmin = new Admin();
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
							
				$this->error('failed-admin-saved',
					array(
						$this->oAdmin->getUsername(),
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
			
			$this->oAdmin->delete();
			
			$oCon->commit();
			
			$this->info('succeed-admin-deleted',
				array(
					$this->oAdmin->getUsername()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-admin-deleted',
				array(
					$this->oAdmin->getUsername(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oAdmin = new Admin();
	}
}
?>
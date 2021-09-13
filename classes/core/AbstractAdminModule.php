<?php
include_once 'AbstractCommonModule.php';

abstract class AbstractAdminModule extends AbstractCommonModule 
{
	protected $oLoginAdmin;
	
	public function initModule()
	{
		parent::initModule();

		$this->oLoginAdmin = $this->getSession(Attributes::SESSION_ADMIN_LOGIN);
		$this->aContext['oLoginAdmin'] = $this->oLoginAdmin;
		
	}
	
	public function isRedirect()
	{
		return !$this->isAdminLogin();
	}
	
	public function getRedirectModule()
	{
		return array('','Login');
	}
	
	public function isAdminLogin()
	{
		if($this->oLoginAdmin instanceof Admin)
			return true;
	}
	
	public function isAuthorized()
	{
		$aExceptionModule = array('Default','Login','Logout','Profile');
		
		if($this->isAdminLogin() && !$this->isRedirect() && !in_array($this->getModule(), $aExceptionModule))
			return in_array($this->getModule(), $this->oLoginAdmin->getPrivilegesArray());
		else
			return parent::isAuthorized();
	}
	
	public function isModifyAllowed()
	{
		return true;
	}
	
	public function doHandleParameter()
	{
		$oParam = new Parameter();
		if($this->oData->isExists('keywords'))
		{
			$oParam->set('keywords', $this->oData->get('keywords'));
			$this->addLink('keywords='.urlencode($this->oData->get('keywords')));
		}
		$this->aContext['oParam'] = $oParam;
		
		return $oParam;
	}
}
?>
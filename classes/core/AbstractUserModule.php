<?php
include_once 'AbstractCommonModule.php';

abstract class AbstractUserModule extends AbstractCommonModule 
{
	public function isRedirect()
	{
		return !$this->isUserLogin();
	}
	
	public function getRedirectModule()
	{
		return array('','Login');
	}
	
	public function isUserLogin()
	{
		return $this->getSession(Attributes::SESSION_USER_LOGIN);
	}
}
?>
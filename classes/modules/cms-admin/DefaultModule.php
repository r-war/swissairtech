<?php
include_once 'AbstractAdminModule.php';

class DefaultModule extends AbstractAdminModule
{
	public function init()
	{
		
	}
		
	public function isRedirect()
	{
		return true;
	}
	
	public function getRedirectModule()
	{
		if($this->isAdminLogin())
			return array('','Content');
		else
			return array('','Login');
	}
	
	public function getName()
	{
		$sName = 'home';
		
		return $this->oLoc->get($sName);
	}
	
	public function doBuildTemplate()
	{
		
	}
}
?>
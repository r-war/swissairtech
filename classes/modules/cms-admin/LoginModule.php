<?php
include_once 'AbstractAdminModule.php';

class LoginModule extends AbstractAdminModule
{
	public function isAuthorized()
	{
            return true;
	}
	
	public function isRedirect()
	{
            return $this->isAdminLogin();
	}

	public function getRedirectModule()
	{
            return array('','Default');
	}
	
	public function init()
	{
		
	}
	
	public function getName()
	{
		$sName = 'login';
		
		return $this->oLoc->get($sName);
	}
	
	public function doBuildTemplate()
	{
		$this->setTemplateLayout('layout/simple.tpl');
        if($this->oData->isExists('login'))
			$this->doLogin();
	}
	
	protected function doLogin()
	{
            if(!$this->oData->isExists('username'))
                $this->errorInline('username','required-username');
            if(!$this->oData->isExists('password'))
                $this->errorInline('password','required-password');                    

            if($this->noError())
            {
                if($oAdmin = AdminPeer::validateLogin($this->oData->get('username'),$this->oData->get('password')))
                {
                    session_regenerate_id(true);
					$this->setSession(Attributes::SESSION_ADMIN_LOGIN,$oAdmin);
					$this->setSession(Attributes::SESSION_LOGIN_TIME,time()+ (0.5*60*60));
					
                    // $this->oApp->refreshAllModule();
                    if($oAdmin->isAuthorized(array('Content')))
                    	Application::redirect($this->getBasePage('Default'));
                    else
                        Application::redirect($this->getBasePage($oAdmin->isAuthorized($oAdmin->getPrivilegesArray())));
                }
                else
                {
                   	$this->errorInline('username','invalid-username');
					$this->errorInline('password','invalid-password');
                }
            }
	}
}
?>
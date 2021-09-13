<?php
class DefaultInterceptor extends AbstractInterceptor 
{
	public function doProcessInteceptor()
	{
		// Common::printArray($_SERVER);
		
 		if($this->oData->get('show') == 1)
			$this->aContext['bShowForm'] = true;
		
		$this->handleLogout();
		$this->handleAutoLogout();
		$this->handleCloseUrl();
	}
	
	public function handleLogout()
	{
		if($this->oData->get('logout'))
			$this->destroySession();
	}
	
	public function handleAutoLogout()
	{
		if($this->getSession(Attributes::SESSION_ADMIN_LOGIN))
		{
			if(time() > $this->getSession(Attributes::SESSION_LOGIN_TIME))
			{
				$this->destroySession();
				$this->errorMessage('Login','You are logged out because no activity. Please login again.');
			}
			else
				$this->setSession(Attributes::SESSION_LOGIN_TIME, time()+ (0.5*60*60));
		}
	}
	
	public function handleCloseUrl()
	{
		$sUri = $_SERVER['REQUEST_URI'];
		$sUri = preg_replace('/(\?|&)ajax=(\w+)/i', '', $sUri);
		$sUri = preg_replace('/(\?|&)select=(\w+)/i', '', $sUri);
		
		$this->aContext['sUri'] = $sUri;
	}
}
?>
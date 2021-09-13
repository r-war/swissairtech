<?php
include_once 'AbstractAdminModule.php';

class PrintModule extends AbstractAdminModule
{
	protected $oOrderHeader;
	
	public function init()
	{
		$this->oOrderHeader = OrderHeaderPeer::retrieveByPK(
			$this->oData->get('id')
		);
	}
	
	public function isAuthorized()
	{
		if($this->isAdminLogin() && !$this->isRedirect())
			return in_array('Order', $this->oLoginAdmin->getPrivilegesArray());
		else
			return parent::isAuthorized();
	}
	
	public function getName()
	{
		$sName = 'print';
		
		return $this->oLoc->get($sName);
	}
	
	public function doBuildTemplate()
	{
		$this->setTemplateLayout('layout/blank.tpl');
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->aContext['oOrderHeader'] = $this->oOrderHeader;
	}
}
?>
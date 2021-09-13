<?php
class Parameter
{
	protected $aParam;
	
	public function __construct() 
	{
		$this->aParam = array();
	}
	
	public function set($sKey, &$oValue)
	{
		$this->aParam[$sKey] = &$oValue;
	}
	
	public function get($sKey)
	{
		if($this->isExists($sKey))
		{
			$oValue = $this->aParam[$sKey];
			return $oValue;
		}
		
		return null;
	}
	
	public function isExists($sKey)
	{
		if(isset($this->aParam[$sKey])) return true;
		return false;
	}
}
?>
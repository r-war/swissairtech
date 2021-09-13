<?php
class RunData
{
	protected $aData;
	
	public function __construct() 
	{
		$this->aData = array_merge($_GET,$_POST);
//		$this->aData = array_merge($this->aData,$_FILES);
	}
	
	public function get($sKey,$sDefault = null)
	{
		if(array_key_exists($sKey,$this->aData) && !empty($this->aData[$sKey]))
		{
			return $this->aData[$sKey];
		}
		
		return $sDefault;
	}
	
	public function isExists($sKey,$bEmpty=false)
	{
		if(!$bEmpty)
		{
			return array_key_exists($sKey,$this->aData) && strlen($this->get($sKey))>0;
		}
		else 
		{
			return array_key_exists($sKey,$this->aData);
		}
	}
	
	public function addData($sKey,$sValue)
	{
		$this->aData[$sKey] = $sValue;
	}
	
	public function getData()
	{
		return $this->aData;
	}
	
	public function getPostData()
	{
		return $_POST;
	}
	
	public function getStringData()
	{
		return print_r($this->aData,true);
	}
	
	public function reset()
	{
		$this->aData = array();
		$_GET = array();
		$_POST = array();
	}
}
?>
<?php
class Sortable
{
	protected $sSource;
	protected $sQuery;
	protected $aFields;
	
	public function __construct($aFields, $sInput, $sSource = 'sort')
	{
		$this->sSource = $sSource;
		$this->sQuery = $sInput;
		$this->aFields = $aFields;
	}
	
	public function isAscending($sField=null)
	{
		$aTemp = explode('_',$this->sQuery);
		
		if($sField != null)
		{
			$idx = $this->getFieldIndex($sField);
			if($aTemp[0] == $idx && $aTemp[1] == 'a')
			{
				return true;
			}
		}
		else 
		{
			if(count($aTemp) == 2 && $aTemp[1] == 'a')
			{
				return true;
			}
		}
	}
	
	public function isDescending($sField=null)
	{
		$aTemp = explode('_',$this->sQuery);
		
		if($sField != null)
		{
			$idx = $this->getFieldIndex($sField);
			if($aTemp[0] == $idx && $aTemp[1] == 'd')
			{
				return true;
			}
		}
		else 
		{
			if(count($aTemp) == 2 && $aTemp[1] == 'd')
			{
				return true;
			}
		}
	}
	
	public function getSortField()
	{
		$aTemp = explode('_',$this->sQuery);
		
		if(in_array($aTemp[0],array_keys($this->aFields)))
		{
			return $this->aFields[$aTemp[0]];
		}
		
		return $this->aFields[0];
	}
	
	public function getURL($sField)
	{
		if($this->isValidField($sField))
		{
			$aTemp = explode('_',$this->sQuery);
			$idx = $this->getFieldIndex($sField);
			
			if($aTemp[0] == $idx)
			{
				if($this->isAscending($sField))
				{
					return $this->sSource.'_sort='.$idx.'_d';
				}
				else if($aTemp[1] != null)
				{
					return $this->sSource.'_sort=';
				}
				else 
				{
					return $this->sSource.'_sort='.$idx.'_a';
				}
			}
			else 
			{
				return $this->sSource.'_sort='.$idx.'_a';
			}
		}
	}
	
	protected function isValidField($sField)
	{
//		$aTemp = array();
//		foreach ($this->aFields as $idx => $sAvailableField)
//		{
//			$aTemp2 = explode('.',$sAvailableField);
//			
//			array_push($aTemp,$aTemp2[1]);
//		}
		
		if(in_array($sField,$this->aFields))
		{
			return true;
		}
	}
	
	protected function getFieldIndex($sField)
	{
//		$aTemp = array();
//		foreach ($this->aFields as $idx => $sAvailableField)
//		{
//			$aTemp2 = explode('.',$sAvailableField);
//			
//			array_push($aTemp,$aTemp2[1]);
//		}
		
		$aTemp = array_flip($this->aFields);
		
		return $aTemp[$sField];
	}
}
?>
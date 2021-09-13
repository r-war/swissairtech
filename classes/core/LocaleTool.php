<?php
class LocaleTool
{
	protected $sLang;
	protected $sBasePath;
	protected $aLangString;
	
	public function __construct($sPackage = 'lang') 
	{
		$aTemp = explode('/',$sPackage);
		if(count($aTemp) > 0)
		{
			$sPackage = array_pop($aTemp);
			
			$this->sBasePath = implode('/',$aTemp);
		}
		$this->sLang = HTTP_Session2::get(Attributes::SESSION_LANGUAGE);
		if(!is_file($this->sBasePath . Attributes::LANGUAGES_PATH . $sPackage  . '_' . $this->sLang . '.txt'))
			$this->sLang = Attributes::DEFAULT_LANGUAGE;
			
		$this->aLangString = array();
		$this->readLang($this->sBasePath . Attributes::LANGUAGES_PATH . $sPackage  . '_' . $this->sLang . '.txt');
	}
	
	protected function readLang($sFile)
	{
		$sFilename = $sFile;

		if(is_file($sFilename))
		{
			$rFile = fopen($sFilename,'r');
			
			while($sData = fgets($rFile))
			{
				$aTemp = explode('=',$sData,2);

				if(count($aTemp) == 2)
				{
					$this->aLangString[ltrim(rtrim($aTemp[0]))] = ltrim(rtrim($aTemp[1]));
				}
			}
			
			fclose($rFile);
		}
	}
	
	public function get($_sKey, $_aSubtitutes = array())
	{
		if(strpos($_sKey,' ') > 0)
		{
			$sMessage = $_sKey;
		}
		else 
		{
			if(is_array($_aSubtitutes))
			{
				foreach($_aSubtitutes as $idx=>$sSubtitue)
				{
					$_aSubtitutes[$idx] = htmlentities($sSubtitue);
				}
			}
			$aTemp = explode('-',$_sKey);
    			
			if(count($aTemp) > 1)
			{
				$aSubtitues = array();
				foreach ($aTemp as $idx => $sKey)
				{
					if($idx > 0)
					{
						if(!is_numeric($sKey))
						{
							array_push($aSubtitues,$this->doGetString($sKey));
						}
						else 
						{
							array_push($aSubtitues,$sKey);
						}
					}
				}

				$sMessage = $this->doGetString(
					$aTemp[0],
					$aSubtitues
				);

				if(is_array($_aSubtitutes))
				{
					$sMessage = str_replace('$s','%s',$sMessage);
					
					ob_start();
					call_user_func_array('printf', array_merge((array)$sMessage, $_aSubtitutes));
					$sMessage = ob_get_contents();
					ob_end_clean();
				}
			}
			else 
			{
				$sMessage = $this->doGetString(
					$_sKey,
					$_aSubtitutes
				);
			}
		}
		
		return $sMessage;
	}
	
	protected function doGetString($_sKey,$_aSubtitutes=array())
	{
		if(is_array($_aSubtitutes) && count($_aSubtitutes)>0)
		{
			if(empty($this->aLangString[$_sKey])) return '['.$_sKey.']';
			else
			{
				ob_start();
				call_user_func_array('printf', array_merge((array)nl2br($this->aLangString[$_sKey]), $_aSubtitutes));
				$sResult = ob_get_contents();
				ob_end_clean();
				return $sResult;
			}
		}
		else
		{
//			print '****'.$_sKey.'****<br/>';
//			Common::printArray(array_keys($this->aLangString));
			if(empty($this->aLangString[$_sKey])) return '['.$_sKey.']';
			else return nl2br($this->aLangString[$_sKey]);
		}
	}
	
	public function addPackage($_sPackageName,$bFullName = false)
	{
		$aTemp = explode('/',$_sPackageName);
		if(count($aTemp) > 0)
		{
			$sPackage = array_pop($aTemp);
			
			$this->sBasePath = implode('/',$aTemp);
		}
		
		if($bFullName == false)
		{
			$this->readLang($this->sBasePath . Attributes::LANGUAGES_PATH . $sPackage  . '_' . $this->sLang . '.txt');
		}
		else 
		{
			$this->readLang($this->sBasePath . '/' . $sPackage);
		}
	}
	
	public function getLangPackage()
	{
		return $this->aLangString;
	}
	
	static public function getInstance($sPackage = 'lang')
	{
		static $oLocaleTool;
		if(!$oLocaleTool instanceof LocaleTool )
		{
			$oLocaleTool = new LocaleTool($sPackage);
		}
		return $oLocaleTool;
	}
}
?>
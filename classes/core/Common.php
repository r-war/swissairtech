<?php
class Common
{
	static function copyArray2Object($_aArray=array(), $_oObject)
	{
		if(is_array($_aArray) && is_object($_oObject))
		{
			$aKeys = array_keys($_aArray);
			foreach ($aKeys as $sKey)
			{
				$sTemp = '';
				$aExplodeKeys = explode('_',$sKey);
				if(count($aExplodeKeys) > 0)
				{
					foreach ($aExplodeKeys as $sExplodeKey)
					{
						$sTemp .= ucfirst($sExplodeKey);
					}
				}
				else 
				{
					$sTemp = ucfirst($sKey);
				}
				$sMethod = 'set'.$sTemp;
				if(method_exists($_oObject,$sMethod))
				{
					call_user_func(array($_oObject,$sMethod),$_aArray[$sKey]);
				}
			}
		}
	}
	
	static function copyRunData2Object(RunData $_oRunData, $_oObject)
	{
		Common::copyArray2Object($_oRunData->getData(),$_oObject);
	}

	static function printArray($aArray)
	{
		print '<pre>';
		print_r($aArray);
		print '</pre>';
	}
	
	static function methods($oObject)
	{
		Common::printArray(get_class_methods($oObject));
	}

	static function isNaN( $var )
	{
	    return !ereg ("^[-]?[0-9]+([\.][0-9]+)?$", $var);
	}

	static function getExtension($filename)
	{
		for ($i=0;$i<strlen($filename);$i++)
		{
			if (substr($filename,$i ,1) == ".")
			{
				$string = substr($filename,$i,strlen($filename)-$i);
				return $string;
				break;
			}
		}
	}
	
	static function arrayUnset($aArray,$iIndex) 
	{
		$aResult=array();
		$i=0;
		foreach ($aArray as $item) 
		{
			if (is_array($iIndex) && !in_array($i,$iIndex))
		 	$aResult[]=$item;
			$i++;
		}
		return $aResult;
	}
	
	static function generateInvoiceNo(Store $oStore, $oTransHeader)
	{
		if(is_object($oTransHeader))
		{
			return 'INV/' . $oStore->getCode() . '/' . $oTransHeader->getPrimaryKey();
		}
	}
	
	static function generatePrimaryKey()
	{
		return time();
	}
	
	static function generateMicroTime()
	{
		$utime = preg_match("/^(.*?) (.*?)$/", microtime(), $match);
		$utime = $match[2] + $match[1];
		$utime *=  1000000;
		
		return number_format($utime,null,'','');
	}
	
	static public function parseDot($_dValue)
	{
		$iDec = ConfigurationPeer::getValueByDomainAndKey(Attributes::CONFIG_WEB,'decimal');
		$iDecSep = ConfigurationPeer::getValueByDomainAndKey(Attributes::CONFIG_WEB,'decimal_separator');
		$iThoSep = ConfigurationPeer::getValueByDomainAndKey(Attributes::CONFIG_WEB,'thousand_separator');
		
		if($iDec == null) $iDec = 0;
		if($iDecSep == null) $iDecSep = '.';
		if($iThoSep == null) $iThoSep = ',';
		
		$sResult = number_format($_dValue, $iDec, $iDecSep, $iThoSep);
		return $sResult;
	}
	
	static function leadingZero($value,$digits = 4)
	{
		$result = '';
		for($i=0;$i<$digits-strlen($value);$i++)
		{
			$result.= '0';
		}

		$result.= '' .$value;

		return $result;
	}
	
	static function getDirTree($dir) 
	{
	    $d = dir($dir);
	    while (false !== ($entry = $d->read())) 
	    {
	        if($entry != '.' && $entry != '..' && is_dir($dir.$entry))
	            $arDir[$entry] = Common::getDirTree($dir.$entry.'/');
	    }
	    $d->close();
	    return $arDir;
	}
	
	static function searchDir( 
		$path , $maxdepth = -1 , $mode = "FULL" , $d = 0 )
	{
	   if ( substr ( $path , strlen ( $path ) - 1 ) != '/' ) { $path .= '/' ; }     
	   $dirlist = array () ;
	   if ( $mode != "FILES" ) { $dirlist[] = $path ; }
	   if ( $handle = opendir ( $path ) )
	   {
	       while ( false !== ( $file = readdir ( $handle ) ) )
	       {
	           if ( $file != '.' && $file != '..' )
	           {
	               $file = $path . $file ;
	               if ( $d >= 0 && ($d <= $maxdepth || $maxdepth < 0) )
	               {
		               if ( ! is_dir ( $file ) ) 
		               {
		               		if ( $mode != "DIRS" ) 
		               		{ 
		               			$dirlist[] = $file ; 
		               		} 
		               }
		               else 
		               {
		                   $result = Common::searchDir ( $file . '/' , $maxdepth , $mode , $d + 1 ) ;
		                   $dirlist = array_merge ( $dirlist , $result ) ;
		               }
	               }
	           }
	       }
	       closedir ( $handle ) ;
	   }
	   if ( $d == 0 ) { natcasesort ( $dirlist ) ; }
	   return ( $dirlist ) ;
	}
	
	static function getDuration($iValue)
	{
		$hours=floor($iValue/3600);
		$iValue=$iValue%3600;
		$min=floor($iValue/60);
		$sec=$iValue%60;
		
		return $hours . ':' . $min .':' . $sec;
	}
	
	static function dateTools($sDate,$iDelta)
	{
		$oDateTime = new DateTime($sDate);
		$oDateTime->modify($iDelta.' day');

		return $oDateTime->format(Attributes::DEFAULT_FORMAL_DATETIME_FORMAT);
	}
	
	static function validEmail($sEmail)
	{
		$sRegEx = '/^[a-zA-Z][\w\.\-_]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/';
		
		return preg_match($sRegEx,$sEmail);
	}
	
	static function doLock($sKey)
	{
		if(!self::isLock($sKey))
		{
			$rFile = fopen($sLockFile,'w');
			fclose($rFile);
		}
	}
	
	static function doUnlock($sKey)
	{
		$sLockFile = Attributes::LOCK_PATH . $sKey . '.lock';
		
		if(is_file($sLockFile))
		{
			unlink($sLockFile);
		}
	}
	
	static function isLock($sKey)
	{
		$sLockFile = Attributes::LOCK_PATH . $sKey . '.lock';
		if(is_file($sLockFile))
		{
			$sChangeDate = date(Attributes::DEFAULT_FORMAL_DATE_FORMAT , filemtime($sLockFile));
		}
		$sNowDate = Application::getCustomDate(Attributes::DEFAULT_FORMAL_DATE_FORMAT);
		
		if($sChangeDate<$sNowDate)
		{
			return false;
		}
		
		return true;
	}
	
	static function getCurrentURL()
	{
		$sUrl = $_SERVER['REQUEST_URI'];
//		$sUrl = str_replace('?'.Attributes::MODULE_URL.'=','',$sUrl);
//		$sUrl = str_replace('&'.Attributes::MODULE_URL.'=','',$sUrl);
//		$sUrl = str_replace(Attributes::MODULE_URL.'=','',$sUrl);
		
		if($sUrl[0] == '/')
		{
			$sUrl = substr($sUrl,1);
		}

		return $sUrl;
	}
	
	static function parseSaveURLString($sString)
	{
	    $pattern = array("'é'", "'è'", "'ë'", "'ê'", "'É'", "'È'", "'Ë'", "'Ê'", "'á'", "'à'", "'ä'", "'â'", "'å'", "'Á'", "'À'", "'Ä'", "'Â'", "'Å'", "'ó'", "'ò'", "'ö'", "'ô'", "'Ó'", "'Ò'", "'Ö'", "'Ô'", "'í'", "'ì'", "'ï'", "'î'", "'Í'", "'Ì'", "'Ï'", "'Î'", "'ú'", "'ù'", "'ü'", "'û'", "'Ú'", "'Ù'", "'Ü'", "'Û'", "'ý'", "'ÿ'", "'Ý'", "'ø'", "'Ø'", "'œ'", "'Œ'", "'Æ'", "'ç'", "'Ç'");
	    $replace = array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'y', 'y', 'Y', 'o', 'O', 'a', 'A', 'A', 'c', 'C');
	    $sString = preg_replace($pattern, $replace, $sString);
		$sTemp = strtolower($sString);
		$sTemp = preg_replace('/\W+/',' ',$sTemp);
		$sTemp = preg_replace('/\s+/','-',trim($sTemp));
		
		$sTemp = urlencode($sTemp);
		
		return $sTemp;
	}
	
	static function htmlSafe($sString)
	{
		$sString = htmlentities($sString, ENT_QUOTES, 'UTF-8');
		
		return addslashes($sString);
	}
	
	static function parseCapitalURL($sString)
	{
		$sURL = '';
		$aTemp = explode('.',$sString);
			
		$sString = str_replace(' ','',ucwords(str_replace('-', ' ', array_pop($aTemp))));
		
		if(count($aTemp) > 0)
		{
			$sPackageUrl = $aTemp;
		}
		
		if(!empty($sPackageUrl)) {
			$sURL .= '/'.implode('/',$sPackageUrl);
		}
		
		preg_match_all('/[A-Z][^A-Z]*/', $sString,$aResults);
			
		if(is_array($aResults[0]) && count($aResults[0]) > 0) {
			$sString = strtolower(implode('-',$aResults[0])); 
		}
		
		return substr($sURL.'/'.$sString,1);
	}
}
?>

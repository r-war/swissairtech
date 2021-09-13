<?php
class BaseController
{
	protected $aPageList;
	protected $aSortable;
	protected $aLink;
	
	/**
	 * Get context to be assigned to template
	 *
	 * @return	array The array of context
	 */
	public function getContext()
	{
		return $this->aContext;
	}
	
	/**
	 * Check whether there is a session registered by the name of param
	 *
	 * @param	string $_sSessionName The session name
	 * @return	mixed The session value
	 */
	protected function isSessionRegistered($_sSessionName)
	{
		return (isset($_SESSION[$_sSessionName]));
	}
	
	/**
	 * Set a value in session
	 *
	 * @param 	string $_sSessionName The session name
	 * @param 	mixed $_oSessionValue The session value
	 */
	protected function setSession($_sSessionName,$_oSessionValue)
	{
		HTTP_Session2::set($_sSessionName,$_oSessionValue);
	}
	
	/**
	 * Get session value
	 *
	 * @param 	string $_sSessionName The session name
	 * @return 	mixed The session value
	 */
	protected function getSession($_sSessionName)
	{
		if($this->isSessionRegistered($_sSessionName)) return HTTP_Session2::get($_sSessionName);
		return null;
	}
	
	/**
	 * Unset session value 
	 *
	 * @param 	string $_sSessionName The session name
	 * @return	boolean True if the session has ben successfully unregistered
	 */
	protected function unsetSession($_sSessionName)
	{
		HTTP_Session2::set($_sSessionName,null);
		HTTP_Session2::unregister($_sSessionName);
		unset($_sSessionName);
		
		return true;
	}
	
	/**
	 * Unset session value 
	 *
	 * @param 	string $_sSessionName The session name
	 * @return	boolean True if the session has ben successfully unregistered
	 */
	protected function destroySession()
	{
		HTTP_Session2::destroy();
		HTTP_Session2::start('SessionID', uniqid(rand(0,9)));
//		session_regenerate_id(true);
		return true;
	}
	
	/**
	 * Get the string value from language package
	 *
	 * @param 	string $_sKey The key to the string
	 * @param 	string $_aSubtitutes The array of subtitues string
	 * @return 	string The value of the key
	 */
	function getString($_sKey,$_aSubtitutes = array())
	{
		return $this->oLoc->get($_sKey,$_aSubtitutes);
	}
	
	public function error($_sMessageKey,$_aSubtitutes = array())
	{
		$this->errorMessage($this->getModule(),$_sMessageKey,$_aSubtitutes);
	}
	
	public function info($_sMessageKey,$_aSubtitutes = array())
	{
		$this->infoMessage($this->getModule(),$_sMessageKey,$_aSubtitutes);
	}
	
	public function errorInline($sId, $sMessage)
	{
		$sMessage = $this->getString($sMessage);
		if(!$this->isSessionRegistered('error_inline')) $this->setSession('error_inline',array());
		$aErrorMessage = $this->getSession('error_inline');
		$aErrorMessage[$sId] = $sMessage;
		$this->setSession('error_inline',$aErrorMessage);
	}

	/**
	 * Error handler to be override
	 *
	 * @param 	Exception $_oEx The Exception object to be handled
	 */
	public function errorHandler(Exception $_oEx,$bErrorPage = false)
	{
		$sMessage = '';
		$aData = $_REQUEST;
		
		if(is_array($aData))
		{
			$sMessage .= $_oEx->getMessage()."\n".'==================='."\n";
			$sMessage .= 'Server Addr: ' . $_SERVER['SERVER_ADDR'] . "\n";
			$sMessage .= 'Server Host: ' . $_SERVER['HTTP_HOST'] . "\n";
			$sMessage .= 'Remote Addr: ' . $_SERVER['REMOTE_ADDR'] . "\n";
			$sMessage .= 'Browser: ' . $_SERVER['HTTP_USER_AGENT'] . "\n";
			
			foreach ($aData as $sKey => $sValue)
			{
				if(eregi('password',$sKey) == true)
				{
					$sValue = '******';
				}
				
				$sMessage .= $sKey .': '. $sValue ."\n";
			}
			$sMessage .= '==================='."\n";
		}
		
		$sMessage .= $_oEx->getTraceAsString()."\n"."******************************************************";

		$this->oLog->err($sMessage);
		
//		$aFrom = array($this->aConfig['email_from'],$this->aConfig['web_title']);
//		$this->sendMail(
//			$aFrom,
//			array(array(Attributes::ERROR_EMAIL)),
//			$_oEx->getMessage(),
//			$sMessage
//		);

		if($bErrorPage == true)
		{
			$this->aContext['oException'] = $_oEx;
			$this->aContext['sExceptionMessage'] = $_oEx->getMessage();
			$this->aContext['sExceptionStackTrace'] = $_oEx->getTraceAsString();
			$this->oSmarty->assign($this->aContext);
			$this->oSmarty->display('core/error_page.tpl');
		}
	}
	
	/**
	 * Validate the OM Object
	 *
	 * @param 	object $oObj The object to be validated
	 * @return 	boolean True if the object attributes is valid
	 */
	public function doValidate($oObj)
	{
		if($oObj->validate())
		{
			return true;
		}
		else
		{
    		foreach($oObj->getValidationFailures() as $oFailure)
    		{
				$aColumn = explode('.', $oFailure->getColumn());
				$sColumn = strtolower($aColumn[1]);
				
				//exception
				if(in_array($aColumn[0],array('product','category')) && $sColumn == 'code') $sColumn = 'name';
				
		        $this->errorInline($sColumn, $oFailure->getMessage());
				$this->error($oFailure->getMessage());
			}
			return false;
		}
	}
	
	/**
	 * Get a (singleton) PropelPDO connection object
	 *
	 * @param 	string $_sConString The connection string as a key to the connection
	 * @return	PropelPDO The singleton object of PropelPDO
	 */
	protected function getCon($_sConString = null)
	{
		return Propel::getConnection($_sConString);
	}
	
	
	/**
	 * The actual handler to insert each error message to session
	 *
	 * @param	string $_sSource The message group key
	 * @param	string $_sKey The message key (Related to the key from lang_xx.php)
	 * @param 	array $_aSubtitutes The list of subtitute text to be assigned to the message
	 */
	protected function errorMessage($_sSource,$_sKey,$_aSubtitutes = array())
	{
		$sMessage = $this->getString($_sKey,$_aSubtitutes);
		if(!$this->isSessionRegistered('error_messages')) 
		{
			$this->setSession('error_messages',array());
		}
		$aErrorMessage = $this->getSession('error_messages');
		if(key_exists($_sSource,$aErrorMessage) == false || is_array($aErrorMessage[$_sSource]) == false)
		{
			$aErrorMessage[$_sSource] = array();
		}
		array_push($aErrorMessage[$_sSource],$sMessage);
		$this->setSession('error_messages',$aErrorMessage);
	}
	
	/**
	 * The actual handler to insert each info message to session
	 *
	 * @param	string $_sSource The message group key
	 * @param	string $_sKey The message key (Related to the key from lang_xx.php)
	 * @param 	array $_aSubtitutes The list of subtitute text to be assigned to the message
	 */
	protected function infoMessage($_sSource,$_sKey,$_aSubtitutes = array())
	{
		$sMessage = $this->getString($_sKey,$_aSubtitutes);
		if(!$this->isSessionRegistered('info_messages')) 
		{
			$this->setSession('info_messages',array());
		}
		$aInfoMessage = $this->getSession('info_messages');
		if(key_exists($_sSource,$aInfoMessage) == false || is_array($aInfoMessage[$_sSource]) == false)
		{
			$aInfoMessage[$_sSource] = array();
		}
		array_push($aInfoMessage[$_sSource],$sMessage);
		$this->setSession('info_messages',$aInfoMessage);
	}
	
	/**
	 * Assign info or error messages from session into template context
	 *
	 */
	public function showFeedback()
	{
		$aErrorMessage = $this->getSession('error_messages');
		$aInfoMessage = $this->getSession('info_messages');
		if(is_array($aErrorMessage))
		{
			foreach ($aErrorMessage as $sSource => $sMessage)
			{
				$this->aContext['error_messages'][$sSource] = $sMessage;
			}
		}
		$this->setSession('error_messages', array());
		if(is_array($aInfoMessage))
		{
			foreach ($aInfoMessage as $sSource => $sMessage)
			{
				$this->aContext['info_messages'][$sSource] = $sMessage;
			}
		}
		$this->setSession('info_messages', array());
		
		$aErrorInline = $this->getSession('error_inline');
		$this->aContext['error_inline'] = $aErrorInline;
		$this->setSession('error_inline', array());
	}
	
	/**
	 * Checking whether there is any error message connected to this module
	 *
	 * @return	boolean True if there is no error message
	 */
	protected function noError($_sSource=null)
	{
		$this->aContext['bShowForm'] = true;
		if($this->isSessionRegistered('error_messages'))
		{
			$aErrorMessage = $this->getSession('error_messages');
			if($_sSource == null)
			{
				if(key_exists($this->getModule(),$aErrorMessage) && count($aErrorMessage[$this->getModule()]) > 0) return false;
			}
			else 
			{
				if(key_exists($_sSource,$aErrorMessage) && count($aErrorMessage[$_sSource]) > 0) return false;
			}
		}
		if($this->isSessionRegistered('error_inline'))
		{
			$aErrorMessage = $this->getSession('error_inline');
			if(count($aErrorMessage) > 0) return false;
		}
		
		$this->aContext['bShowForm'] = false;
		return true;
	}
	
	/**
	 * Checking whether there is any info message connected to this module
	 *
	 * @return	boolean True if there is no info message
	 */
	protected function noInfo()
	{
		if($this->isSessionRegistered('info_messages'))
		{
			$aErrorMessage = $this->getSession('info_messages');
			if(count($aErrorMessage[$this->getModule()]) > 0) return false;
		}
		
		return true;
	}
	
	/**
	 * Used for loging purpose
	 *
	 * @param string  $sMessage
	 * @param integer $iLevel
	 */
	public function log($sMessage, $iLevel = PEAR_LOG_INFO)
	{
		$this->oLog->log($sMessage . "\n", $iLevel);
	}
	
	protected function setLogInstance()
	{
		$this->oLog = Log::singleton(
			'file', 
			Attributes::LOG_PATH . $this->sBasePath . '/'.str_replace('.','/',$this->getPackage()) . '/' . get_class($this) . '/' . Application::getCustomDate('d-m-Y') . '.log', 
			get_class($this), 
			array(), 
			Attributes::LOG_LEVEL
		);
	}
	
	/**
	 * Process the uploaded file
	 *
	 * @param 	string $_sField The form field name for the upload
	 * @param 	string $_sTarget The target path (The file will be saved to this target)
	 * @param 	array $_sFileTypes The list of allowed file types (ex: doc, pdf, etc..)
	 * @param 	boolean $_bEmpty If false, it will add an error message if there is no file uploaded
	 * @param 	string $_sName The new filename to be used when the file has been uploaded to server
	 * @param 	string $_sPrefix The prefix to the filename
	 * @param 	array $_aCallback The callback that will be called just before the file will be uploaded to the server (Index 0: object Object, Index 1: string method_name)
	 * @return 	mixed False if the upload failed. The filename if the upload success.
	 */
	protected function processUpload($_sField,$_sTarget,$_sFileTypes=array(),$_sName=null,
		$_bEmpty=false,$_bUnique=false,$_sPrefix=null,$_aCallback = array(),$aMaxSize = array(1600,1200,false))
	{
		$oFile = $this->oUpload->getFiles($_sField);
		
		// create directory if not exists
		if(!is_dir($_sTarget))
		{
			$aTarget = explode('/', $_sTarget);
			$sDir = '';
			foreach ($aTarget as $key => $value) {
				if(trim($value) != '')
				{
					$sDir .= $value .'/';
					if(!is_dir($sDir)) mkdir($sDir,'0755');
				}
			}
		}	
		
		if(count($_sFileTypes)>0)
		{
			$oFile->setValidExtensions($_sFileTypes,'accept');	
		}
		
		$oFile->setName('safe',$_sPrefix);
		
		if($_bUnique)
		{
			$ctr = 0;
			$sFilename = substr($oFile->getProp('name'),0,strrpos($oFile->getProp('name'),'.'));
			$sTempFilename = $_sTarget.$sFilename.'.'.$oFile->getProp('ext');
			if(file_exists($sTempFilename) && is_file($sTempFilename))
			{
				while(file_exists($sTempFilename) && is_file($sTempFilename))
				{
					$ctr++;
					$sTempFilename = $_sTarget.$sFilename.'_'.$ctr.'.'.$oFile->getProp('ext');
				}
				$oFile->upload['name'] =  $sFilename.'_'.$ctr.'.'.$oFile->getProp('ext');
			}
		}
		if($oFile->isError())
		{
			$this->errorInline($_sField,strtolower($oFile->getProp('error')));
		}
		else if(!$_bEmpty && $oFile->isMissing())
		{
			$this->errorInline($_sField,'required-file');
		}
		else if(!$oFile->isMissing() && !$oFile->_evalValidExtensions())
		{
			$this->errorInline($_sField,'not_allowed-file_type',array($oFile->getProp('ext')));
		}
		else if ($oFile->isValid())
		{
			if($_sName!=null)
			{
				$oFile->upload['name'] = $_sName.'.'.$oFile->getProp('ext');
			}
			
			$oFile->upload['name'] = strtolower($oFile->upload['name']);

			if(is_array($_aCallback) && key_exists(0,$_aCallback) && is_object($_aCallback[0]))
			{
				call_user_func(array($_aCallback[0],$_aCallback[1]));
			}
		    $oMoved = $oFile->moveTo($_sTarget);
			
			if( in_array($oFile->getProp('ext'), array('jpg','jpeg','png','gif','bmp')) && is_array($aMaxSize) && ( $aMaxSize[0] != '' || $aMaxSize[1] != '' ))
			{
				$bGenerate = false;
				$sFile = $_sTarget.$oFile->getProp('name');
				if(is_file($sFile))
				{
					$aPictureDim = getimagesize($sFile);
					$iWidth = $aPictureDim[0];
					$iHeight = $aPictureDim[1];
					
					if($aMaxSize[2])
					{
						$bGenerate = true;
						if($aMaxSize[0] != '' && $aMaxSize[1] != '')
						{
							if($iWidth == $aMaxSize[0] && $iHeight == $aMaxSize[1]) $bGenerate = false;
							
							$iWidth = $aMaxSize[0];
							$iHeight = $aMaxSize[1];
						}
						else if($aMaxSize[0] != '' && $aMaxSize[1] == '')
						{
							if($iWidth == $aMaxSize[0]) $bGenerate = false;

							$iWidth = $aMaxSize[0];
							$iHeight = $aPictureDim[1]/($aPictureDim[0]/$iWidth);
						}
						else if($aMaxSize[0] == '' && $aMaxSize[1] != '')
						{
							if($iHeight == $aMaxSize[1]) $bGenerate = false;
							
							$iHeight = $aMaxSize[1];
							$iWidth = $aPictureDim[0]/($aPictureDim[1]/$iHeight);
						}
					}
					else
					{
						if($iWidth > $aMaxSize[0] || $iHeight > $aMaxSize[1])
						{
							$bGenerate = true;
							if($aMaxSize[0] != '' && $aMaxSize[1] != '')
							{
								if($aPictureDim[0]/$aPictureDim[1] >= $aMaxSize[0]/$aMaxSize[1])
								{
									$iWidth = ($aPictureDim[0] > $aMaxSize[0] ? $aMaxSize[0] : $aPictureDim[0]);
									$iHeight = $aPictureDim[1]/($aPictureDim[0]/$iWidth);
								}
								else 
								{
									$iHeight = ($aPictureDim[1] > $aMaxSize[1] ? $aMaxSize[1] : $aPictureDim[1]);
									$iWidth = $aPictureDim[0]/($aPictureDim[1]/$iHeight);
								}
							}
							else if($aMaxSize[0] != '' && $aMaxSize[1] == '')
							{
								$iWidth = ($aPictureDim[0] > $aMaxSize[0] ? $aMaxSize[0] : $aPictureDim[0]);
								$iHeight = $aPictureDim[1]/($aPictureDim[0]/$iWidth);
							}
							else if($aMaxSize[0] == '' && $aMaxSize[1] != '')
							{
								$iHeight = ($aPictureDim[1] > $aMaxSize[1] ? $aMaxSize[1] : $aPictureDim[1]);
								$iWidth = $aPictureDim[0]/($aPictureDim[1]/$iHeight);
							}
						}
					}
					
					$aDimension = array($iWidth,$iHeight);
					if($bGenerate)
					{
						ImageTool::generateThumbnail(
							$sFile,
							$sFile,
							$aDimension,
							null,
							$aMaxSize[2]
						);
					}
				}
			}
			

		    if (!PEAR::isError($oMoved))
		    {
		        $this->info(
		        	'succeed-file_upload-uploaded',
		        	array(
		        		$oFile->getProp('name'),
		        		round($oFile->getProp('size')/1024,2)
		        	)
		        );
		        return $oFile->getProp('name');
		        
		    }
		}
		
		return null;
	}
	
	/**
	 * Add additional links to be included in getPage() method result
	 *
	 * @param string $_sLink The link (ex: param1=value1)
	 */
	public function addLink($_sLink)
	{
		array_push($this->aLink,$_sLink);
	}
	
	protected function getPageList($_sSource=null)
	{
		return $this->oData->get($_sSource.'_page');
	}
	
	protected function getSortable($_sSource=null)
	{
		return $this->aSortable[$_sSource.'_sort'];
	}
	
	/**
	 * Register a page list handler
	 *
	 * @param 	string $_sSource The page list key handler
	 * @param 	PropelPager $_oPager The pager object
	 */
	protected function regPageList(PropelPager $_oPager = null,$_sSource=null)
	{
		$sKey = $_sSource.'_page';
		
		if($_oPager instanceof PropelPager &&
			!in_array($sKey,$this->aPageList)
		)
		{
			array_push($this->aPageList,$sKey);
			$_oPager->setPageKey($sKey);
			$this->addLink($sKey . '=' . $this->getPageList($_sSource));
			$this->aContext[$_sSource.'_pager'] = $_oPager;
		}
	}
	
	protected function regSortable($aFields,$_sSource=null)
	{
		$sKey = $_sSource.'_sort';
		
		if(!in_array($sKey,array_keys($this->aSortable)))
		{
			$oSortable = new Sortable($aFields,$this->oData->get($this->sSource.'_sort'),$_sSource);
			$this->aSortable[$sKey] = $oSortable;
			$this->addLink($sKey . '=' . $this->oData->get($_sSource.'_sort'));
			$this->aContext[$_sSource.'_sortable'] = $oSortable;
		}
	}
	
	/**
	 * Get current page URL
	 *
	 * @param 	string $_sModuleKey The module key
	 * @return 	string The base page URL
	 */
	public function getCurrentPage($sNewUrl = null)
	{
		$sURL = Common::getCurrentURL();
		
		if($sNewUrl != null)
		{
			$aTemp = explode('&',$sNewUrl);
			foreach($aTemp as $sTemp)
			{
				$aTemp2 = explode('=',$sTemp);
				$sValue = null;
				if(key_exists(1,$aTemp2) == true)
				{
					$sValue = $aTemp2[1];
				}
				
				if($aTemp2[0] != null)
				{
					preg_match_all('([\?|&]'.$aTemp2[0].'=[^&]*)',$sURL,$aDelete);
					
					if(is_array($aDelete[0]))
					{
						foreach ($aDelete as $sDelete) {
							$sURL = str_replace($sDelete,null,$sURL);
						}
					}
					
					if($sValue != null)
					{
						$sURL .= '&'.$aTemp2[0].'='.$sValue;
					}
				}
			}
		}
		
		if(strlen($sURL) > 0 && substr($sURL,0,1) == '&')
		{
			$sURL = '?'.substr($sURL,1);
		}
		
		return '/'.$sURL;
	}
	
	public function parseNewURL($sPageLink,$newLink = null)
	{
		if($newLink != null)
		{
			if(eregi('(&|\?|=)',$newLink) == true)
			{
				$aTemp = explode('&',$newLink);
	
				foreach ($aTemp as $idx => $sLink)
				{
					if($sLink != '')
					{
						$aLink = explode('=',$sLink);
	
						if(count($aLink) == 1)
						{
							$sErase = $aLink[0].'='.$this->oData->get($aLink[0]);
								
							$sPageLink = str_replace('&'.$sErase,'',$sPageLink);
							$sPageLink = str_replace('?'.$sErase.'&','?',$sPageLink);
							$sPageLink = str_replace('?'.$sErase,'',$sPageLink);
						}
						else if(count($aLink) == 2)
						{
							$sErase = $aLink[0].'='.$this->oData->get($aLink[0]);
								
							$sPageLink = str_replace('&'.$sErase,'',$sPageLink);
							$sPageLink = str_replace('?'.$sErase.'&','?',$sPageLink);
							$sPageLink = str_replace('?'.$sErase,'',$sPageLink);
								
							if(trim($aLink[1]) != '')
							{
								if(eregi('\?',$sPageLink) == false)
								{
									$sPageLink .= '?';
								}
								else
								{
									$sPageLink .= '&';
								}
	
								$sPageLink .= $sLink;
							}
						}
					}
				}
			}
			else
			{
				$sPageLink .= $newLink;
			}
		}
	
		return $sPageLink;
	}
	
	public function finalParseURL($sUrl)
	{
		if(strlen($sUrl) > 0 && substr($sUrl,0,1) == '&')
		{
			$sUrl = '?'.substr($sUrl,1);
		}
		
		return $sUrl;
	}
	
	protected function getExceptionMessage(Exception $oEx)
	{
		if($oEx instanceof PropelException)
		{
			return $oEx->getCause()->getMessage();
		}
		else
		{
			return $oEx->getMessage();
		}
	}
}
?>
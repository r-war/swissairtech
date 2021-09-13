<?php
include_once(Attributes::CORE_CLASS_PATH.'Upload.php');

/**
 * The abstract module to be extended for each additional module
 */
abstract class AbstractModule extends BaseController 
{
	protected $sPackage;
	protected $sTemplateLayout;
	protected $sTemplateName;
	protected $sBasePath;
	
	protected $oApp;
	protected $oLoc;
	protected $oData;
	protected $oLog;
	protected $oUpload;
	protected $oParam;
	protected $oSmarty;
	protected $oMailer;
	protected $oModuleConfig;
	protected $oCon;
	
	protected $aContext;
	protected $aConfig;
	
	public $sDomain;
	
	
	/**
	 * Constructor, initialize attributes and objects 
	 *
	 * @param Parameter $_oParam The parameter used to initialize attributes and objects
	 */
	public function __construct(Parameter $_oParam, &$_aContext) 
	{
		$this->sPackage = $_oParam->get('package');
		$this->sTemplateLayout = 'layout/default.tpl';
		$this->sBasePath = $_oParam->get('basePath');
		$this->oApp = $_oParam->get('app');
		$this->oData = $_oParam->get('runData');
		$this->oLoc = $_oParam->get('localeTool');
		$this->oSmarty = $_oParam->get('smarty');
		$this->oUpload = new Upload();
		$this->oParam = $_oParam;
		$this->oCon = $this->getCon();
		$this->aPageList = array();
		$this->aSortable = array();
		$this->aLink = array();
		$this->aContext = &$_aContext;
		$this->setLogInstance();
		$this->oMailer = new Mailer($this->oLog);
		$this->aConfig = $_oParam->get('configuration');
	}
	
	public function initModule()
	{
		$this->aContext['aConfig'] = $this->aConfig;
		$this->aContext['oTool'] = new Common();

		$this->sDomain = $this->oApp->sDomain;
		$this->aContext['sDomain'] = $this->sDomain;
	}
	
	/**
	 * Can be override to hide the module from menu
	 *
	 * @return	boolean True if the module showed in the menu
	 */
	public function isShowed()
	{
		return true;
	}
	
	/**
	 * Can be override to define whether the module using a template or not
	 *
	 * @return	boolean True if the module using a template
	 */
	public function useTemplate()
	{
		return true;
	}
	
	/**
	 * Can be override to use yourown permission rule
	 *
	 * @return	boolean True if the module can be accessed
	 */
	public function isAuthorized()
	{
		return false;
	}
	
	/**
	 * Get template filename
	 *
	 * @return	string The template filename
	 */
	public function getTemplateName()
	{
		if($this->useTemplate())
		{
			if(!$this->oData->isExists('ajax'))
			{
				$this->sTemplateName = str_replace('.','/',$this->sPackage);
				if(!empty($this->sTemplateName)) $this->sTemplateName.='/';
				return $this->sTemplateName.get_class($this).'.tpl';
			}
			else 
			{
				$this->sTemplateName = str_replace('.','/',$this->sPackage);
				if(!empty($this->sTemplateName)) $this->sTemplateName.='/';
				return $this->sTemplateName.'ajax/'.get_class($this).'.tpl';
			}
			
			return $this->sTemplateName;
		}
		
		return null;
	}
	
	/**
	 * Get the Template Layout file
	 *
	 * @return string The Template Layout file
	 */
	public function getTemplateLayout()
	{
		return $this->sTemplateLayout;
	}
	
	/**
	 * Set the Template Layout file
	 *
	 * @param string $_sTemplateLayout The Template Layout file
	 */
	public function setTemplateLayout($_sTemplateLayout)
	{
		$this->sTemplateLayout = $_sTemplateLayout;
	}
	
	/**
	 * Determine whether the module need a redirection
	 *
	 * @return boolean
	 */
	public function isRedirect()
	{
		return false;
	}
	
	/**
	 * Return module key string for redirection
	 *
	 * @return string
	 */
	public function getRedirectModule()
	{
		return array(
			'',
			'Default'
		);
	}
	
	/**
	 * Get the list of interceptor based on their order to be executed
	 *
	 */
	public function getInterceptorList()
	{
		return array();
	}
	
	public function getModuleName()
	{
		return $this->oLoc->get($this->getName());
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
	 * Get module key (unique) that indentify this module
	 *
	 * @return 	string The module key
	 */
	public function getModule()
	{
		if(!empty($this->sPackage))
		{
			return $this->sPackage.'.'.str_replace('Module','',get_class($this));
		}

		return str_replace('Module','',get_class($this));
	}
	
	/**
	 * Get module name
	 *
	 * @return	string The module name
	 */
	public function getName()
	{
		return get_class($this);
	}
	
	/**
	 * Get module package
	 *
	 * @return	string The module package
	 */
	public function getPackage()
	{
		return $this->sPackage;
	}

	/**
	 * Get a base page URL
	 *
	 * @param 	string $_sModuleKey The module key
	 * @return 	string The base page URL
	 */
	public function getBasePage($_sModuleKey = '', $newLink = null, $sPath = null)
	{
		if(!$sPath) $sPath = $this->oApp->sThePath;
		if(Attributes::REWRITE)
		{
			$sLink = ($sPath != 'www' ? '/'.$sPath : '').$this->parsePage($_sModuleKey,'&',$newLink);
			if(preg_match('/^\//', $newLink)) $sLink .= $newLink;
			
			return $sLink;
		}
		else 
		{
			$sURL = '/index.php';
		
			if(!empty($_sModuleKey))
			{
				$sMod = $this->parseModuleKey($_sModuleKey);
				$sMod = str_replace('/', '', $sMod);
				$sURL .= '?x='.$sMod;
			}
			
			if($newLink)
			{
				if(!empty($_sModuleKey))
					$sURL .= '&';
				else
					$sURL .= '?';
				
				$sURL .= $newLink;
			}
				
			
			return $sURL. ($sPath != 'www' ? '&p='.$sPath : '');
		}
			
	}
	
	/**
	 * Get a complete page URL
	 *
	 * @param 	string $_sModuleKey The module key
	 * @return 	string The page URL plus required parameters (ex: page parameter, etc)
	 */
// 	public function getPage($_sModuleKey = null,$newLink = null)
// 	{
// 		$sPageLink = '';

// 		foreach ($this->aLink as $sLink)
// 		{
// 			$sPageLink .= '&'.$sLink;
// 		}

// 		return $this->parsePage($_sModuleKey,$sPageLink,$newLink);
// 	}
	
	public function getPage($_sModuleKey = null,$newLink = null,$bPageVersion = false)
	{
		$sPath = $this->oApp->sThePath;
		
		if(Attributes::REWRITE)
		{
			$sPageLink = '';
		
			foreach ($this->aLink as $sLink)
			{
				if($sPageLink == '')
				{
					$sPageLink .= '?';
				}
				else
				{
					$sPageLink .= '&';
				}
				$sPageLink .= $sLink;
			}
		
			$sPageLink = $this->finalParseURL($this->parseNewURL($sPageLink,$newLink));
		
			if(!empty($_sModuleKey))
			{
				$sURL = $this->parseModuleKey($_sModuleKey) . '/' . $sPageLink;
			}
			else
			{
				$sURL = '/' . $sPageLink;
			}
			
			if($sPath != 'www')
				$sURL = '/' . $sPath . $sURL;
		}
		else
		{
			$sURL = '/index.php';
			
			if(!empty($_sModuleKey))
			{
				$sMod = $this->parseModuleKey($_sModuleKey);
				$sMod = str_replace('/', '', $sMod);
				$sURL .= '?x='.$sMod;
			}
			
			foreach ($this->aLink as $sLink)
			{
				$sURL .= '&';
				$sURL .= $sLink;
			}
			
			if($newLink)
			{
				if(!empty($_sModuleKey))
					$sURL .= '&';
				else
					$sURL .= '?';
					
				$sURL .= $newLink;
			}
			
			$sURL .= ($sPath != 'www' ? '&p='.$sPath : '');
		}
		
		if($bPageVersion == true)
		{
			$sURL = $this->wrapPageVersion($sURL);
		}
	
		return $sURL;
	}
	
	public function parsePage($sModuleKey, $sPageParam, $sNewParam)
	{
		if($sPageParam != null)
		{
//			if(eregi('(&|\?|=)',$sNewParam) == true)
//			{
				$aTemp = explode('&',$sNewParam);
				
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
						preg_match_all('([\?|&]'.$aTemp2[0].'=[^&]*)',$sPageParam,$aDelete);
//Common::printArray($aDelete);
						if(is_array($aDelete[0]))
						{
							foreach ($aDelete as $sDelete) {
								$sPageParam = str_replace($sDelete,null,$sPageParam);
							}
						}
						
						if($sValue != null)
						{
							$sPageParam .= '&'.$aTemp2[0].'='.$sValue;
						}
					}
				}
//			}
//			else 
//			{
//				$sPageParam = $sNewParam;
//			}

			if(strlen($sPageParam) > 1)
			{
				if(substr($sPageParam,0,1) == '&')
				{
					$sPageParam = '?'.substr($sPageParam,1);
				}
			}
			else
			{
				$sPageParam = null;
			}
	
			if(!empty($sModuleKey)) 
			{
				$sURL = $this->parseModuleKey($sModuleKey);
				if($sPageParam)
					$sURL .= $sPageParam;
//					$sURL .= '/' . $sPageParam;
			}
			else
			{
				$sURL = '/';
			}
			
			return $sURL;
		}
	}
	
	/**
	 * Get default date format
	 *
	 * @return string The default date format
	 */
	public function getDefaultDateFormat()
	{
		return Application::sDEFAULT_DATE_FORMAT;
	}
	
	/**
	 * To be override. This method will be called after the template has been rendered
	 *
	 */
	public function finalExecution()
	{
		
	}
	
	/**
	 * Method to start the process
	 *
	 */
	public function doProcess()
	{
		$this->init();
		
		$this->assignAttributes();
		
		if($this->oData->isExists('ajax'))
		{
			$this->setTemplateLayout('layout/blank.tpl');
			$this->aContext['sAjax'] = $this->oData->get('ajax');
			$this->ajaxHandler($this->oData->get('ajax'));
		}
		else 
		{
			$this->doBuildTemplate();
		}
	}
	
	public function assignAttributes()
	{
		$aData = $this->oData->getData();
		$aKeys = array_keys($aData);
		$aValue = array();
		
		foreach ($aKeys as $idx => $sKey)
		{
			$aTemp = explode('-',$sKey);
			
			if(count($aTemp) == 2)
			{
				if(key_exists($aTemp[0],$aValue) == false || is_array($aValue[$aTemp[0]]) == false)
				{
					$aValue[$aTemp[0]] = array();
				}
				
				$aValue[$aTemp[0]][$aTemp[1]] = $this->oData->get($sKey);
			}
		}
		
		foreach ($aValue as $sObj => $aVal)
		{
			if(property_exists($this,$sObj) == true)
			{
				eval('Common::copyArray2Object($aVal,$this->'.$sObj.');');
			}
		}
	}

	public function sendMail($aFrom, $aTo, $sSubject, $sTemplateName, $aContext, $sContentType = 'text/plain', $aAttach = array(), $aReplyTo = null, $aSmtp = null, $aBCC = null)
	{
		$sTemplatePath = str_replace('.','/',$this->sPackage);
		if(!empty($sTemplatePath)) $sTemplatePath.='/';
		
		$aContext['oMod'] = $this;
		$this->oSmarty->clearAllCache();
		$this->oSmarty->assign(array_merge($this->aContext,$aContext));
		
		$this->oMailer->ClearAllRecipients();
		$this->oMailer->ClearAttachments();
		$this->oMailer->ClearReplyTos();
		$this->oMailer->ContentType = $sContentType;
		if(is_array($aSmtp) && $aSmtp['username'] != '')
			$this->oMailer->Sender = $aSmtp['username'];
		$this->oMailer->From = $aFrom[0];
		$this->oMailer->FromName = $aFrom[1];
		$this->oMailer->Subject = $sSubject;
		
// 		$this->oSmarty->force_compile = true;
		$this->oMailer->Body = $this->oSmarty->fetch($sTemplatePath . 'mail/' . $sTemplateName, null, null, null, false);
// 		$this->oSmarty->force_compile = false;
		
		if(is_array($aSmtp) && $aSmtp['host'] != '' && $aSmtp['username'] != '' && $aSmtp['password'] != '' )
		{
			$this->oMailer->IsSMTP();
			$this->oMailer->SMTPAuth = true;
			$this->oMailer->Host = $aSmtp['host'];
			$this->oMailer->Username = $aSmtp['username'];
			$this->oMailer->Password = $aSmtp['password'];
			$this->oMailer->Sender = $aSmtp['username'];
			if($aSmtp['smtp_port'])$this->oMailer->Port = $aSmtp['smtp_port'];
			if($aSmtp['isgmail']){
				$this->oMailer->SMTPSecure = 'ssl';
				$this->oMailer->Port = 465;
			}
		}
		
		foreach ($aAttach as $sRealFile => $sNewName)
		{
			if(file_exists($sRealFile))
			{
				$this->oMailer->AddAttachment($sRealFile,$sNewName);
			}
		}
		
		if(is_array($aReplyTo))
		{
			$this->oMailer->AddReplyTo($aReplyTo[0],$aReplyTo[1]);
		}

		foreach ($aTo as $aTemp)
		{
			$this->oMailer->ClearAllRecipients();
			if(is_array($aBCC))
			{
				foreach ($aBCC as $aBCCData)
				{
					$this->oMailer->AddBCC($aBCCData[0],$aBCCData[1]);
				}
			}
			$this->oMailer->AddAddress($aTemp[0],$aTemp[1]);
			$bResult = $this->oMailer->Send();
			if($bResult == false)
			{
				break;
			}
		}

		$this->oSmarty->clearAllCache();
		
		return $bResult;
	}
	
	/**
	 * This method always called when the module executed
	 *
	 */
	public function init()
	{
		
	}
	
	/**
	 * Ajax handler
	 *
	 * @param string $sAjax Contains the key to identify the content
	 */
	public function ajaxHandler($sAjax)
	{
		
	}
	
	public function getSortModuleKey()
	{
		if($this->sortAfter() != '')
		{
			if($this->getPackage() != '')
			{
				return $this->getPackage().'.'.$this->sortAfter();
			}
			else 
			{
				return $this->sortAfter();
			}
		}
		
		return '';
	}
	
	public function sortAfter()
	{
		return '';
	}
	
	public function getConfig($sKey)
	{
		if(key_exists($sKey,$this->aConfig) == true)
		{
			return $this->aConfig[$sKey];
		}
	}
	
	protected function parseModuleKey($sModuleKey)
	{
		return '/'.Common::parseCapitalURL($sModuleKey);
	}
	
	public function renderPDF($sTemplateName, $aContext, $sOutputFile, $iOutputType = 1,$sPaperSize = 'a4', $sOrientation = 'portrait')
	{
		require_once(BASE_PATH . Attributes::CLASS_PATH . "dompdf/dompdf_config.inc.php");
	
		$this->oSmarty->clearAllCache();
		$this->oSmarty->assign(array_merge($this->aContext,$aContext));
	
		$sHTML = $this->oSmarty->fetch($sTemplateName, null, null, null, false);
		$dompdf = new DOMPDF();
		$dompdf->load_html($sHTML);
		$dompdf->set_paper($sPaperSize,$sOrientation);
		$dompdf->render();
	
		switch ($iOutputType)
		{
			case 2:
				$dompdf->stream($sOutputFile, array('Attachment' => 0));
				return true;
				break;
			case 3:
				$sOutput = $dompdf->output();
				$rFile = fopen($sOutputFile,"w");
	
				fwrite($rFile,$sOutput);
	
				fclose($rFile);
				return true;
				break;
			default:
				$dompdf->stream($sOutputFile, array('Attachment' => 1));
				return true;
				break;
		}
	
		return false;
	}
	/**
	 * Abstract method each module must have
	 *
	 */
	abstract public function doBuildTemplate();
}
?>
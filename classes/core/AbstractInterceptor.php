<?php
/**
 * The abstract interceptor to be extended for each additional interceptor
 */
abstract class AbstractInterceptor extends BaseController 
{
	protected $sConString;
	protected $sBasePath;
	protected $oParam;
	protected $oApp;
	protected $oLoc;
	protected $oData;
	protected $oLog;
	protected $oTemplate;
	protected $oMailer;
	protected $aContext;
	
	/**
	 * Constructor, initialize attributes and objects 
	 *
	 * @param Parameter $_oParam The parameter used to initialize attributes and objects
	 */
	public function __construct(Parameter $_oParam, &$_aContext) 
	{
		$this->oApp = $_oParam->get('app');
		$this->oData = $_oParam->get('runData');
		$this->oLoc = $_oParam->get('localeTool');
		$this->sBasePath = $_oParam->get('basePath');
		$this->oSmarty = $_oParam->get('smarty');
		$this->aContext = &$_aContext;
		$this->oParam = $_oParam;
		$this->aPageList = array();
		$this->aSortable = array();
		$this->aLink = array();
		$this->setLogInstance();
		$this->oMailer = new Mailer($this->oLog);
		
		$this->aContext['oAttributes'] = new Attributes();
	}
	
	protected function setLogInstance()
	{
		$this->oLog = Log::singleton(
			'file', 
			Attributes::LOG_PATH . get_class($this) . '/' . Application::getCustomDate('d-m-Y') . '.log', 
			get_class($this), 
			array(), 
			Attributes::LOG_LEVEL
		);
	}
	/*
	public function sendMail($aFrom, $aTo, $sSubject, $sTemplateName, $aContext, $sContentType = 'text/plain', $aAttach = array(), $aReplyTo = null)
	{
//		$this->oSmarty->template_dir = Attributes::TEMPLATE_PATH;
		$this->oSmarty->clear_all_cache();
		$this->oSmarty->assign(array_merge($this->aContext,$aContext));
		$this->oMailer->ClearAttachments();
		$this->oMailer->ContentType = $sContentType;
		$this->oMailer->Sender = Attributes::SMTP_USER;
		$this->oMailer->From = $aFrom[0];
		$this->oMailer->FromName = $aFrom[1];
		$this->oMailer->Subject = $sSubject;
		$this->oMailer->Body = $this->oSmarty->fetch('mail/' . $sTemplateName, null, null, false);
//		print 'FROM: '.$this->oMailer->From.'<br/>';
//		print 'TO: <br/>';
//		print 'SUBJECT: '.$sSubject.'<br/>';
//		print $this->oMailer->Body;exit;
		
		foreach ($aAttach as $sRealFile => $sNewName)
		{
			if(file_exists($sRealFile))
			{
				$this->oMailer->AddAttachment($sRealFile,$sNewName);
			}
		}

		foreach ($aTo as $aTemp)
		{
			$this->oMailer->ClearAllRecipients();
			$this->oMailer->AddAddress($aTemp[0],$aTemp[1]);
			$bResult = $this->oMailer->Send();

			if($bResult == false)
			{
				break;
			}
		}
		
		if(is_array($aReplyTo))
		{
			$this->oMailer->AddReplyTo($aReplyTo[0],$aReplyTo[1]);
		}

		$this->oSmarty->clear_all_cache();
		
		return $bResult;
	}
	*/
	public function doValidate($oObj,$sSource)
	{
		if($oObj->validate())
		{
			return true;
		}
		else
		{
    		foreach($oObj->getValidationFailures() as $oFailure)
    		{
		        $this->errorMessage($sSource,$oFailure->getMessage());
			}
			return false;
		}
	}
	
	public function init()
	{
		
	}
	
	public function doProcess()
	{
		$this->init();
		$this->doProcessInteceptor();
	}
	
	/**
	 * Abstract method each inteceptor must have
	 *
	 */
	abstract public function doProcessInteceptor();
}
?>
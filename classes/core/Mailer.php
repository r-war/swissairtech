<?php

include_once('PHPMailer.php');

/**
 * Mailer class
 *
 */
class Mailer extends PHPMailer 
{
	public $oLog;
	public $aError;
    
    function __construct(Log $oLog)
    {
    	$this->Host     = Attributes::SMTP_HOST;
    	$this->Port		= Attributes::SMTP_PORT;
    	$this->Username = Attributes::SMTP_USER;
    	$this->Password = Attributes::SMTP_PASSWORD;
    	
    	$this->oLog 	= $oLog;
	    $this->Mailer   = "smtp";
	    $this->aError   = array();
	    $this->SetLanguage('en', BASE_PATH . 'languages/phpmailer/');
    }
    
    /**
     * Adds the error message to the error container.
     * Returns void.
     * @access private
     * @return void
     */
    function SetError($msg) 
    {
        parent::SetError($msg);
        
        array_push($this->aError,$msg);
    }
    
    function ErrorHandler() 
    {
    	$sAddresses = '';
    	
    	if(is_array($this->to))
    	{
    		foreach ($this->to as $idx => $aTo)
    		{
    			$sAddresses .= $aTo[0];
    			
    			if($idx < count($this->to) - 1)
    			{
    				$sAddresses .= ', ';
    			}
    		}
    	}
    	
    	$sLog = 
    		"\n" . 'SEND MAIL FAILED' . "\n" .
    		'==================' . "\n" .
    		'SMTP HOST   : ' . $this->Host . ":" . $this->Port . "\n" .
    		'SENDER      : ' . $this->Sender . "\n" .
    		'FROM        : ' . $this->From . "\n" .
    		'TO          : ' . $sAddresses . "\n" .
    		'SUBJECT     : ' . $this->Subject . "\n" .
    		'ERROR #     : ' . $this->error_count . "\n" .
    		'PROBLEMS    : ';
    	
    	foreach ($this->aError as $idx => $sError)
    	{
    		if($idx > 0)
    		{
    			$sLog .= '              ';
    		}
    		$sLog .= '- ' . $sError . "\n";
    	}
    	
    	$sLog .= '==================' . "\n";
    	
    	$this->oLog->log(
			$sLog, 
			PEAR_LOG_ERR
    	);
    }
    
    /**
     * Creates message and assigns Mailer. If the message is
     * not sent successfully then it returns false.  Use the ErrorInfo
     * variable to view description of the error.  
     * @return bool
     */
    function Send() 
    {
    	$bResult = parent::Send();
//		$bResult = true;
    	
    	if($bResult == false)
    	{
    		$this->ErrorHandler();
    	}
    	else 
    	{
    		$sAddresses = '';
    	
	    	if(is_array($this->to))
	    	{
	    		foreach ($this->to as $idx => $aTo)
	    		{
	    			$sAddresses .= $aTo[0];
	    			
	    			if($idx < count($this->to) - 1)
	    			{
	    				$sAddresses .= ', ';
	    			}
	    		}
	    	}
	    	
    		$sLog = 
			"\n" . 'SEND MAIL SUCCESS' . "\n" .
			'==================' . "\n" .
			'SMTP HOST   : ' . $this->Host . ":" . $this->Port . "\n" .
			'SENDER      : ' . $this->Sender . "\n" .
			'FROM        : ' . $this->From . "\n" .
			'TO          : ' . $sAddresses . "\n" .
			'SUBJECT     : ' . $this->Subject . "\n" .
			'==================' . "\n";
			
			$this->oLog->log(
				$sLog, 
				PEAR_LOG_INFO
	    	);
    	}
    	
    	return $bResult;
    }
}

?>
<?php
include_once 'AbstractCommonModule.php';
use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client;

class DefaultModule extends AbstractCommonModule
{
	public function getName()
	{
		$sName = $this->oLoc->get('home');
		return $sName;
	}
	
	public function doBuildTemplate()
	{
		$this->doSubscribe();
		$this->handleConsults();

		if (!empty($_POST['contact']))
			$this->contactUs();

		$param = null;

		$view = [
			"news_list" 		=> NewsPeer::getAll($param, null, -1, $param, 5),
			
			"testimonials" 		=> TestimonialPeer::getNewest(),
			"banners" 			=> BannerPeer::getByGroup("sliding"),
			"source"			=> 'Default'
		];
		$this->aContext += $view;
	}

	private function getServices()
	{
		$services_id = 3;
		$menu 	= MenuPeer::getByParentId($services_id);
		$pages 	= [];

		$i = 1;
		foreach ($menu as $item) {
			# only process if menu is a page
			if ($item->getType() != 2) {
				continue;
			}

			if ($i > 6)
				continue;

			$page = PagePeer::retrieveByPk($item->getValue());
			$page->title = $this->limit_words(strip_tags($page->getDescription()), 15);

			$pages[] = $page;

			$i++;
		}

		return $pages;

	}

	public function limit_words($string, $word_limit)
	{
	  $words = explode(" ",$string);
	  return implode(" ",array_splice($words,0,$word_limit));
	}	
	
	public function doSubscribe()
	{
		if($this->oData->isExists('emailsub'))
		{
			$sName = $this->oData->get('namesub');
			$sEmail = $this->oData->get('emailsub');
			if(!preg_match('/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i',$sEmail))
			{
				$this->aContext['bSuccessSub'] = '<script>alert(\''.$this->oLoc->get('invalid-email').' !\')</script>';
				$bError = true;
			}	
			if($sName == '') $sName = $sEmail;
			
			if(!$bError && md5($this->oData->get('captcha')) != $this->getSession('captchasessionsubs'))
			{
				$this->aContext['bSuccessSub'] = '<script>alert(\''.$this->oLoc->get('not_matched-captcha').' !\')</script>';
				$bError = true;
			}
			
			if($sName && $sEmail && !$bError)
			{
				$oSubscriber = SubscriberPeer::getByNameAndEmail($sName,$sEmail);
				if(!$oSubscriber instanceof Subscriber)
				{
					$oSubscriber = new Subscriber();
					$oSubscriber->setDate(Application::getFormalDateTime());
					$oSubscriber->setName($sName);
					$oSubscriber->setEmail($sEmail);
					$oSubscriber->save();
					
					$aEmailTo = array();
	                $sConfigEmail = $this->aConfig['email_enquiry'];
	                $aEmail = explode(',', $sConfigEmail);
	                foreach ($aEmail as $sEmailTemp)
	                {
	                	$aEmailTo[] = array(trim($sEmailTemp),trim($sEmailTemp));
	                }
	                 
	                $aSmtp['host'] = $this->aConfig['smtp_host'];
	                $aSmtp['username'] = $this->aConfig['smtp_user'];
	                $aSmtp['password'] = $this->aConfig['smtp_password'];
					$aSmtp['port'] = $this->aConfig['smtp_port'];
	                if($aSmtp['host'] == 'smtp.gmail.com')
	                	$aSmtp['isgmail'] = true;
	                
	                $this->sendMail(
	                		array($this->aConfig['email_from'], $this->aConfig['web_title']),
	                		array(array($sEmail, $sName)),
	                		$this->aConfig['web_title'].' : Thanks for Subscribing on Us ! ',
	                		'subscriber.tpl',
	                		array(
	                				'oUser' => $oUser,
	                				'aConfig' => $this->aConfig,
	                				'oMod' => $this,
	                				'sTitle' => 'Thanks for Subscribing on Us !'
	                		),
	                		'text/html',
	                		null, null,
	                		$aSmtp
	                );
					$this->aContext['bSuccessSub'] = '<script>alert(\''.$this->oLoc->get('desc_success_subscribe').' \')</script>';
				}
				else 
					$this->aContext['bSuccessSub'] = '<script>alert(\''.$this->oLoc->get('desc_success_subscribe').' \')</script>';
			}
		}
	}

	public function contactUs()
	{
		$fullname   = $_POST['fullname'];
		$mailaddr   = $_POST['email'];
		$subjects   = $_POST['subject'];
		$messages   = $_POST['message'];
		$captcha    = $_POST['g-recaptcha-response'];
		$error = false;

		if ( empty($fullname) || empty($subjects) || empty($mailaddr) || empty($messages) || empty($captcha) ) {
			$error = true;
			$this->error('All fields are mandatory');
		}
		else {

			if ( strlen($fullname) < 3 ) {
				$error = true;
				$this->error('Fullname needs minimum 3 characters');
			}

			if ( ! Validator::email()->validate($mailaddr) ) {
				$error = true;
				$this->error('Wrong email format');
			}

			# validate google recaptcha
			$client = new Client([
				'verify' => false
			]);

			$response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
				'form_params' => [
				  'secret' => '6LdykDQUAAAAACPzItFAAjxrl4lm5dBCY4IF0PB3',
				  'response' => $captcha
				]
			]);

			$item = json_decode($response->getBody());
			if ( !$item->success ) {
				$error = true;
				$this->error('Captcha verification failed');
			}
		}

		if (!$error) {

			# set mail data
			$maildata = new stdClass();
			$maildata->fullname   = $fullname;
			$maildata->mailaddr   = $mailaddr;
			$maildata->subjects   = $subjects;
			$maildata->messages   = $messages;

			#set mail from
			$mailfrom = array(
				$this->aConfig['email_from'],
				$this->aConfig['web_title']
			);

			#set mail to
			$recipients   = array();

			$recipients[] = array ($mailaddr, $mailaddr);
			$replyto = array ($mailaddr, $mailaddr);

			$bcc_mails = explode( ",", $this->aConfig['email_enquiry'] );
			foreach ( $bcc_mails as $bcc )
			{
				$recipients[] = array( $bcc, $bcc );
			}

			#set subject
			$subject = "Contact from " . $maildata->mailaddr;

			#set template used
			$template = "contact.tpl";

			#assign values
			$vars = array(
				'oMod'  	=> $this,
				'aConfig' 	=> $this->aConfig,
				'data'  	=> $maildata,
			);

			#mail type
			$mail_type = 'text/html';

			#mail smtp
			$smtp['host']     = $this->aConfig['smtp_host'];
			$smtp['username'] = $this->aConfig['smtp_user'];
			$smtp['password'] = $this->aConfig['smtp_password'];
			$smtp['port']     = $this->aConfig['smtp_port'];

			if ($smtp['host'] == 'smtp.gmail.com')
				$smtp['isgmail'] = true;

			#send email
			$mail = $this->sendMail( $mailfrom, $recipients, $subject, $template, $vars, $mail_type, null, $replyto, $smtp );

			if ( $mail )
			{
				$this->info( 'Your message are successfully sent' );
			}
			else
			{
				$this->error( "There's a problem when sending your message, please try it again later." );
			}
		}
	}

	public function handleConsults()
	{
		if ( ! empty( $_POST['consult'] ) )
		{
			extract($_POST);
			$error = array();

	    # validate captcha
	    if( md5( $captcha ) != $this->getSession('captchasession') )
	    {
	    	$error[] = 'Captcha not match';
	    }

	    # validate input
	    if ( empty( $fullname ) || empty($email) || empty($mobile) || empty($messages) ) {
	      $error[] = 'Please fill all required fields';
	    }

	    # validate product
	    if ( empty( $product ) ) {
	    	$error[] = 'Please choose 1 or more product that interest you';
	    }

	    if ( $error ) {
	    	$text = 'Error:' . PHP_EOL;
	    	foreach ( $error as $err )
	    	{
	    		$text .= $err . PHP_EOL;
	    	}
	    	echo $text;
	    	exit;
	    }
	    else
	    {
	      # set mail data
	      $maildata = new stdClass();
	      $maildata->fullname   = $fullname;
	      $maildata->mailaddr   = $email;
	      $maildata->phonenum   = $mobile;
	      $maildata->products   = $product;
	      $maildata->messages   = $messages;

	      #set mail from
	      $mailfrom = array(
	        $this->aConfig['email_from'],
	        $this->aConfig['web_title']
	      );

	      #set mail to
	      $recipients = array();

	      #add user to email
	      $recipients[] = array ($email, $email);

	      $bcc_mails = explode( ",", $this->aConfig['email_enquiry'] );
	      foreach ( $bcc_mails as $bcc )
	      {
	        $recipients[] = array( $bcc, $bcc );
	      }

	      #set subject
	      $subject = "Consultation Form from" . " | " . $this->aConfig['web_title'];

	      #set template used
	      $template = "booking.tpl";

	      #assign values
	      $vars = array(
	        'oMod'  => $this,
	        'aConfig' => $this->aConfig,
	        'data'  => $maildata,
	        );

	      #mail type
	      $mail_type = 'text/html';

	      #mail smtp
	      $smtp['host']     = $this->aConfig['smtp_host'];
	      $smtp['username'] = $this->aConfig['smtp_user'];
	      $smtp['password'] = $this->aConfig['smtp_password'];
	      $smtp['port']     = $this->aConfig['smtp_port'];

	      if ($smtp['host'] == 'smtp.gmail.com')
	        $smtp['isgmail'] = true;

	      #send email
	      $mail = $this->sendMail( $mailfrom, $recipients, $subject, $template, $vars, $mail_type, null, $mailfrom, $smtp );

	      if ( $mail )
	      {
	        echo "Your contact message are successfully sent";
	      }
	      else
	      {
	        echo "There's a problem when sending your booking appointment, please try it again later.";
	      }
	      exit;
	    }
	    exit;
		}
		
	}	
}
?>
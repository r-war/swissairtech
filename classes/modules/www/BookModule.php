<?php
include_once 'AbstractCommonModule.php';

class BookModule extends AbstractCommonModule
{
	public function getName()
	{
		return "Book Appointment";
	}

	public function doBuildTemplate()
	{

		if ( ! empty( $_POST ) )
		{
			$this->booking();
		}

		$date = $this->generate_date();
		$this->aContext['time_visits'] 	= $date;
		$this->aContext['source'] 			= 'Book';

		$cookie = array(
			"fullname" => "",
			"mailaddr" => "",
			"phonenum" => "",
			);

		if ( isset( $_COOKIE['booking_data'] ) )
		{
			$cookie = json_decode( $_COOKIE['booking_data'] );
		}

		$this->aContext['cookie'] = $cookie;
	}

	private function generate_date()
	{
		$date = array();
		for ( $i = 8; $i < 22; $i++ )
		{
			$date[] = sprintf("%02d:%02d\n", $i, 0);
			$date[] = sprintf("%02d:%02d\n", $i, 30);
		}
		return $date;
	}

	private function booking()
	{
		extract( $_POST );

		$error = false;

		#	validate captcha
		if( md5( $captcha ) != $this->getSession('captchasession') )
		{
			$this->error('Captcha not match');
			$error = true;
		}

		#validate input
		if ( empty( $fullname ) || empty($mailaddr) || empty($phonenum) || empty($datevisit) || empty($timevisit) || empty($services) ) {
			$this->error('Please fill all required fields');
			$error = true;
		}

		# no error, proceed
		if ( ! $error )
		{
			# set mail data
			$maildata = new stdClass();
			$maildata->fullname 	= $fullname;
			$maildata->mailaddr 	= $mailaddr;
			$maildata->phonenum 	= $phonenum;
			$maildata->datevisit 	= $datevisit;
			$maildata->timevisit 	= $timevisit;
			$maildata->services 	= implode( ",", $services );
			$maildata->messages 	= $messages;

			#set mail from
			$mailfrom = array(
        $this->aConfig['email_from'],
        $this->aConfig['web_title']
      );

      #set mail to
      $recipients = array();

      #add user to email
      $recipients[] = array ($mailaddr, $mailaddr);

      $bcc_mails = explode( ",", $this->aConfig['email_enquiry'] );
      foreach ( $bcc_mails as $bcc )
      {
      	$recipients[] = array( $bcc, $bcc );
      }

      #set subject
      $subject = "Book Appointment" . " " . $this->aConfig['web_title'];

      #set template used
      $template = "booking.tpl";

      #assign values
      $vars = array(
        'oMod' 	=> $this,
        'aConfig' => $this->aConfig,
        'data'	=> $maildata,
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
				$cookie = array(
					"fullname" => $fullname,
					"mailaddr" => $mailaddr,
					"phonenum" => $phonenum,
					);

				$month = 3600 * 24 * 30;
				setcookie( "booking_data", json_encode( $cookie ), time() + ($month * 6) );
				$this->info( "Your booking request are successfully sent" );
			}
			else
			{
				$this->error( "There's a problem when sending your booking appointment, please try it again later." );
			}

		}

	}
}
?>
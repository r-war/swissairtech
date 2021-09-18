<?php
include_once 'AbstractCommonModule.php';
use Respect\Validation\Validator as Validator;
use GuzzleHttp\Client;

class ContactUsModule extends AbstractCommonModule
{
	public function getName()
	{
		return "Contact Us";
	}

	public function doBuildTemplate()
	{

		if ( $this->oData->isExists('send') )
		{
			$this->contactUs();
		}
    $this->aContext['source'] = 'ContactUs';
	}

  public function contactUs()
  {
    // $type       = $_POST['type'];
    $fullname   = $_POST['name'];
    $mailaddr   = $_POST['email'];
    //$subjects   = $_POST['subject'];
    $messages   = $_POST['message'];
    $captcha    = $_POST['g-recaptcha-response'];
    $error = false;

    if ( empty($fullname)|| empty($mailaddr) || empty($messages) ) {
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
      // $client = new Client([
      //   'verify' => false
      // ]);

      // $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
      //   'form_params' => [
      //     'secret' => '6LfdvbYZAAAAAHMAIZ6omLxi3HTKec_ekGJNrdW0',
      //     'response' => $captcha
      //   ]
      // ]);

      // $item = json_decode($response->getBody());
      // if ( !$item->success ) {
      //   $error = true;
      //   $this->error('Captcha verification failed');
      // }
    }

    if (!$error) {

      # set mail data
      $maildata = new stdClass();
      // $maildata->type       = $type;
      $maildata->name   = $fullname;
      $maildata->email   = $mailaddr;
      // $maildata->subjects   = $subjects;
      $maildata->messages   = $messages;
      // $maildata->phone      = $phone;

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
      $subject = "Contact from " . $maildata->email;

      #set template used
      $template = "contact.tpl";

      #assign values
      $vars = array(
        'oMod'    => $this,
        'aConfig' => $this->aConfig,
        'data'    => $maildata,
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

}
?>
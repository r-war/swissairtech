<?php
include_once 'AbstractCommonModule.php';

class CaptchaModule extends AbstractCommonModule
{
	protected $bSubs;
	
	public function init()
	{
		$this->useTemplate(false);
		
		if($this->oData->isExists('subs'))
			$this->bSubs = true;
	}
	
	public function getName()
	{
		return 'Captcha ';
	}
	
	public function doBuildTemplate()
	{
		$randomnr = rand(1000, 9999);
		
		if($this->bSubs)
			$this->setSession('captchasessionsubs', md5($randomnr));
		else
	 		$this->setSession('captchasession', md5($randomnr));
		
		$im = imagecreatetruecolor(100, 38);
	 
		$white = imagecolorallocate($im, 255, 255, 255);
		$grey = imagecolorallocate($im, 150, 150, 150);
		$black = imagecolorallocate($im, 0, 0, 0);
	 
		imagefilledrectangle($im, 0, 0, 200, 35, $black);
	
		$font = './templates/www/default/css/_/karate.ttf';
		
		imagettftext($im, 20, 4, 22, 30, $grey, $font, $randomnr);
	 
		imagettftext($im, 20, 4, 15, 32, $white, $font, $randomnr);
	 	
		//prevent caching on client side:
		header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	 
		header ("Content-type: image/gif");
		imagegif($im);
		imagedestroy($im);
	}
}
?>
<?php
include_once 'AbstractAdminModule.php';

class ConfigurationModule extends AbstractAdminModule
{
	protected $aKey;
	protected $sMode;
	protected $sName = 'Site Configuration';
		
	public function getName()
	{
		return $this->sName;
	}
	
	public function init()
	{
		$this->sMode = $this->oData->get('mode');
		if($this->sMode) $this->addLink('mode='.$this->sMode);
		
		switch ($this->sMode) {
			case 'email':
				$this->aKey = array(
					'email_from' => 'Email From',
					'email_enquiry' => 'Email Enquiry (To/CC)',
					'smtp_host' => 'SMTP Host',
					'smtp_port' => 'SMTP Port',
					'smtp_user' => 'SMTP User',
					'smtp_password' => 'SMTP Password'
				);
				$this->sName = 'Email Configuration';
				break;
				
			case 'shipping_cost':
				$this->aKey = array(
					// 'shipping_box_weight' => 'Shipping Box Weight',
					'shipping_cost_flat' => 'Shipping Cost',
					'shipping_cost_free' => 'Minimum Amount to get Free Shipping Cost',
					'shipping_cost_overseas' => 'Shipping Cost for Overseas',
				);
				$this->sName = 'Payment Configuration';
				break;
				
			case 'paypal':
				$this->aKey = array(
					'paypal_username' => 'Paypal API Username',
			 		'paypal_password' => 'Paypal API Password',
					'paypal_signature' => 'Paypal API Signature',
					'paypal_currency' => array(
						'name' => 'Paypal API Currency',
						'type' => 'input',
						'help' => 'Currency used on paypal request (3 chars currency)'
					),
					'paypal_rate' => array(
						'name' => 'Paypal API Rate',
						'type' => 'input',
						'help' => '1'.$this->aConfig['currency'].' = ? '.$this->aConfig['paypal_currency']
					),
					
				);
				$this->sName = 'Paypal/Payment API Configuration';
				break;
				
			case 'social':
				$this->aKey = array(
					'youtube_link' => 'Youtube Link',
					'facebook_link' => 'Facebook Link',
					'twitter_link' => 'Twitter Link',
					'instagram_link' => 'Instagram Link',					
					'linkedin_link' => 'LinkedIn Link',
					'mail_link' => 'Mail Link',
				);
				$this->sName = 'Social Media Configuration';
				break;
			
			case 'script':
				$this->aKey = array(
					'custom_script' => array(
							'name' => 'Custom Script',
							'type' => 'textarea',
							'help' => 'This script will be loaded before tag </head>. You can put any script here, for example google analytics.'
						),
				);
				$this->sName = 'Custom Script Configuration';
				break;
				
			case 'currency':
				$this->aKey = array(
					'currency' => array(
							'name' => 'Currency',
							'type' => 'input',
							'help' => 'Currency code used on all transaction, ex : SGD, USD, IDR'
						),
					'decimal' => array(
						'name' => 'Decimal',
						'type' => 'input',
						'help' => 'Number of digits on decimal number. default : 0'
					),
					'decimal_separator' => array(
						'name' => 'Decimal separator',
						'type' => 'input',
						'help' => 'Separator on decimal number. default : .'
					),
					'thousand_separator' => array(
						'name' => 'Thousand separator',
						'type' => 'input',
						'help' => 'Separator on thousand number. default : ,'
					),
				);
				$this->sName = 'Currency Configuration';
				break;
			case 'banner':
				$this->aKey= array(
					'page'=>array(
						'name'	=> 'Page Banner',
						'type'	=> 'picture'
					),
					'home1'=>array(
						'name'	=> 'Home Banner',
						'type'	=> 'picture'
					),
					'product'=>array(
						'name'	=> 'Products Banner',
						'type'	=> 'picture'
					),
					'news' => array(
						'name'	=> 'news banner',
						'type'	=> 'picture',
					),
					'testimonial' => array(
						'name'	=> 'Testimonial banner',
						'type'	=> 'picture',
					),
				);
				$this->sName = 'Banner Image Configuration';
				break;
			default:
				$this->aKey = array(
					// 'web_maintenance' => array(
							// 'name' => 'Maintenance Mode',
							// 'type' => 'toogle',
							// 'help' => 'Yes : website is on maintenance mode, the content can be updated from Content Module'
						// ),
					'contact_map' => array(
							'name'=>'Contact Map',
							'type'=>'textarea',
						),
					'web_logo' => array(
							'name' => 'Web Logo header',
							'type' => 'picture',
							'help' => 'Make sure your logo size fit to your theme / web design'
						),
					// 'web_logo_footer' => array(
					// 	'name' => 'Web Logo Footer',
					// 	'type'	=> 'picture'
					// ),
					'web_ico' => array(
							'name' => 'Web Icon',
							'type' => 'picture',
							'help' => 'Picture on Browser Tab 16 x 16 pixel'
						),
					'web_title' => 'Website Title',
					// 'web_title_en' => 'Website Title (EN)',
					// 'web_title_cn' => 'Website Title (CN)',
					// 'web_title_my' => 'Website Title (MY)',
					// 'banner_tagline_en' => 'Banner Tagline (EN)',
					// 'banner_tagline_it' => 'Banner Tagline (IT)',
					// 'tagline_en' => array(
							// 'name' => 'Website Tagline (EN)',
							// 'type' => 'textarea',
							// 'style' => 'height:55px;'
						// ),
					// 'tagline_cn' => array(
							// 'name' => 'Website Tagline (CN)',
							// 'type' => 'textarea',
							// 'style' => 'height:55px;'
						// ),
					'copyright_en' => array(
							'name' => 'Website Copyright (EN)',
							'type' => 'textarea',
							'style' => 'height:55px;'
						),
					/*
					'copyright_jp' => array(
							'name' => 'Website Copyright (JP)',
							'type' => 'textarea',
							'style' => 'height:55px;'
						),
					*/
					// 'google_map' => array(
							// 'name' => 'Google Map Iframe',
							// 'type' => 'textarea',
							// 'help' => 'Paste google maps iframe code here'
						// ),
					'meta_name_description' => array(
							'name' => 'SEO Description',
							'type' => 'textarea',
							'help' => 'This is used on Search Engine Optimization, write your website description.'
						),
					'meta_name_keywords' => array(
							'name' => 'SEO Keywords',
							'type' => 'textarea',
							'help' => 'This is used on Search Engine Optimization, write keywords that describe your website. Separate with comma (,) for each keywords.'
						),
				);
				break;
		}
	}
	
	public function doBuildTemplate()
	{
		if($this->oData->isExists('save'))
		{
			$this->doSave();
		}
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->aContext['aKey'] = $this->aKey;
	}
	
	private function doSave()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
			foreach($this->aKey as $sKey => $sName)
			{
				$sFile = '';
				$sValue = '';
				$bSave = false;
				
				if(is_array($sName) && $sName['type'] == 'picture')
				{
					$sFilename = $this->processUpload(
						$sKey,
						'contents/'.$this->oApp->sDomain.'/images/',
						explode(',',BannerPeer::FILE_TYPE_IMAGE),
						null,
						true,
						true
					);
					$sFile = 'contents/'.$this->oApp->sDomain.'/images/'.$sFilename;
				}
				else {
					$sValue = $this->oData->get($sKey);
					$bSave = true;	
				}
				
				if(($sFile && is_file($sFile)) || $bSave)
				{
					$oConfiguration = ConfigurationPeer::getByDomainAndKey(Attributes::CONFIG_WEB, $sKey);
					if(!$oConfiguration instanceof Configuration)
					{
						$oConfiguration = new Configuration();
						$oConfiguration->setDomain(Attributes::CONFIG_WEB);
						$oConfiguration->setKeyName($sKey);
					}
					
					if(is_array($sName) && $sName['type'] == 'picture' && $sFile && is_file($sFile))
					{
						if($oConfiguration instanceof Configuration)
							$sOldFile = 'contents/'.$this->oApp->sDomain.'/images/'.$oConfiguration->getValue();
	
						$oConfiguration->setValue($sFilename);
					}
					else {
						$oConfiguration->setValue($sValue);
					}
					$oConfiguration->save();
					if(is_array($sName) && $sName['type'] == 'picture' && $sOldFile && is_file($sOldFile)) unlink($sOldFile);	
				}
					
			}
			$oCon->commit();
			$this->info('succeed_no_info-configuration-saved');
		}
		catch (Exception $oEx)
		{
			if($sFile && is_file($sFile)) unlink($sFile);	
			
			$oCon->rollBack();
			$this->error('failed_no_info-configuration-saved');
			$this->errorHandler($oEx);
	  	}
	}
}
?>
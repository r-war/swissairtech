<?php



include_once 'AbstractAdminModule.php';







class ContentModule extends AbstractAdminModule



{



	protected $sKey;



	protected $aKey;



	protected $oConfiguration;



	



	public function init()



	{



		$this->aKey = array(



			'content_home' => 'Home Content',
			'header_motto' => 'Header Quote',
			'address ' =>'Address Menu',

			'social'	=> 'Social Footer',

			'contact' => 'Contact footer',

			#'content_sidebar' => 'Sidebar Content',

			#'content_address' => 'Address Content',



			//'content_home_jp' => 'Home Content (JP)',



			//'content_widget' => 'Footer Content / Widget area',



			// 'content_contact_us' => 'Content Contact Us',



			// 'content_contact_us_jp' => 'Content Contact Us (JP)',



			// 'content_dashboard' => 'Dashboard Content',



			// 'content_dashboard_jp' => 'Dashboard Content (JP)',



			// 'content_success_buy_poa' => 'Content Web & Email on International Shipment',



			// 'content_success_buy_cc' => 'Content Web & Email Success Buy (Credit Charge)',



			// 'content_success_buy_transfer' => 'Content Web & Email Success Buy (Transfer Payment) ',



			// 'content_delivered_order' => 'Content Email on Deliver Order',



			// 'content_canceled_order' => 'Content Email on Cancel Order',



			// 'content_catalogue' => 'Content Catalogue (Members Only)',



			// 'content_success_buy_cheque' => 'Content Web & Email Success Buy (Cheque Payment) ',



			// 'content_success_buy_poa_cc' => 'Content on POA Email Sent (Credit Charge)',



			// 'content_success_buy_poa_transfer' => 'Content on POA Email Sent (Transfer Payment)',



			// 'content_maintenance' => 'Content on Maintenance Mode'



		);



		$this->sKey = $this->oData->get('key','content_home');



		$this->oConfiguration = ConfigurationPeer::getByDomainAndKey(Attributes::CONFIG_WEB, $this->sKey);



		



		if(!$this->oConfiguration instanceof Configuration)



		{



			$this->oConfiguration = new Configuration();



			$this->oConfiguration->setDomain(Attributes::CONFIG_WEB);



			$this->oConfiguration->setKeyName($this->sKey);



			$this->oConfiguration->save();



		}



	}



	



	public function getName()



	{



		$sName = 'content';



		



		return $this->oLoc->get($sName);



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



		$this->aContext['oConfiguration'] = $this->oConfiguration;



		$this->aContext['sSelectKey'] = $this->sKey;



		$this->aContext['aKey'] = $this->aKey;



	}



	



	private function doSave()



	{



		$this->doValidate($this->oConfiguration);



		if($this->noError())



		{



			$oCon = $this->getCon();



			try



			{



				$oCon->beginTransaction();



				



				$this->oConfiguration->setValue($this->oData->get('description'));



				$this->oConfiguration->save();



							



				$oCon->commit();







				$this->info('succeed-content-saved',



					array(



						$this->aKey[$this->sKey]



					)



				);







				$this->oPage = new Page();



			}



			catch (Exception $oEx)



			{



				$oCon->rollBack();



							



				$this->error('failed-content-saved',



					array(



						$this->oLoc->get($this->aKey[$this->sKey]),



						$oEx->getMessage()



					)



				);



				$this->errorHandler($oEx);



		  	}



		}



	}



}



?>
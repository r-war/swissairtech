<?php

abstract class AbstractCommonModule extends AbstractModule 
{
	protected $oLoginUser;
	protected $sLang;
	
	public function initModule()
	{
		parent::initModule();

		if($this->isUserLogin())
		{
			$this->oLoginUser = $this->getLoginUser();
			$this->aContext['oLoginUser'] = $this->getLoginUser();
		}
		
		$this->sLang = $this->getSession('selectlanguage');
		if($this->sLang != 'jp') $this->sLang = 'en';
		$this->aContext['sLang'] = $this->sLang;
	}

	public function isAuthorized()
	{
		return true;
	}
	
	public function getMetaData($sType = 'title')
	{
		switch($sType)
		{
			case 'title' :
				$sReturn = $this->getName();
				break;
			
			case 'keywords' :
				$sReturn = $this->aConfig['meta_name_keywords'];
				break;

			case 'description' :
				$sReturn = $this->aConfig['meta_name_description'];
				break;
		}
		
		return $sReturn;
	}
	
	protected function parseContent($sSource)
	{
		$sResult = $sSource;
		preg_match_all('|\{module:(.*)\}|U',$sResult,$aMatches);

		if(is_array($aMatches[1]))
		{
			foreach($aMatches[1] as $idx => $sString)
			{
				$sResult = str_replace(
					$aMatches[0][$idx],
					$this->getBasePage($sString),
					$sResult
				);
			}
		}
		
		preg_match_all('|\{\$(.*)\}|U',$sResult,$aMatches);

		if(is_array($aMatches[1]))
		{
			foreach($aMatches[1] as $idx => $sString)
			{
				if(isset($this->aConfig[$aMatches[1][$idx]]))
				{
					$sResult = str_replace(
						$aMatches[0][$idx],
						$this->aConfig[$aMatches[1][$idx]],
						$sResult
					);
				}
			}
		}
		
		preg_match_all('|\{render:(.*)\}|U',$sResult,$aMatches);

		if(is_array($aMatches[1]))
		{
			foreach($aMatches[1] as $idx => $sString)
			{
				$oSmarty = clone $this->oSmarty;
				$oSmarty->assign($this->aContext);
				$sOutput = $oSmarty->fetch($sString, null, null, false);
				
				$sResult = str_replace(
					$aMatches[0][$idx],
					$sOutput,
					$sResult
				);
			}
		}
		
		return $sResult;
	}
	
	public function getCurrentPage($sNewUrl = null)
	{
		$sURL = Common::getCurrentURL();

		if($sNewUrl != null)
		{
			$aTemp = explode('&',$sNewUrl);
			foreach($aTemp as $idx => $sTemp)
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
						if($idx == 0)
							$sURL .= '?'.$aTemp2[0].'='.$sValue;
						else
							$sURL .= '&'.$aTemp2[0].'='.$sValue;
					}
				}
			}
		}
		
		if(strlen($sURL) > 0 && substr($sURL,0,1) == '&')
		{
			$sURL = '&'.substr($sURL,1);
		}
		
		return '/'.$sURL;
	}

	public function getBaseUrl($sNewUrl = null)
	{
		$sURL = Common::getCurrentURL();
		$aTemp = explode('?',$sURL);
		$sURL = $aTemp[0];
		
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

		return '/'.$sURL;
	}	
	
	public function getBreadCrums()
	{
		$aBreadCrums= array(
			array(
				'text'	=> 'Home',
				'url' 	=> $this->getBasePage()
		
			)
		);

		return $aBreadCrums;
	}
	
	public function isUserLogin()
	{
		if($this->getLoginUser() instanceof User)
			return true;
	}
	
	public function getLoginUser()
	{
		if($this->isSessionRegistered(Attributes::SESSION_USER_LOGIN))
			return $this->getSession(Attributes::SESSION_USER_LOGIN);
	}
	
	public function getCurrencyView($iTotal)
	{
		return ProductPeer::CURRENCY_PREFIX . Common::parseDot($iTotal).ProductPeer::CURRENCY_POSTFIX ;
	}
	
	public function parseDot($iTotal)
	{
		return Common::parseDot($iTotal);
	}
	
	public function doHandleParameter()
	{
		$oParam = new Parameter();
	
		if($this->oData->isExists('q'))
		{
			$oParam->set('keywords', $this->oData->get('q'));
			$this->addLink('q='.$this->oData->get('q'));
		}
		if($this->oData->isExists('min'))
		{
			$oParam->set('min', $this->oData->get('min'));
			$this->addLink('min='.$this->oData->get('min'));
		}
		if($this->oData->isExists('max'))
		{
			$oParam->set('max', $this->oData->get('max'));
			$this->addLink('max='.$this->oData->get('max'));
		}
		if($this->oData->isExists('sort'))
		{
			$oParam->set('sort', $this->oData->get('sort'));
			$this->addLink('sort='.$this->oData->get('sort'));
		}
		
		$bTrue = true;
		$oParam->set('publicview', $bTrue);
		
		$this->aContext['oParam'] = $oParam;
	
		return $oParam;
	}
	
	public function getConfiguration($sKey)
	{
		return ConfigurationPeer::getByDomainAndKey(Attributes::CONFIG_WEB, $sKey);
	}
	
	public function getConfigurationValue($sKey)
	{
		$oConfiguration = $this->getConfiguration($sKey);
		if($oConfiguration instanceof Configuration)
			return $oConfiguration->getValue();
	}
	
	public function getCurrency()
	{
		$oConfiguration = $this->getConfiguration('currency');
		if($oConfiguration instanceof Configuration)
			return $oConfiguration->getValue();
	}
	
	public function separateWord($sWord, $idx = null)
	{
		$aWord = explode(' ',$sWord);
		if($idx == 1) return $aWord[0];
		else if($idx == 2) {
			unset($aWord[0]);
			return implode(' ',$aWord);
		}
	}
	
	public function getBaseDomain($bFull = true)
	{
		if($bFull)
			return ($bFull ? 'http://' : '').$_SERVER['HTTP_HOST'];
	}
	
	public function isMobile()
	{
		if(eregi('Googlebot-Mobile',$useragent)) {
			return true;
		} else if(eregi('Googlebot',$useragent)) {
			return false;
		}
	
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		{
			$this->aContext['bMobile'] = true;
			return true;
		}
	}
	
	public function isHTML5()
	{
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(preg_match('/ip(hone|od|ad)|symbianos|ios/i',$useragent))
		{
			$this->aContext['bHTML5'] = true;
			return true;
		}
	}
	
	public function getCountrys()
	{
		$country_list = array(
				"Singapore",
				"Afghanistan",
				"Albania",
				"Algeria",
				"Andorra",
				"Angola",
				"Antigua and Barbuda",
				"Argentina",
				"Armenia",
				"Australia",
				"Austria",
				"Azerbaijan",
				"Bahamas",
				"Bahrain",
				"Bangladesh",
				"Barbados",
				"Belarus",
				"Belgium",
				"Belize",
				"Benin",
				"Bhutan",
				"Bolivia",
				"Bosnia and Herzegovina",
				"Botswana",
				"Brazil",
				"Brunei",
				"Bulgaria",
				"Burkina Faso",
				"Burundi",
				"Cambodia",
				"Cameroon",
				"Canada",
				"Cape Verde",
				"Central African Republic",
				"Chad",
				"Chile",
				"China",
				"Colombi",
				"Comoros",
				"Congo (Brazzaville)",
				"Congo",
				"Costa Rica",
				"Cote d'Ivoire",
				"Croatia",
				"Cuba",
				"Cyprus",
				"Czech Republic",
				"Denmark",
				"Djibouti",
				"Dominica",
				"Dominican Republic",
				"East Timor (Timor Timur)",
				"Ecuador",
				"Egypt",
				"El Salvador",
				"Equatorial Guinea",
				"Eritrea",
				"Estonia",
				"Ethiopia",
				"Fiji",
				"Finland",
				"France",
				"Gabon",
				"Gambia, The",
				"Georgia",
				"Germany",
				"Ghana",
				"Greece",
				"Grenada",
				"Guatemala",
				"Guinea",
				"Guinea-Bissau",
				"Guyana",
				"Haiti",
				"Honduras",
				"Hungary",
				"Iceland",
				"India",
				"Indonesia",
				"Iran",
				"Iraq",
				"Ireland",
				"Israel",
				"Italy",
				"Jamaica",
				"Japan",
				"Jordan",
				"Kazakhstan",
				"Kenya",
				"Kiribati",
				"Korea, North",
				"Korea, South",
				"Kuwait",
				"Kyrgyzstan",
				"Laos",
				"Latvia",
				"Lebanon",
				"Lesotho",
				"Liberia",
				"Libya",
				"Liechtenstein",
				"Lithuania",
				"Luxembourg",
				"Macedonia",
				"Madagascar",
				"Malawi",
				"Malaysia",
				"Maldives",
				"Mali",
				"Malta",
				"Marshall Islands",
				"Mauritania",
				"Mauritius",
				"Mexico",
				"Micronesia",
				"Moldova",
				"Monaco",
				"Mongolia",
				"Morocco",
				"Mozambique",
				"Myanmar",
				"Namibia",
				"Nauru",
				"Nepa",
				"Netherlands",
				"New Zealand",
				"Nicaragua",
				"Niger",
				"Nigeria",
				"Norway",
				"Oman",
				"Pakistan",
				"Palau",
				"Panama",
				"Papua New Guinea",
				"Paraguay",
				"Peru",
				"Philippines",
				"Poland",
				"Portugal",
				"Qatar",
				"Romania",
				"Russia",
				"Rwanda",
				"Saint Kitts and Nevis",
				"Saint Lucia",
				"Saint Vincent",
				"Samoa",
				"San Marino",
				"Sao Tome and Principe",
				"Saudi Arabia",
				"Senegal",
				"Serbia and Montenegro",
				"Seychelles",
				"Sierra Leone",
				"Slovakia",
				"Slovenia",
				"Solomon Islands",
				"Somalia",
				"South Africa",
				"Spain",
				"Sri Lanka",
				"Sudan",
				"Suriname",
				"Swaziland",
				"Sweden",
				"Switzerland",
				"Syria",
				"Taiwan",
				"Tajikistan",
				"Tanzania",
				"Thailand",
				"Togo",
				"Tonga",
				"Trinidad and Tobago",
				"Tunisia",
				"Turkey",
				"Turkmenistan",
				"Tuvalu",
				"Uganda",
				"Ukraine",
				"United Arab Emirates",
				"United Kingdom",
				"United States",
				"Uruguay",
				"Uzbekistan",
				"Vanuatu",
				"Vatican City",
				"Venezuela",
				"Vietnam",
				"Yemen",
				"Zambia",
				"Zimbabwe"
		);
		
		return $country_list;
	}
	
	public function getShippingCost($dSubTotal, $sCountry = 'Singapore')
	{
		if($dSubTotal)
		{
			if($sCountry == 'Singapore')
			{
				if($dSubTotal < ConfigurationPeer::getValueByKey('shipping_cost_free'))
					$dShippingCost = ConfigurationPeer::getValueByKey('shipping_cost_flat');
				else
					$dShippingCost = 0;
			}
			else
				$dShippingCost = ConfigurationPeer::getValueByKey('shipping_cost_overseas');
				
			return $dShippingCost;
		}
	}

	public function jsonToArea($sJson)
	{
		$aData = json_decode($sJson, true);
		return implode("\n", $aData);
	}
	
	public function jsonToArray($sJson)
	{
		$aData = json_decode($sJson, true);
		return $aData;
	}
}
?>
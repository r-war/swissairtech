<?php
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'Common.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'Log.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'LocaleTool.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'RunData.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'Parameter.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'BaseController.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'AbstractModule.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'AbstractInterceptor.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'Sortable.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'Calendar.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'ImageTool.php');
include_once(BASE_PATH.Attributes::CORE_CLASS_PATH.'Mailer.php');

include_once(BASE_PATH.Attributes::CLASS_PATH.'session/Session2.php');
include_once(BASE_PATH.Attributes::CLASS_PATH.'smarty/Smarty.class.php');
include_once(BASE_PATH.Attributes::CLASS_PATH.'propel/Propel.php');
include_once(BASE_PATH.Attributes::CLASS_PATH.'propel/util/MyPropelPager.php');

/**
 * The main framework class, call getInstance() to get a singleton object of this framework
 */
class Application
{
	protected static $oInstance;
	
	protected $bStarted;
	protected $bDebug;
	protected $oData;
	protected $oSmarty;
	protected $oLog;
	protected $oLoc;
	protected $aModuleList;
	protected $aAllModules;
	protected $aContext;
	protected $aConfiguration;
	protected $sBasePath;
	protected $sTemplatePath;

	public $sThePath;
	public $sDomain;

	/**
	 * Constructor, initialize attributes and objects
	 *
	 */
	public function __construct() 
	{
		$this->oLog = Log::factory('file', 
			Attributes::LOG_PATH . Attributes::LOG_FILE, 
			'App', 
			array(), 
			Attributes::LOG_LEVEL 
		);
		$this->aConfiguration = array();
		$this->oData = new RunData();
		$this->bStarted = false;
		$this->bDebug = Attributes::DEBUG;
	}
	
	/**
	 * Start the "Magic"
	 * 
	 */
	public function start()
	{
		try
		{
			$this->initPropel();
			HTTP_Session2::start('SessionID', uniqid(rand(0,9)));
			$this->oSmarty = new Smarty();
			$this->oSmarty->cache_dir = Attributes::TEMPLATE_CACHE_PATH;
			$this->oSmarty->debugging = $this->bDebug;
			
			$this->handleBasePath();
//			$this->refreshAllModule();
			
			$this->bStarted = true;
		}
		catch (Exception $oEx)
		{
			$this->errorHandler($oEx);
		}
	}
	
	protected function handleBasePath()
	{
		$this->sThePath = $this->getPath();
		$this->sBasePath = $this->sThePath.'/';

		if($this->oData->isExists('lang')) 
			HTTP_Session2::set(Attributes::SESSION_LANGUAGE, $this->oData->get('lang'));
		$this->oLoc = LocaleTool::getInstance($this->sThePath);
		
		$this->sDomain = '';
		HTTP_Session2::set(Attributes::SESSION_DOMAIN, $this->sDomain);

		if($this->sThePath == 'www')
		{
			$sTemplate = ConfigurationPeer::getValueByKey(Attributes::CONFIG_TEMPLATE);
			if($sTemplate == null) $sTemplate = 'default';
			$sTemplate .= '/';
		}
		$this->sTemplatePath = $this->sBasePath . $sTemplate;

		$this->oLoc->addPackage($this->sThePath);
		
		$this->oSmarty->config_dir = Attributes::TEMPLATE_PATH . $this->sTemplatePath .  Attributes::CONFIG_PATH;
		$this->oSmarty->template_dir = Attributes::TEMPLATE_PATH . $this->sTemplatePath;
		$this->oSmarty->compile_dir = Attributes::TEMPLATE_COMPILE_PATH . $this->sTemplatePath;
	}
	
	/**
	 * Get a (singleton) object of this Application class
	 *
	 * @return 	Application Singleton object
	 */
	static public function getInstance()
	{
		if(!self::$oInstance instanceof Application)
		{
			self::$oInstance = new Application();	
		}
		
		return self::$oInstance;
	}
	
	/**
	 * Refreshing list of all installed and allowed modules
	 *
	 */
	public function refreshAllModule()
	{
		$this->aAllModules = array();
		
		$sModulePath = Attributes::MODULES_PATH . $this->sBasePath;

		if(is_dir($sModulePath))
		{
			$aFile = Common::searchDir($sModulePath);
			$sSVNRegEx = '.svn/';
			foreach ($aFile as $sFile)
			{
				str_replace($sSVNRegEx,'',$sFile,$iCtr);
				if(is_file($sFile) && $iCtr == 0)
	       		{
	       			$sFile = str_replace($sModulePath ,'',$sFile);
	       			$aFragment = explode('/',$sFile);
	       			
   					$sRegEx = "/".Attributes::MODULE_POSTFIX .".php$/";
   					$sClassName = preg_replace($sRegEx,'',array_pop($aFragment));
					$sPackage = implode('.',$aFragment);
					
					if($sPackage != '')
					{
						$sWholePath = $sPackage.'.'.$sClassName;
					}
					else 
					{
						$sWholePath = $sClassName;
					}
					
					$oModule = $this->loadModule($sPackage,$sClassName);
					
					if($oModule instanceof AbstractModule)
					{
						if($oModule->isAuthorized() && $oModule->isShowed())
						{
							if(key_exists($sPackage,$this->aAllModules) == false 
								|| is_array($this->aAllModules[$sPackage]) == false)
							{
								$this->aAllModules[$sPackage] = array();
							}
							
							array_push(
								$this->aAllModules[$sPackage],
								$oModule
							);
						}
					}
   				}
	       	}
		}

		ksort($this->aAllModules);
		
		foreach ($this->aAllModules as $sPackage => $aModules)
		{
			$bShift = false;

			if(count($this->aAllModules[$sPackage]) > 0)
			{
				if($this->aAllModules[$sPackage][0]->getSortModuleKey() != '')
				{
					foreach ($this->aAllModules[$sPackage] as $idx => $oModule)
					{
						if($oModule->getSortModuleKey() == '')
						{
							$oTemp = $this->aAllModules[$sPackage][0];
							$this->aAllModules[$sPackage][0] = $oModule;
							$this->aAllModules[$sPackage][$idx] = $oTemp;
							break;
						}
					}
				}
	
				foreach ($this->aAllModules[$sPackage] as $idx => $oModule)
				{
					if($idx > 0)
					{
						for($i=$idx; $i < count($this->aAllModules[$sPackage]); $i++)
						{
							$oPrevModule = $this->aAllModules[$sPackage][$idx-1];
							if($oPrevModule->getModule() == $this->aAllModules[$sPackage][$i]->getSortModuleKey())
							{
								$oTemp = $this->aAllModules[$sPackage][$idx];
								$this->aAllModules[$sPackage][$idx] = $this->aAllModules[$sPackage][$i];
								$this->aAllModules[$sPackage][$i] = $oTemp;
							}
						}
					}
				}
			}
			else 
			{
				unset($this->aAllModules[$sPackage]);
			}
		}
	}
	
	/**
	 * Check whether the module is valid or invalid
	 *
	 * @param 	mixed $_oModule
	 * @return	boolean True if the module is valid
	 */
	protected function isModule($sPackage, $sModule)
	{
		$sModule .= Attributes::MODULE_POSTFIX;
		$sPathToModule = str_replace('.','/',$sPackage);
		if(!empty($sPathToModule)) $sPathToModule.='/';
		$sRegEx = "/" . Attributes::MODULE_POSTFIX . "$/";
		$sFilename = $sModule.'.php';
		$sFullPath = Attributes::MODULES_PATH . $this->sBasePath . $sPathToModule . $sFilename;

		if(file_exists($sFullPath))
		{
			include_once($sFullPath);

			if(class_exists($sModule) && is_subclass_of($sModule,'AbstractModule'))
			{
				return true;
			}
		}

		return false;
	}
	
	/**
	 * Initialize Propel ORM Database
	 *
	 */
	protected function initPropel()
	{
		try
		{
			Propel::init(BASE_PATH . Attributes::CORE_CLASS_PATH . Attributes::PROPEL_CONFIG_FILE);
			$this->aConnectionList = array();
			$aConfig = Propel::getConfiguration();
			foreach ($aConfig['datasources'] as $key => $datasource)
			{
				array_push($this->aConnectionList,$key);
			}
		}
		catch (Exception $oEx)
		{
			$this->errorHandler($oEx);
		}
	}

	protected function requestDatabase($sDomain)
	{
		// request to sunset for database setup
		$sReturn = '{"0":"raymondasia","1":"localhost","2":"root","3":"admin"}';
		
		return json_decode($sReturn, true);
	}
	
	/**
	 * Process the selected module to be viewed
	 *
	 */
	public function process()
	{
		if($this->isStarted())
		{
			try
			{
				$aConfiguration = ConfigurationPeer::getAll();
				if(is_array($aConfiguration))
				{
					foreach($aConfiguration as $oConfiguration)
					{
						$this->aConfiguration[$oConfiguration->getKeyName()] = $oConfiguration->getValue();
					}
				}
				$oModule = $this->getCurrentModule();
				$this->executeModule($oModule);
			}
			catch (Exception $oEx)
			{
				if(isset($oModule) && $oModule instanceof AbstractModule )
				{
					$oModule->errorHandler($oEx,true);
				}
				else
				{
					$this->errorHandler($oEx,true);
				}
			}
		}
		else
		{
			die("Application has not started yet!");
		}
	}
	
	protected function executeModule(AbstractModule $oModule, $bRedirect = false)
	{
		static $aInterceptor;
		$aNewInterceptor[$this->sThePath] = array();
		
		if(!is_array($aInterceptor))
		{
			$aInterceptor[$this->sThePath] = array();
		}
		
		if(!$bRedirect)
		{
			$this->processInterceptor(array($this->sThePath => array('Default')));
		}
		
		$aInterceptorList = $oModule->getInterceptorList();
		
		foreach ($aInterceptorList as $sInterceptor)
		{
			if(!in_array($sInterceptor,$aInterceptor[$this->sThePath]))
			{
				array_push($aNewInterceptor[$this->sThePath],$sInterceptor);
				array_push($aInterceptor[$this->sThePath],$sInterceptor);
			}
		}

		$this->processInterceptor($aNewInterceptor);
		
		$oModule->initModule();

		if($oModule->isAuthorized())
		{
			if($oModule->isRedirect())
			{
				$aRedirectModule = $oModule->getRedirectModule();
				$oRedirectModule = $this->loadModule(
					$aRedirectModule[0],
					$aRedirectModule[1]
				);
				$this->executeModule($oRedirectModule, true);
			}
			else 
			{
				$this->aContext['oMod'] = $oModule;
				$this->aContext['oAttributes'] = new Attributes();
				
				$sTemplateName = $oModule->getTemplateName();
				$oModule->doProcess();
				$oModule->showFeedback();
	
				if($oModule->useTemplate())
				{
					$this->aContext['aAllModules'] = $this->aAllModules;
					$this->aContext['oData'] = $this->oData;
					$this->aContext['sPackageRequest'] = $this->getPackageRequest();
					$this->aContext['sModuleRequest'] = $this->getModuleRequest();
	
					$this->oSmarty->configLoad(Attributes::TEMPLATE_CONFIG);
					$this->oSmarty->assign($this->aContext);
					//$this->oSmarty->loadFilter('output', 'trimwhitespace');
					$this->oSmarty->display($oModule->getTemplateLayout());
				}
				
				$oModule->finalExecution();
			}
		}
		else 
		{
			$this->executeModule($this->loadDefaultModule(), true);
		}
	}
	
	/**
	 * Get current selected module object to be viewed
	 *
	 * @return	object The related module object to be viewed
	 */
	protected function getCurrentModule()
	{
		$oModule = $this->loadModule(
			$this->getPackageRequest(),
			$this->getModuleRequest()
		);
		
		if($oModule instanceof AbstractModule)
		{
			return $oModule;
		}

		return $this->loadDefaultModule();
	}
	
	protected function getRequestURL()
	{
		$sURL = $this->oData->get(Attributes::MODULE_URL);
		
		return $sURL;
	}
	
	protected function getModuleRequest()
	{
		$sResult = '';
		
		$aTemp = explode('.',$this->oData->get(Attributes::MODULE_URL));
		$sTemp = array_pop($aTemp);
		$sTemp = str_replace(' ', '',ucwords(str_replace('-', ' ', $sTemp)));
		$sResult = $sTemp;

		return $sResult;
	}
	
	protected function getPackageRequest()
	{
		$aTemp = explode('.',$this->getRequestURL());
		array_pop($aTemp);

		return implode($aTemp,'.');
	}
	
	public function loadDefaultModule()
	{
		return $this->loadModule('','Default');
	}
	
	/**
	 * Handling error
	 *
	 * @param	Exception $_oEx The Exception object to be handled
	 */
	public function errorHandler(Exception $_oEx,$bErrorPage = false,$bLog = false)
	{
		$this->oLog->err(
			$_oEx->getMessage()."\n\r".
			$_oEx->getTraceAsString()."\n\r".
			"******************************************************"
		);

		if($this->bDebug && $bErrorPage)
		{
			$this->aContext['oException'] = $_oEx;
			$this->aContext['sExceptionMessage'] = $_oEx->getMessage();
			$this->aContext['sExceptionStackTrace'] = $_oEx->getTraceAsString();
			$this->oSmarty->assign($this->aContext);
			$this->oSmarty->display('core/error_page.tpl');
		}
	}
	
	/**
	 * Load related module object
	 *
	 * @param	mixed $_oModule Module to be load
	 * @return	object The related module object to be loaded
	 */
	public function loadModule($sPackage,$sModule)
	{
		if($this->isModule($sPackage,$sModule))
		{
			$oParam = new Parameter();
			$oParam->set('app', $this);
			$oParam->set('runData', $this->oData);
			$oParam->set('localeTool', $this->oLoc);
			$oParam->set('smarty', $this->oSmarty);
			$oParam->set('package', $sPackage);
			$oParam->set('configuration',$this->aConfiguration);
			$oParam->set('basePath', $this->sThePath);
			
			$sModule .= Attributes::MODULE_POSTFIX;

			return new $sModule($oParam,$this->aContext);
		}
		else 
		{
			return $this->loadDefaultModule();
		}
	}
	
	/**
	 * Static method to get configuration for the application
	 *
	 * @param	string $sKey The configuration key
	 * @return	string The configuration value
	 */
	static function getConfig($_sKey = null)
	{
		try
		{
			$oCrit = new Criteria();
			$aConfigurations = array();
			$aConfigurations = ConfigurationPeer::doSelect($oCrit,$oCon);
		}
		catch (Exception $oEx)
		{
			Application::getInstance()->errorHandler($oEx);
		}
		
		$aResult = array();
		foreach($aConfigurations as $oConfiguration)
		{
			$aConfig[$oConfiguration->getKeyName()] = $oConfiguration->getValue();
		}
		
		if(empty($_sKey)) return $aConfig;
		else return $aConfig[$_sKey];
	}
	
	/**
	 * Check whether the interceptor valid and available
	 *
	 * @param 	string $sInterceptor
	 * @return 	boolean	True if the interceptor is valid
	 */
	protected function isInterceptor($sPackage,$sInterceptor)
	{
		$sInterceptorPath = Attributes::INTERCEPTOR_PATH .$sPackage.'/';
		$sRegEx = "/Interceptor$/";
		$sFilename = $sInterceptor.'.php';
	
		if(preg_match($sRegEx,$sInterceptor) && is_file($sInterceptorPath.$sFilename))
		{
			include_once($sInterceptorPath.$sFilename);
			if(class_exists($sInterceptor) 
				&& is_subclass_of($sInterceptor,'AbstractInterceptor')) return true;
		}

		return false;
	}
	
	/**
	 * Process the available interceptors
	 *
	 */
	protected function processInterceptor($aInterceptor = array())
	{
		$sInterceptorPath = Attributes::INTERCEPTOR_PATH;
		
		foreach ($aInterceptor as $sPackage => $aFile)
		{
			foreach ($aFile as $sFile)
			{
				$sFile = $sPackage.'/'.$sFile;
				$sFile .= Attributes::INTERCEPTOR_POSTFIX . '.php';
				
				if(is_file($sInterceptorPath.$sFile))
				{
					$sRegEx = "/" . Attributes::INTERCEPTOR_POSTFIX . ".php$/";
					$sClassName = preg_replace($sRegEx,'',basename($sFile));
					$oInterceptor = $this->loadInterceptor($sPackage,$sClassName .  Attributes::INTERCEPTOR_POSTFIX);
					if($oInterceptor instanceof AbstractInterceptor)
					{
						$oInterceptor->doProcess();
					}
				}
			}
		}
	}
	
	/**
	 * Load related interceptor object
	 *
	 * @param	mixed $_oInterceptor Interceptor to be load
	 * @return	object The related interceptor object to be loaded
	 */
	protected function loadInterceptor($sPackage,$_oInterceptor)
	{
		if($this->isInterceptor($sPackage,$_oInterceptor))
		{
			$oParam = new Parameter();
			$oParam->set('app', $this);
			$oParam->set('runData', $this->oData);
			$oParam->set('localeTool', $this->oLoc);
			$oParam->set('smarty', $this->oSmarty);
			$oParam->set('basePath', $this->sThePath);
			$oParam->set('configuration',$this->aConfiguration);
			$oParam->set('log', Log::singleton('file',Attributes::LOG_PATH . $_oInterceptor . '/' . Application::getCustomDate('d-m-Y') . '.log', $_oInterceptor, array(), Attributes::LOG_LEVEL));
			
			return new $_oInterceptor($oParam,$this->aContext);
		}
	}
	
	protected function getPath()
	{
		if($sPath = $this->oData->get('p'))
			return $sPath;
		else
			return 'www';
	}
	
	static function redirect($sUrl,$sMode='header')
	{
		if(!empty($sUrl))
		{
			switch ($sMode)
			{
				case 'js':
					print '<script type="text/javascript">document.location=\''.$url .'\';</script>';
					break;
				case 'ajax':
					print '<script type="text/javascript">ajx(new Array(\'mainPanel\'),\''.$url .'\');</script>';
					break;
				default:
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $sUrl);
					break;
			}
			exit;
		}
	}
	
	/**
	 * Get the formal DateTime for the database
	 * (Ex: 2007-03-27 17:02:23)
	 *
	 * @return string The string of DateTime
	 */
	static function getFormalDateTime()
	{
		return date(Attributes::DEFAULT_FORMAL_DATETIME_FORMAT);
	}
	
	/**
	 * Get the custom current Date
	 *
	 * @return string The string of Date
	 */
	static function getCustomDate($sFormat)
	{
		return date($sFormat);
	}
	
	/**
	 * Check whether the Application has been started
	 *
	 * @return boolean
	 */
	public function isStarted()
	{
		return $this->bStarted;
	}
	
	/**
	 * Destructor
	 *
	 */
	public function __destruct()
	{
		
	}
}
?>
<?php
class Attributes
{
	const DEBUG = false;
	const TESTING = true;
	const REWRITE = true;
	const DEFAULT_LANGUAGE = 'en';
	const CSV_SEPARATOR = ';';
	const INTERCEPTOR_POSTFIX = 'Interceptor';
	const THUMBNAIL_POSTFIX = '_t';
	const LOG_LEVEL = PEAR_LOG_DEBUG;
	const LOG_FILE = 'app.log';
	const PROPEL_CONFIG_FILE = 'propel-conf.php';
	
	const DEFAULT_DOMAIN = '';
	
	const MODULE_URL = 'x';
	const MODULE_POSTFIX = 'Module';
	
	const LOG_PATH = 'logs/';
	const CONFIG_PATH = 'config/';
	const CLASS_PATH = 'classes/';
	const CORE_CLASS_PATH = 'classes/core/';
	const ADDITIONAL_CLASS_PATH = 'classes/additional/';
	const LANGUAGES_PATH = 'languages/';
	const MODULES_PATH = 'classes/modules/';
	const INTERCEPTOR_PATH = 'classes/interceptors/';
	const STYLE_PATH = 'css/';
	const TEMPLATE_PATH = 'templates/';
	const TEMPLATE_COMPILE_PATH = 'templates_c/';
	const TEMPLATE_CACHE_PATH = 'cache/';
	const TEMPLATE_CONFIG = 'templates.cfg';
	
	const DEFAULT_DATE_FORMAT = 'd F Y';
	const DEFAULT_DATETIME_FORMAT = 'd F Y H:i:s';
	const DEFAULT_FORMAL_DATE_FORMAT = 'Y-m-d';
	const DEFAULT_FORMAL_DATETIME_FORMAT = 'Y-m-d H:i:s';
	const DEFAULT_CLOCK_FORMAT = '\'M\',d,Y,H,i,s';
	
	const SMTP_HOST = '';
	const SMTP_PORT = '25';
	const SMTP_USER = '';
	const SMTP_PASSWORD = '';

	const SESSION_LANGUAGE = 'sLanguage';
    const SESSION_ADMIN_LOGIN = 'oLoginAdmin';
    const SESSION_USER_LOGIN = 'oLoginUser';
	const SESSION_LOGIN_TIME = 'sLoginTime';    
    const SESSION_ROW = 'iRow';
    const SESSION_COUPON = 'sCoupon';
    const SESSION_COUNTRY = 'sCountry';
	const SESSION_DOMAIN = 'sDomain';
    const SESSION_SHOPPING_CART = 'aShoppingCart';
	const SESSION_SHOPPING_CART_INTERNAL = 'aShoppingCartInternal';
	const SESSION_ORDER = 'oOrderHeader';
        
	const RECAPTCHA_PUBLIC_KEY = '6Le6T8USAAAAAETSia8Jkj9-5kKuxi1H83sbnSWU';
	const RECAPTCHA_PRIVATE_KEY = '6Le6T8USAAAAAHuOT-bBxn9C12H8_kpRLUVe_kt2';
    
	const CONFIG_WEB = 'www';
	const CONFIG_COUNTER = 'counter';
	const CONFIG_TEMPLATE = 'template';
	
	const CONFIG_PAYPAL_API_USERNAME_VALUE = 'micro_1280310890_biz_api1.purnawan.net';	
	const CONFIG_PAYPAL_API_PASSWORD_VALUE = '1280310895';
	const CONFIG_PAYPAL_API_SIGNATURE_VALUE = 'AlcepCgVxsnh.thSFQh4YMDVFyJ6ARJ3ntKhzKqsEEmxT9duys8OGcxN';
	const CONFIG_PAYPAL_RETURN_URL = '/checkout';
	const CONFIG_PAYPAL_CANCEL_URL = '/shopping-cart';
	const PAYPAL_API_END_POINT = 'https://api-3t.paypal.com/nvp';
	const PAYPAL_URL = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
	const SANDBOX_PAYPAL_API_END_POINT = 'https://api-3t.sandbox.paypal.com/nvp';
	const SANDBOX_PAYPAL_URL = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=';
	
	public function get($sKey,&$var)
	{
		eval('$var = Attributes::'.$sKey.';');
	}
	
	public function getValue($sKey)
	{
		eval('$value = Attributes::'.$sKey.';');
		
		return $value;
	}
}
?>
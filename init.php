<?php
include(BASE_PATH.'constants.php');
include_once(BASE_PATH.'classes/core/Attributes.php');

//error_reporting(E_ALL);

date_default_timezone_set('Asia/Jakarta');
ini_set('memory_limit','100M');
if (get_magic_quotes_gpc()) {
   function stripslashes_deep($value)
   {
       $value = is_array($value) ?
                   array_map('stripslashes_deep', $value) :
                   stripslashes($value);

       return $value;
   }

   $_POST = array_map('stripslashes_deep', $_POST);
   $_GET = array_map('stripslashes_deep', $_GET);
   $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
   $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

set_include_path(
	"." . PATH_SEPARATOR .
	$_SERVER['DOCUMENT_ROOT'] . PATH_SEPARATOR .
	Attributes::CLASS_PATH . PATH_SEPARATOR .
	Attributes::CORE_CLASS_PATH . PATH_SEPARATOR .
	Attributes::ADDITIONAL_CLASS_PATH . PATH_SEPARATOR
);

?>
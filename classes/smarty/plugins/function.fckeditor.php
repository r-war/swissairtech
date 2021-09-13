<?php
include_once BASE_PATH . Attributes::CORE_CLASS_PATH . 'FCKeditor.php';

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

include_once(Attributes::CORE_CLASS_PATH.'FCKeditor.php');

function smarty_function_fckeditor($params, &$smarty)
{
// 	require_once $smarty->_get_plugin_filepath('function','val');
	$oFCKeditor = new FCKeditor($params['name']);
	
	$oFCKeditor->ToolbarSet = isset($params['toolbar']) ? $params['toolbar'] : 'Basic';
	$oFCKeditor->Height = isset($params['height']) ? $params['height'] : 200;	
	$oFCKeditor->Value = $params['value'];
	$oFCKeditor->customConfig = isset($params['customConfig']) ? $params['customConfig'] : 'config.js';

	return $oFCKeditor->CreateHtml();
	
// 	$aParam['k'] = $params['name'];
// 	$aParam['parsehtml'] = false;
// 	$aParam['parsequote'] = false;
// 	$oFCKeditor->Value = smarty_function_val($aParam,$smarty);
}

/* vim: set expandtab: */

?>
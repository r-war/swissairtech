<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_loc($params, &$smarty)
{
	$oLocTool = LocaleTool::getInstance();
	
	$sValue = $oLocTool->get($params['k']);
	
	if(isset($params['assign']))
	{
		$smarty->assign($params['assign'],$sValue);
	}
	else 
	{
		return $sValue;
	}
}

/* vim: set expandtab: */

?>

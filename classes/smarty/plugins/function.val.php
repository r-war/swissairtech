<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_val($params, &$smarty)
{
	$sKey = $params['k'];
	if($sKey != null)
	{
		$aTemp = explode('-',$sKey);
		
		$aTemp2 = explode('_',$aTemp[1]);
		
		foreach ($aTemp2 as $idx => $sWord)
		{
			$aTemp2[$idx] = ucwords($sWord);
		}
		
		$sMethod = 'get'.ucfirst(implode($aTemp2));
		
		if(count($aTemp) == 2)
		{
			$oObj = $smarty->get_template_vars($aTemp[0]);
			if(is_object($oObj) && method_exists($oObj,$sMethod))
			{
				$sValue = call_user_func(array($oObj,$sMethod));
			}
		}
		else 
		{
			$oData = $smarty->get_template_vars('oData');
			$sValue = $oData->get($sKey);
		}
	}
	else
	{
		$sValue = $params['v'];
	}

	if($params['parsequote'] == true)
	{
		$sValue = addslashes($sValue);
	}
	
	if(!isset($params['parsehtml']) || $params['parsehtml'] == true)
	{
		$sValue = htmlentities($sValue);
	}
	
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

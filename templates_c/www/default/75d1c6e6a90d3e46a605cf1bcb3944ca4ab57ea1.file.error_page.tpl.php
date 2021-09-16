<?php /* Smarty version Smarty-3.1.8, created on 2021-09-16 17:02:30
         compiled from "templates/www/default\core\error_page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26691614316364ec9c7-82818436%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '75d1c6e6a90d3e46a605cf1bcb3944ca4ab57ea1' => 
    array (
      0 => 'templates/www/default\\core\\error_page.tpl',
      1 => 1527250300,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26691614316364ec9c7-82818436',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sExceptionMessage' => 0,
    'oAttributes' => 0,
    'sExceptionStackTrace' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_61431636c89b48_70646091',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61431636c89b48_70646091')) {function content_61431636c89b48_70646091($_smarty_tpl) {?><table width="100%"  border="0" cellspacing="0" cellpadding="0" style="height:100%">
<tr>
	<td align="center" valign="top">
	<br style="height:20px"/>
	<div class="errorBack" style="margin:10px">
	<table cellpadding="3" cellspacing="0" border="0" width="100%">
	<tr>
		<td style="border-bottom-color: #ECECEC;color: #000; border-bottom-style: solid; border-bottom-width: 1px;" valign="top" align="center">
		<?php echo $_smarty_tpl->tpl_vars['sExceptionMessage']->value;?>

		</td>
	</tr>
	<?php if ($_smarty_tpl->tpl_vars['oAttributes']->value->getValue('TESTING')==true){?>
	<tr>
		<td style="color: #000;">
		<?php echo nl2br($_smarty_tpl->tpl_vars['sExceptionStackTrace']->value);?>

		</td>
	</tr>
	<?php }?>
	</table>
	</div>
	</td>
</tr>
</table><?php }} ?>
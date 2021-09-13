<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 14:50:04
         compiled from "templates/cms-admin\LoginModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18662613f02acd55980-44097108%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae46b827cf00bf1209cf11d6936d29f9fc6a00c3' => 
    array (
      0 => 'templates/cms-admin\\LoginModule.tpl',
      1 => 1527250290,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18662613f02acd55980-44097108',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'oMod' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f02ace5d5e8_78104421',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f02ace5d5e8_78104421')) {function content_613f02ace5d5e8_78104421($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
?><form class="form-horizontal" method="post" action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getBasePage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
">
	<fieldset>
		<legend>
			Please login first !
		</legend>
		<div class="control-group">
			<label for="username" class="control-label"><?php echo smarty_function_loc(array('k'=>'username'),$_smarty_tpl);?>
</label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="username" id="username"/>
			</div>
		</div>
		<div class="control-group">
			<label for="password" class="control-label"><?php echo smarty_function_loc(array('k'=>'password'),$_smarty_tpl);?>
</label>
			<div class="controls">
				<input type="password" class="input-xlarge" name="password" id="password"/>
			</div>
		</div>
		<div class="form-actions">
			<button class="btn btn-primary" type="submit" name="login" value="1">
				<?php echo smarty_function_loc(array('k'=>'login'),$_smarty_tpl);?>

			</button>
		</div>
	</fieldset>
</form><?php }} ?>
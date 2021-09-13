<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 14:50:12
         compiled from "templates/cms-admin\layout\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:32245613f02b42545c2-24775262%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '332657832e7bcf31a998ddcf97468771620b56bb' => 
    array (
      0 => 'templates/cms-admin\\layout\\default.tpl',
      1 => 1527250298,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32245613f02b42545c2-24775262',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'oMod' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f02b436a3f7_43345259',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f02b436a3f7_43345259')) {function content_613f02b436a3f7_43345259($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('core/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="container" style="min-height: 500px;">
	<div class="row-fluid">
		
		<div class="modal fade" id="myForm"></div>
		<?php echo $_smarty_tpl->getSubTemplate ("core/feedback.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('source'=>$_smarty_tpl->tpl_vars['oMod']->value->getModule()), 0);?>

		<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['oMod']->value->getTemplateName(), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div>
</div>
<hr>
<?php echo $_smarty_tpl->getSubTemplate ('core/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>
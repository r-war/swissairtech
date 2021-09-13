<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 14:50:04
         compiled from "templates/cms-admin\core\feedback.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2881613f02ac6ded97-22828391%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81655a3a91de7bb55a175fded2e23f9015de3c5c' => 
    array (
      0 => 'templates/cms-admin\\core\\feedback.tpl',
      1 => 1527250294,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2881613f02ac6ded97-22828391',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'source' => 0,
    'info_messages' => 0,
    'idx' => 0,
    'message' => 0,
    'error_messages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f02ac9823c9_20374620',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f02ac9823c9_20374620')) {function content_613f02ac9823c9_20374620($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['info_messages']->value[$_smarty_tpl->tpl_vars['source']->value])&&is_array($_smarty_tpl->tpl_vars['info_messages']->value[$_smarty_tpl->tpl_vars['source']->value])&&count($_smarty_tpl->tpl_vars['info_messages']->value[$_smarty_tpl->tpl_vars['source']->value])>0){?>
<div class="alert alert-info">
	<a class="close" data-dismiss="alert" href="#">&times;</a>
	<h4 class="alert-heading"><i class="icon-ok-circle"></i> Success !</h4>
	<?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['message']->_loop = false;
 $_smarty_tpl->tpl_vars['idx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['info_messages']->value[$_smarty_tpl->tpl_vars['source']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value){
$_smarty_tpl->tpl_vars['message']->_loop = true;
 $_smarty_tpl->tpl_vars['idx']->value = $_smarty_tpl->tpl_vars['message']->key;
?>
		<?php if ($_smarty_tpl->tpl_vars['idx']->value>0){?><br/><?php }?><?php echo $_smarty_tpl->tpl_vars['message']->value;?>

	<?php } ?>
</div>
<?php }?>
<?php if (((isset($_smarty_tpl->tpl_vars['info_messages']->value[$_smarty_tpl->tpl_vars['source']->value])&&is_array($_smarty_tpl->tpl_vars['info_messages']->value[$_smarty_tpl->tpl_vars['source']->value])&&count($_smarty_tpl->tpl_vars['info_messages']->value[$_smarty_tpl->tpl_vars['source']->value])>0)&&isset($_smarty_tpl->tpl_vars['error_messages']->value[$_smarty_tpl->tpl_vars['source']->value])&&is_array($_smarty_tpl->tpl_vars['error_messages']->value[$_smarty_tpl->tpl_vars['source']->value])&&count($_smarty_tpl->tpl_vars['error_messages']->value[$_smarty_tpl->tpl_vars['source']->value])>0)){?>
<br/>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['error_messages']->value[$_smarty_tpl->tpl_vars['source']->value])&&is_array($_smarty_tpl->tpl_vars['error_messages']->value[$_smarty_tpl->tpl_vars['source']->value])&&count($_smarty_tpl->tpl_vars['error_messages']->value[$_smarty_tpl->tpl_vars['source']->value])>0){?>
<div class="alert alert-error">
	<a class="close" data-dismiss="alert" href="#">&times;</a>
	<h4 class="alert-heading"><i class="icon-exclamation-sign"></i> Error !</h4>
	<?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['message']->_loop = false;
 $_smarty_tpl->tpl_vars['idx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['error_messages']->value[$_smarty_tpl->tpl_vars['source']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value){
$_smarty_tpl->tpl_vars['message']->_loop = true;
 $_smarty_tpl->tpl_vars['idx']->value = $_smarty_tpl->tpl_vars['message']->key;
?>
		<?php if ($_smarty_tpl->tpl_vars['idx']->value>0){?><br/><?php }?><?php echo $_smarty_tpl->tpl_vars['message']->value;?>

	<?php } ?>
</div>
<?php }?><?php }} ?>
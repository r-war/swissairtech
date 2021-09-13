<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 14:27:21
         compiled from "templates/www/default\layout\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21311613efd593eb9e5-34613959%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a93eb856d51fe41f95addc301c9fbd21debfb028' => 
    array (
      0 => 'templates/www/default\\layout\\default.tpl',
      1 => 1527250306,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21311613efd593eb9e5-34613959',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'aConfig' => 0,
    'oMod' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613efd5b4d8396_37477000',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613efd5b4d8396_37477000')) {function content_613efd5b4d8396_37477000($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['aConfig']->value['web_maintenance']==1){?>
	<?php echo $_smarty_tpl->getSubTemplate ('layout/maintenance.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
  <?php echo $_smarty_tpl->getSubTemplate ('core/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['oMod']->value->getTemplateName(), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  <?php echo $_smarty_tpl->getSubTemplate ('core/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
<?php }} ?>
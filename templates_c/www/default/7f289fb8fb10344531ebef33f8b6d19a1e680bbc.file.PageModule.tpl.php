<?php /* Smarty version Smarty-3.1.8, created on 2021-09-14 17:58:41
         compiled from "templates/www/default\PageModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:879261407918915893-65570585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f289fb8fb10344531ebef33f8b6d19a1e680bbc' => 
    array (
      0 => 'templates/www/default\\PageModule.tpl',
      1 => 1631617101,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '879261407918915893-65570585',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_61407918c2c758_69168620',
  'variables' => 
  array (
    'page' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61407918c2c758_69168620')) {function content_61407918c2c758_69168620($_smarty_tpl) {?>	<!-- Limo Car Breatcume -->
	<div class="background-img text-center text-uppercase">
		<img src="<?php echo $_smarty_tpl->tpl_vars['page']->value->getPictureUrl();?>
" class="img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['page']->value->getPicture();?>
">
		<div class="overlay"></div>
		<h2 class="background-text"><?php echo $_smarty_tpl->tpl_vars['page']->value->getName();?>
</h2>
	</div>
	<!-- End of Limo Car Breatcume -->

<?php echo $_smarty_tpl->tpl_vars['page']->value->getDescription();?>
<?php }} ?>
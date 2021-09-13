<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 15:52:28
         compiled from "templates/www/default\core\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18282613efd61045e21-54256172%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f3be00f86b234f2a1c31c1d8b7348380bd1af5a' => 
    array (
      0 => 'templates/www/default\\core\\footer.tpl',
      1 => 1631523146,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18282613efd61045e21-54256172',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613efd613dd6d0_21966498',
  'variables' => 
  array (
    'aConfig' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613efd613dd6d0_21966498')) {function content_613efd613dd6d0_21966498($_smarty_tpl) {?>

<!-- /#guys -->
	<section id="guys" class="guys-section section-padding text-center">
		<div class="container">
			<div class="section-head">
                <?php echo $_smarty_tpl->tpl_vars['aConfig']->value['contact'];?>

			</div>
			<div class="social-btn">
                <?php echo $_smarty_tpl->tpl_vars['aConfig']->value['social'];?>

				
			</div>
		</div>
	</section>
	<!-- /#guys -->


	<!-- Js Functions  for Menu -->
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
vendor/jquery-2.1.4.min.js"></script>
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
owl.carousel.min.js"></script>
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
isotope.pkgd.min.js"></script>
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
bootstrap.min.js"></script>
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
menuzord.js"></script>
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
wow.min.js"></script>
	<!-- Js Custom Functions File -->
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
main.js"></script>
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
custom.menu-home.min.js"></script>
	<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
custom.menu-main.min.js"></script>

	<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
	<script type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
/jquery.tools.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
/jquery.revolution.min.js"></script>
    <?php echo $_smarty_tpl->tpl_vars['aConfig']->value['custom_script'];?>

</body>

</html><?php }} ?>
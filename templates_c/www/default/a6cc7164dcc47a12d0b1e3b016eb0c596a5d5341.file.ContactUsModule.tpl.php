<?php /* Smarty version Smarty-3.1.8, created on 2021-09-14 17:26:39
         compiled from "templates/www/default\ContactUsModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30403614078887c69b9-74090484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6cc7164dcc47a12d0b1e3b016eb0c596a5d5341' => 
    array (
      0 => 'templates/www/default\\ContactUsModule.tpl',
      1 => 1631615196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30403614078887c69b9-74090484',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_614078889ff970_04492064',
  'variables' => 
  array (
    'aConfig' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_614078889ff970_04492064')) {function content_614078889ff970_04492064($_smarty_tpl) {?>	<!-- Google Map -->
	<div id="google-map">
		<div class="map-container">
			<div id="googleMaps" class="google-map-container">
				<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['contact_map'];?>

			</div>
		</div><!-- /.map-container -->
	</div><!-- /#google-map-->
	<!-- Google Map end --><?php }} ?>
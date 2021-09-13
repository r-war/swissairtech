<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 14:59:50
         compiled from "templates/cms-admin\core\add_search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6658613f04f668db50-35410574%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f9f8709399f1e9698cd407beddbdb41753fc960a' => 
    array (
      0 => 'templates/cms-admin\\core\\add_search.tpl',
      1 => 1527250294,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6658613f04f668db50-35410574',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'oMod' => 0,
    'bHideAdd' => 0,
    'bDownload' => 0,
    'bUploadFile' => 0,
    'oParam' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f04f6833571_75392529',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f04f6833571_75392529')) {function content_613f04f6833571_75392529($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
?><form action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
" method="POST" class="nomargin" id="formSearch" enctype="multipart/form-data">
<div class="row-fluid">
	<div class="span8">
		<?php if (!$_smarty_tpl->tpl_vars['bHideAdd']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
" role="button" class="btn btn-info" data-toggle="modal" data-target="#myForm"><i class="icon-plus"></i> <?php echo smarty_function_loc(array('k'=>'add_new'),$_smarty_tpl);?>
</a><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['bDownload']->value){?><a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getCurrentPage();?>
?&dl=1" role="button" class="btn btn-info" target="_blank"><i class="icon-download-alt"></i> <?php echo smarty_function_loc(array('k'=>'download_all_data'),$_smarty_tpl);?>
</a><?php }?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
" role="button" class="btn" title="Refresh List"><i class="icon-refresh"></i></a>
		<?php if ($_smarty_tpl->tpl_vars['bUploadFile']->value){?><input type="file" name="uploadfile"><input type="submit" class="btn" value="Import"/> <?php }?>
	</div>
	<div class="span4">
		<label class="pull-right input-prepend input-append">
			<span class="add-on"><i class="icon-search"></i></span>
			<input type="text" name="keywords" id="keywords" value="<?php echo $_smarty_tpl->tpl_vars['oParam']->value->get('keywords');?>
" placeholder="Type keywords then enter">
			<?php if ($_smarty_tpl->tpl_vars['oParam']->value->get('keywords')!=''){?><span class="add-on" onclick="clearForm(); return false;"><i class="icon-remove"></i></span><?php }?>
		</label>
	</div>
</div>
</form><?php }} ?>
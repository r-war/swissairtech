<?php /* Smarty version Smarty-3.1.8, created on 2021-09-14 17:56:12
         compiled from "templates/cms-admin\ajax\PageModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2938161407fccdae467-92248670%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7801b571d9f97ad74fb52155369f5cc350f1e654' => 
    array (
      0 => 'templates/cms-admin\\ajax\\PageModule.tpl',
      1 => 1527501776,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2938161407fccdae467-92248670',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sAjax' => 0,
    'oMod' => 0,
    'oPage' => 0,
    'sUri' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_61407fcd1c8b82_31677125',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61407fcd1c8b82_31677125')) {function content_61407fcd1c8b82_31677125($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
if (!is_callable('smarty_function_fckeditor')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.fckeditor.php';
if (!is_callable('smarty_function_val')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.val.php';
?><?php if ($_smarty_tpl->tpl_vars['sAjax']->value=='form'){?>
	<form id="form" action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),('select=').($_smarty_tpl->tpl_vars['oPage']->value->getPrimaryKey()));?>
" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel"><?php echo smarty_function_loc(array('k'=>'form'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['oMod']->value->getName();?>
</h3>
	</div>
	<div class="modal-body">
	<?php echo $_smarty_tpl->getSubTemplate ("core/feedback.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('source'=>$_smarty_tpl->tpl_vars['oMod']->value->getModule()), 0);?>

		<div class="form-unit form-horizontal">
		   <?php if (!$_smarty_tpl->tpl_vars['oPage']->value->isNew()){?>
		    <div class="control-group">
		     <label class="control-label" for="code"><?php echo smarty_function_loc(array('k'=>'url'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		     	<div class="input-prepend input-append">
					<span class="add-on"><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getBaseDomain();?>
<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getBasePage('Page',null,true);?>
/</span><input type="text" class="input-large" value="<?php echo $_smarty_tpl->tpl_vars['oPage']->value->getCode();?>
" name="oPage-code" id="code" /><span class="add-on">.html</span>
				</div>
		     </div>
		   </div>
		   <?php }?>
		   <div class="control-group">
		     <label class="control-label" for="name"><?php echo smarty_function_loc(array('k'=>'name'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <input type="text" name="oPage-name" id="name" value="<?php echo $_smarty_tpl->tpl_vars['oPage']->value->getName('en');?>
" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="description"><?php echo smarty_function_loc(array('k'=>'description'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescription" value="1"/>
		       <?php echo smarty_function_fckeditor(array('name'=>'description','value'=>$_smarty_tpl->tpl_vars['oPage']->value->getDescription('en')),$_smarty_tpl);?>

		     </div>
		   </div>
		   
		   <div class="control-group">
		     <label class="control-label">Picture Banner
		     	<a href="#" data-toggle="tooltip" title="" data-original-title="Make sure size is fitted enough within the area used on this image (970px x 200px)" class="help"><i class="icon-question-sign"></i></a>
		     </label>
		     <div class="controls">
		       <input type="file" class="" name="picture" id="picture"/>
		       <span class="help-inline" style="margin-left: 50px"><a href="<?php echo $_smarty_tpl->tpl_vars['oPage']->value->getPictureUrl();?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['oPage']->value->getPicture();?>
</a></span>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="<?php echo smarty_function_loc(array('k'=>'save'),$_smarty_tpl);?>
" class="btn btn-primary"/>
		<?php if (!$_smarty_tpl->tpl_vars['oPage']->value->isNew()){?><input name="delete" type="button" value="<?php echo smarty_function_loc(array('k'=>'delete'),$_smarty_tpl);?>
" class="btn btn-danger" onclick="doDelete('<?php echo $_smarty_tpl->tpl_vars['oPage']->value->getPrimaryKey();?>
','<?php echo smarty_function_val(array('v'=>$_smarty_tpl->tpl_vars['oPage']->value->getName(),'parsequote'=>true),$_smarty_tpl);?>
')"/><?php }?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['sUri']->value;?>
" class="btn">Close</a><br />
	</div>
	</form>
<?php }?><?php }} ?>
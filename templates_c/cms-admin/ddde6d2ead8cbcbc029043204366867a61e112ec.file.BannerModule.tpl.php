<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 17:09:57
         compiled from "templates/cms-admin\ajax\BannerModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24887613f23758f8ce3-82905323%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ddde6d2ead8cbcbc029043204366867a61e112ec' => 
    array (
      0 => 'templates/cms-admin\\ajax\\BannerModule.tpl',
      1 => 1527250292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24887613f23758f8ce3-82905323',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sAjax' => 0,
    'oMod' => 0,
    'oBanner' => 0,
    'sUri' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f2375d771a9_14585514',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f2375d771a9_14585514')) {function content_613f2375d771a9_14585514($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
if (!is_callable('smarty_function_val')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.val.php';
?><?php if ($_smarty_tpl->tpl_vars['sAjax']->value=='form'){?>
	<form id="form" action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),('select=').($_smarty_tpl->tpl_vars['oBanner']->value->getPrimaryKey()));?>
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
		  <div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'index'),$_smarty_tpl);?>

		     	<a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo smarty_function_loc(array('k'=>'index_desc'),$_smarty_tpl);?>
" class="help"><i class="icon-question-sign"></i></a>
		 	 </label>
		     <div class="controls">
		       <input type="text" name="oBanner-index" value="<?php echo $_smarty_tpl->tpl_vars['oBanner']->value->getIndex();?>
" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'picture'),$_smarty_tpl);?>

		     	<a href="#" data-toggle="tooltip" title="" data-original-title="Make sure size is fitted enough within the area used on this image" class="help"><i class="icon-question-sign"></i></a>
		     </label>
		     <div class="controls">
		       <input type="file" class="" name="picture" id="picture"/>
		       <span class="help-inline" style="margin-left: 50px"><a href="<?php echo $_smarty_tpl->tpl_vars['oBanner']->value->getPictureUrl();?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['oBanner']->value->getPicture();?>
</a></span>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">&nbsp;</label>
		     <div class="controls">
		       <span class="help-inline">
		       	<?php if ($_GET['mode']=='sliding'){?>
			       	Recommended image width size is 1920 pixel.
			    	<?php }else{ ?>   	
			       	Recommended Image width size is 940 pixel.
			    	<?php }?>
		       	</span>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'url'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <input type="text" class="span12" name="oBanner-url" value="<?php echo $_smarty_tpl->tpl_vars['oBanner']->value->getUrl();?>
" />
           
		     </div>
		   </div>
			<div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'name'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <input type="text" name="oBanner-name" value="<?php echo $_smarty_tpl->tpl_vars['oBanner']->value->getName();?>
" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'description'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		     	<input type="text" name="oBanner-description" value="<?php echo $_smarty_tpl->tpl_vars['oBanner']->value->getDescription();?>
" class="span12"/>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="<?php echo smarty_function_loc(array('k'=>'save'),$_smarty_tpl);?>
" class="btn btn-primary"/>
		<?php if (!$_smarty_tpl->tpl_vars['oBanner']->value->isNew()){?><input name="delete" type="button" value="<?php echo smarty_function_loc(array('k'=>'delete'),$_smarty_tpl);?>
" class="btn btn-danger" onclick="doDelete('<?php echo $_smarty_tpl->tpl_vars['oBanner']->value->getPrimaryKey();?>
','<?php echo smarty_function_val(array('v'=>$_smarty_tpl->tpl_vars['oBanner']->value->getPicture(),'parsequote'=>true),$_smarty_tpl);?>
')"/><?php }?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['sUri']->value;?>
" class="btn">Close</a>
	</div>
	</form>
<?php }?><?php }} ?>
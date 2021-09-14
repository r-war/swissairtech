<?php /* Smarty version Smarty-3.1.8, created on 2021-09-14 17:12:25
         compiled from "templates/cms-admin\ajax\NewsModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:160476140019e016b23-77715435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fabde0a92d02037c5e5ed0b1084ba496ac264eef' => 
    array (
      0 => 'templates/cms-admin\\ajax\\NewsModule.tpl',
      1 => 1631613933,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160476140019e016b23-77715435',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_6140019e3e3db0_74708068',
  'variables' => 
  array (
    'sAjax' => 0,
    'oNews' => 0,
    'oMod' => 0,
    'sUrl' => 0,
    'sUri' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6140019e3e3db0_74708068')) {function content_6140019e3e3db0_74708068($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
if (!is_callable('smarty_function_fckeditor')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.fckeditor.php';
if (!is_callable('smarty_function_val')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.val.php';
?><?php if ($_smarty_tpl->tpl_vars['sAjax']->value=='form'){?>
	<script type="text/javascript">
	
	jQuery(document).ready(function () {
		$('#date').simpleDatepicker();
	});
	
	</script>
	<?php $_smarty_tpl->tpl_vars['sUrl'] = new Smarty_variable(('select=').($_smarty_tpl->tpl_vars['oNews']->value->getPrimaryKey()), null, 0);?>
	<form id="form" action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['sUrl']->value);?>
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
		   
		   
		   <?php if ($_GET['mode']=='sliding'){?>
		   	<div class="control-group">
		     <label class="control-label" for="name">Heading 1</label>
		     <div class="controls">
		       <input type="text" name="oNews-name" id="name" value="<?php echo $_smarty_tpl->tpl_vars['oNews']->value->getName();?>
" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="shortdescription">Sub Heading</label>
		     <div class="controls">
		       <input type="text" name="shortDescription" id="shortdescription" value="<?php echo $_smarty_tpl->tpl_vars['oNews']->value->getShortDescription();?>
" class="span12"/>
			</div>
		   </div>	
		   <div class="control-group">
		     <label class="control-label" for="description">description</label>
		     <div class="controls">
		       <input type="text" name="description" id="description" value="<?php echo $_smarty_tpl->tpl_vars['oNews']->value->getDescription();?>
" class="span12"/>
		     </div>
		   <?php }else{ ?>
		   <?php if ($_GET['mode']!='Products'){?>
		   	<div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'date'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <input type="text" name="oNews-date" value="<?php echo $_smarty_tpl->tpl_vars['oNews']->value->getDate('m/d/Y');?>
" id="date"/>
		     </div>
		   </div>
		   <?php }?>
		   <div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'picture'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <input type="file" name="file" />
		       <span class="help-inline" style="margin-left: 50px"><a href="<?php echo $_smarty_tpl->tpl_vars['oNews']->value->getPictureUrl();?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['oNews']->value->getPicture();?>
</a></span>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name"><?php echo smarty_function_loc(array('k'=>'name'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <input type="text" name="oNews-name" id="name" value="<?php echo $_smarty_tpl->tpl_vars['oNews']->value->getName();?>
" class="span12"/>
		     </div>
		   </div>
			<?php if ($_GET['mode']!='Products'){?>
		   <div class="control-group">
		     <label class="control-label" for="shortdescription"><?php echo smarty_function_loc(array('k'=>'shortDescription'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		     <input type="hidden" id="fixShortDescription" value="1"/>
		       <?php echo smarty_function_fckeditor(array('name'=>'shortDescription','value'=>$_smarty_tpl->tpl_vars['oNews']->value->getShortDescription()),$_smarty_tpl);?>

		     </div>
		   </div>
		   <?php }?>	
		   <div class="control-group">
		     <label class="control-label" for="description"><?php echo smarty_function_loc(array('k'=>'description'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescription" value="1"/>
		       <?php echo smarty_function_fckeditor(array('name'=>'description','value'=>$_smarty_tpl->tpl_vars['oNews']->value->getDescription()),$_smarty_tpl);?>

		     </div>
		   </div>		   
		   <?php }?>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="oNews-type" value="<?php echo $_GET['mode'];?>
">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="<?php echo smarty_function_loc(array('k'=>'save'),$_smarty_tpl);?>
" class="btn btn-primary"/>
		<input name="delete" type="button" value="<?php echo smarty_function_loc(array('k'=>'delete'),$_smarty_tpl);?>
" class="btn btn-danger" onclick="doDelete('<?php echo $_smarty_tpl->tpl_vars['oNews']->value->getPrimaryKey();?>
','<?php echo smarty_function_val(array('v'=>$_smarty_tpl->tpl_vars['oNews']->value->getName(),'parsequote'=>true),$_smarty_tpl);?>
')"/>
		<a href="<?php echo $_smarty_tpl->tpl_vars['sUri']->value;?>
" class="btn">Close</a>
	</div>
	</form>
<?php }?><?php }} ?>
<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 14:50:14
         compiled from "templates/cms-admin\ContentModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8699613f02b6649995-63884596%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b099f05a76b059a3f6f60a9184a9b7160fa20b7' => 
    array (
      0 => 'templates/cms-admin\\ContentModule.tpl',
      1 => 1527250290,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8699613f02b6649995-63884596',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'oMod' => 0,
    'sSelectKey' => 0,
    'aKey' => 0,
    'sKey' => 0,
    'sName' => 0,
    'oConfiguration' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f02b692bc62_06425993',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f02b692bc62_06425993')) {function content_613f02b692bc62_06425993($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
if (!is_callable('smarty_function_fckeditor')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.fckeditor.php';
?><script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
<div class="form-unit">
<form action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
?&key=<?php echo $_smarty_tpl->tpl_vars['sSelectKey']->value;?>
" method="POST" class="form-horizontal">
 <fieldset>
 <legend><?php echo smarty_function_loc(array('k'=>'form'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['oMod']->value->getName();?>
</legend>
   <div class="control-group">
     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'name'),$_smarty_tpl);?>
</label>
     <div class="controls">
		<select onchange="redirect(this.value);" class="span12">
			<?php  $_smarty_tpl->tpl_vars['sName'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sName']->_loop = false;
 $_smarty_tpl->tpl_vars['sKey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['aKey']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sName']->key => $_smarty_tpl->tpl_vars['sName']->value){
$_smarty_tpl->tpl_vars['sName']->_loop = true;
 $_smarty_tpl->tpl_vars['sKey']->value = $_smarty_tpl->tpl_vars['sName']->key;
?>
				<option <?php if ($_smarty_tpl->tpl_vars['sKey']->value==$_GET['key']){?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
?&key=<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['sName']->value;?>
</option>
			<?php } ?>
		</select>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'description'),$_smarty_tpl);?>
</label>
     <div class="controls">
       <?php echo smarty_function_fckeditor(array('name'=>'description','value'=>$_smarty_tpl->tpl_vars['oConfiguration']->value->getValue()),$_smarty_tpl);?>

     </div>
   </div>
   <div class="form-actions">
		<input type="submit" name="save" value="<?php echo smarty_function_loc(array('k'=>'save'),$_smarty_tpl);?>
" class="btn btn-primary"/>
     	<input name="cancel" type="button" value="<?php echo smarty_function_loc(array('k'=>'cancel'),$_smarty_tpl);?>
" class="btn" onclick="redirect('<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
')"/>
   </div>
 </fieldset>
</form>
</div><?php }} ?>
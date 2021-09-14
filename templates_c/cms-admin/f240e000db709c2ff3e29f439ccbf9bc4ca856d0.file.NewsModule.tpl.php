<?php /* Smarty version Smarty-3.1.8, created on 2021-09-14 08:45:39
         compiled from "templates/cms-admin\NewsModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9372613ffec39fb442-45308882%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f240e000db709c2ff3e29f439ccbf9bc4ca856d0' => 
    array (
      0 => 'templates/cms-admin\\NewsModule.tpl',
      1 => 1535430578,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9372613ffec39fb442-45308882',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'oMod' => 0,
    '_sortable' => 0,
    'aNews' => 0,
    'oObj' => 0,
    'sSelectUrl' => 0,
    '_pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613ffec460e9a7_95212650',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613ffec460e9a7_95212650')) {function content_613ffec460e9a7_95212650($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
if (!is_callable('smarty_function_val')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.val.php';
?><script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
<?php echo $_smarty_tpl->getSubTemplate ("core/add_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<form name="theForm" action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	<th><?php echo smarty_function_loc(array('k'=>'date'),$_smarty_tpl);?>
</th>
	<?php echo $_smarty_tpl->getSubTemplate ('core/sortable.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'name','field'=>'page.NAME','oSortable'=>$_smarty_tpl->tpl_vars['_sortable']->value), 0);?>

	
	
	<th width="200px"><?php echo smarty_function_loc(array('k'=>'options'),$_smarty_tpl);?>
</th>
</tr>
</thead>
<?php  $_smarty_tpl->tpl_vars['oObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['oObj']->_loop = false;
 $_smarty_tpl->tpl_vars['idx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['aNews']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['oObj']->key => $_smarty_tpl->tpl_vars['oObj']->value){
$_smarty_tpl->tpl_vars['oObj']->_loop = true;
 $_smarty_tpl->tpl_vars['idx']->value = $_smarty_tpl->tpl_vars['oObj']->key;
?>
<?php $_smarty_tpl->tpl_vars['sSelectUrl'] = new Smarty_variable(('select=').($_smarty_tpl->tpl_vars['oObj']->value->getPrimaryKey()), null, 0);?>
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="<?php echo $_smarty_tpl->tpl_vars['oObj']->value->getPrimaryKey();?>
" id="c"/></td>
	<td><?php echo $_smarty_tpl->tpl_vars['oObj']->value->getDate('d M Y');?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['oObj']->value->getName();?>
</td>
	
	<td><a href="<?php echo $_smarty_tpl->tpl_vars['oObj']->value->getPictureUrl();?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['oObj']->value->getPicture();?>
</a></td>
	<td class="center">
		<a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['sSelectUrl']->value);?>
" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm"><?php echo smarty_function_loc(array('k'=>'edit'),$_smarty_tpl);?>
</a>
		
		<input name="delete_<?php echo $_smarty_tpl->tpl_vars['oObj']->value->getName();?>
" type="button" value="<?php echo smarty_function_loc(array('k'=>'delete'),$_smarty_tpl);?>
" class="btn btn-danger" onclick="doDelete('<?php echo $_smarty_tpl->tpl_vars['oObj']->value->getPrimaryKey();?>
','<?php echo smarty_function_val(array('v'=>$_smarty_tpl->tpl_vars['oObj']->value->getName(),'parsequote'=>true),$_smarty_tpl);?>
')"/>
	</td>
</tr>
<?php }
if (!$_smarty_tpl->tpl_vars['oObj']->_loop) {
?>
<tr>
	<td colspan="6" class="center">
	<?php echo smarty_function_loc(array('k'=>'no_data'),$_smarty_tpl);?>

	</td>
</tr>
<?php } ?>
<?php if (count($_smarty_tpl->tpl_vars['aNews']->value)>0){?>
<tr>
	<td colspan="5">
	<input type="submit" value="<?php echo smarty_function_loc(array('k'=>'delete_checked'),$_smarty_tpl);?>
" name="deleteChecked" class="btn" onclick="return confirm('<?php echo smarty_function_loc(array('k'=>'confirm_delete_checked'),$_smarty_tpl);?>
?');"/>
	</td>
</tr>
<?php }?>
</table>
<?php echo $_smarty_tpl->getSubTemplate ("core/page_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('oPager'=>$_smarty_tpl->tpl_vars['_pager']->value), 0);?>

</form><?php }} ?>
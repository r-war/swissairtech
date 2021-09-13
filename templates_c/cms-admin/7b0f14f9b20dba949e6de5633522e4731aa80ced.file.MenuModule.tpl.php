<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 15:01:14
         compiled from "templates/cms-admin\MenuModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16205613f04f4ddd0c4-25990177%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b0f14f9b20dba949e6de5633522e4731aa80ced' => 
    array (
      0 => 'templates/cms-admin\\MenuModule.tpl',
      1 => 1631520072,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16205613f04f4ddd0c4-25990177',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f04f5a56908_28019796',
  'variables' => 
  array (
    'oParentMenu' => 0,
    'oMod' => 0,
    'sMode' => 0,
    'oParent' => 0,
    'sUrl' => 0,
    '_sortable' => 0,
    'aMenu' => 0,
    'oObj' => 0,
    'sSelectUrl' => 0,
    '_pager' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f04f5a56908_28019796')) {function content_613f04f5a56908_28019796($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
if (!is_callable('smarty_function_val')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.val.php';
?><script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
<script src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
jquery.autocomplete.js" type="text/javascript"></script>
<script>

	function showMenuType()
	{
		var type = $('#menuType').val();
		$('#typeUrl').hide();
		$('#typePage').hide();
		$('#typeModule').hide();
		$('#typeCategory').hide();
		$('#typePromo').hide();
		
		if(type == 1) $('#typeUrl').show();
		else if(type == 2) $('#typePage').show();
		else if(type == 3) $('#typeModule').show();
		else if(type == 4) $('#typeCategory').show();
		else if(type == 5) $('#typePromo').show();
	}
	
	function showPageType()
	{
		var type = $('#pageType').val();
		$('#existingPage').hide();
		$('#newPage').hide();
		
		if(type == 1) $('#existingPage').show();
		else if(type == 2){
			$('#newPage').show();
			$('#pageName').val($('#menuName').val());
		} 
	}
	
</script>
<?php echo $_smarty_tpl->getSubTemplate ("core/add_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php if ($_smarty_tpl->tpl_vars['oParentMenu']->value instanceof Menu){?>
<div class="row-fluid">
	<ul class="breadcrumb" style="margin-bottom: 10px;">
    	<?php $_smarty_tpl->tpl_vars['sMode'] = new Smarty_variable(('mode=').($_GET['mode']), null, 0);?>
	    <li>
	    <a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getBasePage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['sMode']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getName();?>
</a> <span class="divider">/</span>
	    </li>
	    <?php $_smarty_tpl->tpl_vars['oParent'] = new Smarty_variable($_smarty_tpl->tpl_vars['oParentMenu']->value->getMenuRelatedByParentId(), null, 0);?>
	    <?php if ($_smarty_tpl->tpl_vars['oParent']->value instanceof Menu){?>
	    <?php $_smarty_tpl->tpl_vars['sUrl'] = new Smarty_variable((($_smarty_tpl->tpl_vars['sMode']->value).('&sub=')).($_smarty_tpl->tpl_vars['oParent']->value->getId()), null, 0);?>
	    <li>
	    <a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getBasePage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['sUrl']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['oParent']->value->getName();?>
</a> <span class="divider">/</span>
	    </li>
	    <?php }?>
	    <li class="active"><?php echo $_smarty_tpl->tpl_vars['oParentMenu']->value->getName();?>
</li>
    </ul>
</div>
<?php }?>
<form name="theForm" action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	<?php echo $_smarty_tpl->getSubTemplate ('core/sortable.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'#','field'=>'menu.INDEX','oSortable'=>$_smarty_tpl->tpl_vars['_sortable']->value), 0);?>

	<?php echo $_smarty_tpl->getSubTemplate ('core/sortable.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'name','field'=>'menu.NAME','oSortable'=>$_smarty_tpl->tpl_vars['_sortable']->value), 0);?>

	<?php echo $_smarty_tpl->getSubTemplate ('core/sortable.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'url','field'=>'menu.URL','oSortable'=>$_smarty_tpl->tpl_vars['_sortable']->value), 0);?>

	<th width="320px"><?php echo smarty_function_loc(array('k'=>'options'),$_smarty_tpl);?>
</th>
</tr>
</thead>
<?php  $_smarty_tpl->tpl_vars['oObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['oObj']->_loop = false;
 $_smarty_tpl->tpl_vars['idx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['aMenu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['oObj']->key => $_smarty_tpl->tpl_vars['oObj']->value){
$_smarty_tpl->tpl_vars['oObj']->_loop = true;
 $_smarty_tpl->tpl_vars['idx']->value = $_smarty_tpl->tpl_vars['oObj']->key;
?>
<?php $_smarty_tpl->tpl_vars['sSelectUrl'] = new Smarty_variable(('select=').($_smarty_tpl->tpl_vars['oObj']->value->getPrimaryKey()), null, 0);?>
<?php $_smarty_tpl->tpl_vars['sSubUrl'] = new Smarty_variable(('sub=').($_smarty_tpl->tpl_vars['oObj']->value->getPrimaryKey()), null, 0);?>
<?php $_smarty_tpl->tpl_vars['sBannerUrl'] = new Smarty_variable(('back=menu&mode=').($_smarty_tpl->tpl_vars['oObj']->value->getUrl($_smarty_tpl->tpl_vars['oMod']->value,'www',false)), null, 0);?>
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="<?php echo $_smarty_tpl->tpl_vars['oObj']->value->getPrimaryKey();?>
" id="c"/></td>
	<td><?php echo $_smarty_tpl->tpl_vars['oObj']->value->getIndex();?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['oObj']->value->getName();?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['oObj']->value->getUrl($_smarty_tpl->tpl_vars['oMod']->value,'www');?>
</td>
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
<?php if (count($_smarty_tpl->tpl_vars['aMenu']->value)>0){?>
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
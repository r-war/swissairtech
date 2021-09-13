<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 14:59:51
         compiled from "templates/cms-admin\core\page_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30032613f04f75a3812-57180381%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd56466ca0bb7cabceb0561f7e967151c195f5dc' => 
    array (
      0 => 'templates/cms-admin\\core\\page_list.tpl',
      1 => 1527250294,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30032613f04f75a3812-57180381',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'oPager' => 0,
    'sBaseUrl' => 0,
    'oMod' => 0,
    'iPage' => 0,
    'sPageURL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f04f7caaa31_48347848',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f04f7caaa31_48347848')) {function content_613f04f7caaa31_48347848($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
?><?php if ($_smarty_tpl->tpl_vars['oPager']->value instanceof PropelPager){?>
	<div class="pull-left">
		<?php echo smarty_function_loc(array('k'=>'displaying'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['oPager']->value->getStartRecord();?>
 <?php echo smarty_function_loc(array('k'=>'to'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['oPager']->value->getEndRecord();?>
 (<?php echo smarty_function_loc(array('k'=>'from'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['oPager']->value->getTotalRecordCount();?>
 <?php echo smarty_function_loc(array('k'=>'items'),$_smarty_tpl);?>
)
	</div>
	<div class="pagination pull-right" style="margin: 0px">
	    <ul>
	    	<?php if (!$_smarty_tpl->tpl_vars['oPager']->value->atFirstPage()){?>
				<li><a href="<?php if ($_smarty_tpl->tpl_vars['sBaseUrl']->value!=null){?><?php echo $_smarty_tpl->tpl_vars['sBaseUrl']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['oPager']->value->getFirstURL();?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['oPager']->value->getFirstURL());?>
<?php }?>" title="<?php echo smarty_function_loc(array('k'=>'first'),$_smarty_tpl);?>
">&laquo;</a></li> 
				<li><a href="<?php if ($_smarty_tpl->tpl_vars['sBaseUrl']->value!=null){?><?php echo $_smarty_tpl->tpl_vars['sBaseUrl']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['oPager']->value->getPrevURL();?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['oPager']->value->getPrevURL());?>
<?php }?>" title="<?php echo smarty_function_loc(array('k'=>'previous'),$_smarty_tpl);?>
">&lsaquo;</a></li>
			<?php }?>
		    <?php  $_smarty_tpl->tpl_vars['iPage'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['iPage']->_loop = false;
 $_smarty_tpl->tpl_vars['page_idx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['oPager']->value->getPrevLinks(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['iPage']->key => $_smarty_tpl->tpl_vars['iPage']->value){
$_smarty_tpl->tpl_vars['iPage']->_loop = true;
 $_smarty_tpl->tpl_vars['page_idx']->value = $_smarty_tpl->tpl_vars['iPage']->key;
?>
			<?php $_smarty_tpl->tpl_vars['sPageURL'] = new Smarty_variable((($_smarty_tpl->tpl_vars['oPager']->value->getPageKey()).('=')).($_smarty_tpl->tpl_vars['iPage']->value), null, 0);?>
			<li><a href="<?php if ($_smarty_tpl->tpl_vars['sBaseUrl']->value!=null){?><?php echo $_smarty_tpl->tpl_vars['sBaseUrl']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['sPageURL']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['sPageURL']->value);?>
<?php }?>"><?php echo $_smarty_tpl->tpl_vars['iPage']->value;?>
</a></li>
			<?php } ?>
			<li class="active"><a href="<?php if ($_smarty_tpl->tpl_vars['sBaseUrl']->value!=null){?><?php echo $_smarty_tpl->tpl_vars['sBaseUrl']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['oPager']->value->getPageURL();?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['oPager']->value->getPageURL());?>
<?php }?>"><b><?php echo $_smarty_tpl->tpl_vars['oPager']->value->getPage();?>
</b></a></li> 
			<?php  $_smarty_tpl->tpl_vars['iPage'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['iPage']->_loop = false;
 $_smarty_tpl->tpl_vars['page_idx'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['oPager']->value->getNextLinks(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['iPage']->key => $_smarty_tpl->tpl_vars['iPage']->value){
$_smarty_tpl->tpl_vars['iPage']->_loop = true;
 $_smarty_tpl->tpl_vars['page_idx']->value = $_smarty_tpl->tpl_vars['iPage']->key;
?>
			<?php $_smarty_tpl->tpl_vars['sPageURL'] = new Smarty_variable((($_smarty_tpl->tpl_vars['oPager']->value->getPageKey()).('=')).($_smarty_tpl->tpl_vars['iPage']->value), null, 0);?>
			<li><a href="<?php if ($_smarty_tpl->tpl_vars['sBaseUrl']->value!=null){?><?php echo $_smarty_tpl->tpl_vars['sBaseUrl']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['sPageURL']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['sPageURL']->value);?>
<?php }?>"><?php echo $_smarty_tpl->tpl_vars['iPage']->value;?>
</a></li> 
			<?php } ?>
		    <?php if (!$_smarty_tpl->tpl_vars['oPager']->value->atLastPage()){?>
				<li><a href="<?php if ($_smarty_tpl->tpl_vars['sBaseUrl']->value!=null){?><?php echo $_smarty_tpl->tpl_vars['sBaseUrl']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['oPager']->value->getNextURL();?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['oPager']->value->getNextURL());?>
<?php }?>" title="<?php echo smarty_function_loc(array('k'=>'next'),$_smarty_tpl);?>
">&rsaquo;</a></li>
				<li><a href="<?php if ($_smarty_tpl->tpl_vars['sBaseUrl']->value!=null){?><?php echo $_smarty_tpl->tpl_vars['sBaseUrl']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['oPager']->value->getLastURL();?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),$_smarty_tpl->tpl_vars['oPager']->value->getLastURL());?>
<?php }?>" title="<?php echo smarty_function_loc(array('k'=>'last'),$_smarty_tpl);?>
">&raquo;</a></li> 
			<?php }?>
	    </ul>
    </div>
<?php }?>
<?php }} ?>
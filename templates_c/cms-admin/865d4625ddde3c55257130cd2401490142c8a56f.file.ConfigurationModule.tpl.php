<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 14:54:07
         compiled from "templates/cms-admin\ConfigurationModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20570613f039f873797-11828555%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '865d4625ddde3c55257130cd2401490142c8a56f' => 
    array (
      0 => 'templates/cms-admin\\ConfigurationModule.tpl',
      1 => 1527250290,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20570613f039f873797-11828555',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'oMod' => 0,
    'sMainHelp' => 0,
    'aKey' => 0,
    'sKey' => 0,
    'sName' => 0,
    'sDomain' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f039fd374e7_53570864',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f039fd374e7_53570864')) {function content_613f039fd374e7_53570864($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
?><form action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule());?>
" method="POST" class="form-horizontal" enctype="multipart/form-data">
<div class="form-unit">
 <fieldset>
 <legend><?php echo smarty_function_loc(array('k'=>'form'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['oMod']->value->getName();?>

 	<?php if ($_smarty_tpl->tpl_vars['sMainHelp']->value!=''){?>
		<a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $_smarty_tpl->tpl_vars['sMainHelp']->value;?>
" class="help"><i class="icon-question-sign"></i></a>
	<?php }?>
 	</legend>
   <?php  $_smarty_tpl->tpl_vars['sName'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sName']->_loop = false;
 $_smarty_tpl->tpl_vars['sKey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['aKey']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sName']->key => $_smarty_tpl->tpl_vars['sName']->value){
$_smarty_tpl->tpl_vars['sName']->_loop = true;
 $_smarty_tpl->tpl_vars['sKey']->value = $_smarty_tpl->tpl_vars['sName']->key;
?>
   <div class="control-group">
	<label class="control-label" for="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
">
     		<?php if (is_array($_smarty_tpl->tpl_vars['sName']->value)){?><?php echo $_smarty_tpl->tpl_vars['sName']->value['name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['sName']->value;?>
<?php }?>
     		
     		<?php if (is_array($_smarty_tpl->tpl_vars['sName']->value)&&$_smarty_tpl->tpl_vars['sName']->value['help']!=''){?>
			<a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $_smarty_tpl->tpl_vars['sName']->value['help'];?>
" class="help"><i class="icon-question-sign"></i></a>
			<?php }?>
	</label>
	     <div class="controls">
	     	<div>
				<?php if (is_array($_smarty_tpl->tpl_vars['sName']->value)&&$_smarty_tpl->tpl_vars['sName']->value['type']=='toogle'){?>
					<select name="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
">
						<option <?php if ($_smarty_tpl->tpl_vars['oMod']->value->getConfigurationValue($_smarty_tpl->tpl_vars['sKey']->value)=='1'){?>selected=""<?php }?> value="1">Yes</option>
						<option <?php if ($_smarty_tpl->tpl_vars['oMod']->value->getConfigurationValue($_smarty_tpl->tpl_vars['sKey']->value)!='1'){?>selected=""<?php }?> value="0">No</option>
					</select>
				<?php }elseif(is_array($_smarty_tpl->tpl_vars['sName']->value)&&$_smarty_tpl->tpl_vars['sName']->value['type']!='input'){?>
					<?php if ($_smarty_tpl->tpl_vars['sName']->value['type']=='textarea'){?>
						<textarea rows="3" class="span12" name="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['sName']->value['style']!=''){?>style="<?php echo $_smarty_tpl->tpl_vars['sName']->value['style'];?>
"<?php }?>><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getConfigurationValue($_smarty_tpl->tpl_vars['sKey']->value);?>
</textarea>
					<?php }elseif($_smarty_tpl->tpl_vars['sName']->value['type']=='picture'){?>
						<input type="file" class="" name="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
"/>
						<span class="help-inline" style="margin-left: 50px"><a href="/contents/<?php echo $_smarty_tpl->tpl_vars['sDomain']->value;?>
/images/<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getConfigurationValue($_smarty_tpl->tpl_vars['sKey']->value);?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getConfigurationValue($_smarty_tpl->tpl_vars['sKey']->value);?>
</a></span>
					<?php }?>
				<?php }else{ ?>
					<input type="text" class="span12" name="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['sKey']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getConfigurationValue($_smarty_tpl->tpl_vars['sKey']->value);?>
" />
				<?php }?>
			</div>
	     </div>
	</div>   
	<?php } ?>
	<div class="form-actions">
		<input type="submit" name="save" value="<?php echo smarty_function_loc(array('k'=>'save'),$_smarty_tpl);?>
" class="btn btn-primary"/>
   </div>
 </fieldset>
</div>
</form><?php }} ?>